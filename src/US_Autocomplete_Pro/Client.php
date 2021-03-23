<?php

namespace SmartyStreets\PhpSdk\US_Autocomplete_Pro;

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
 * This client sends lookups to the SmartyStreets US Autocomplete Pro API, <br>
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
        if ($lookup == null || $lookup->getSearch() == null || strlen($lookup->getSearch()) == 0)
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

        $request->setParameter("search", $lookup->getSearch());
        $request->setParameter("max_results", $lookup->getMaxResultsStringIfSet());
        $request->setParameter("include_only_cities", $this->buildFilterString($lookup->getCityFilter()));
        $request->setParameter("include_only_states", $this->buildFilterString($lookup->getStateFilter()));
        $request->setParameter("include_only_zip_codes", $this->buildFilterString($lookup->getZIPFilter()));
        $request->setParameter("exclude_states", $this->buildFilterString($lookup->getStateExclusions()));
        $request->setParameter("prefer_cities", $this->buildFilterString($lookup->getPreferCities()));
        $request->setParameter("prefer_states", $this->buildFilterString($lookup->getPreferStates()));
        $request->setParameter("prefer_zip_codes", $this->buildFilterString($lookup->getPreferZIPCodes()));
        $request->setParameter("prefer_ratio", $lookup->getPreferRatioStringIfSet());
        $request->setParameter("prefer_geolocation", $lookup->getGeolocateType()->getName());
        $request->setParameter("selected", $lookup->getSelected());

        return $request;
    }

    private function buildFilterString($list) {
        if (empty($list))
            return null;

        return join(',', $list);
    }
}