<?php

namespace SmartyStreets\PhpSdk\International_Autocomplete;

require_once(dirname(dirname(__FILE__)) . '/ArrayUtil.php');
require_once(dirname(dirname(__FILE__)) . '/Sender.php');
require_once(dirname(dirname(__FILE__)) . '/Serializer.php');
require_once(dirname(dirname(__FILE__)) . '/Request.php');
require_once('Result.php');
use SmartyStreets\PhpSdk\Exceptions\SmartyException;
use SmartyStreets\PhpSdk\Sender;
use SmartyStreets\PhpSdk\Serializer;
use SmartyStreets\PhpSdk\Request;

/**
 * This client sends lookups to the SmartyStreets International Autocomplete API, <br>
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

        $lookup->setResult((new Result($result))->getCandidates());
    }

    private function buildRequest(Lookup $lookup) {
        $request = new Request();

        $request->setParameter("country", $lookup->getCountry());
        $request->setParameter("search", $lookup->getSearch());
        $request->setParameter("max_results", $lookup->getMaxResults());
        $request->setParameter("include_only_administrative_area", $lookup->getAdministrativeArea());
        $request->setParameter("include_only_locality", $lookup->getLocality());
        $request->setParameter("include_only_postal_code", $lookup->getPostalCode());

        return $request;
    }
}