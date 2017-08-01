<?php

namespace SmartyStreets\PhpSdk\US_Autocomplete;

require_once(dirname(dirname(__FILE__)) . '/ArrayUtil.php');
require_once(dirname(dirname(__FILE__)) . '/Sender.php');
require_once(dirname(dirname(__FILE__)) . '/Serializer.php');
require_once(dirname(dirname(__FILE__)) . '/Request.php');
require_once('GeolocateType.php');
require_once('Result.php');
use SmartyStreets\PhpSdk\Exceptions\SmartyException;
use SmartyStreets\PhpSdk\Sender;
use SmartyStreets\PhpSdk\Serializer;
use SmartyStreets\PhpSdk\Request;

/**
 * This client sends lookups to the SmartyStreets US Autocomplete API, <br>
 *     and attaches the results to the appropriate Lookup objects.
 */
class Client {
    private $sender,
        $serializer;

    public function __construct(Sender $sender, Serializer $serializer = null) {
        $this->sender = $sender;
        $this->serializer = $serializer;
    }

    public function sendLookup(Lookup $lookup) {
        if ($lookup == null || $lookup->getPrefix() == null || strlen($lookup->getPrefix()) == 0)
            throw new SmartyException("sendLookup() must be passed a Lookup with the prefix field set.");

        $request = $this->buildRequest($lookup);
        $response = $this->sender->send($request);

        $result = $this->serializer->deserialize($response->getPayload());
        if ($result == null)
            return;

        $lookup->setResult((new Result($result))->getSuggestions());
    }

    private function buildRequest(Lookup $lookup) {
        $request = new Request();

        $request->setParameter("prefix", $lookup->getPrefix());
        $request->setParameter("suggestions", $lookup->getMaxSuggestionsStringIfSet());
        $request->setParameter("city_filter", $this->buildFilterString($lookup->getCityFilter()));
        $request->setParameter("state_filter", $this->buildFilterString($lookup->getStateFilter()));
        $request->setParameter("prefer", $this->buildFilterString($lookup->getPrefer()));
        $request->setParameter("prefer_ratio", $lookup->getPreferRatioStringIfSet());
        if ($lookup->getGeolocateType()->getName() != GEOLOCATE_TYPE_NONE) {
            $request->setParameter("geolocate", "true");
            $request->setParameter("geolocate_precision", $lookup->getGeolocateType()->getName());
        }
        else $request->setParameter("geolocate", "false");

        return $request;
    }

    private function buildFilterString($list) {
        if (empty($list))
            return null;

        return join(',', $list);
    }
}