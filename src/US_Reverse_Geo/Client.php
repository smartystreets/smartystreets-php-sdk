<?php

namespace SmartyStreets\PhpSdk\US_Reverse_Geo;

require_once(__DIR__ . '/../Exceptions/UnprocessableEntityException.php');
require_once(__DIR__ . '/../Sender.php');
require_once(__DIR__ . '/../Serializer.php');
require_once(__DIR__ . '/../Request.php');
require_once(__DIR__ . '/../Batch.php');
require_once(__DIR__ . '/Response.php');
use SmartyStreets\PhpSdk\Sender;
use SmartyStreets\PhpSdk\Serializer;
use SmartyStreets\PhpSdk\Request;

/**
 * This client sends lookups to the SmartyStreets US Reverse Geocoding API, <br>
 *     and attaches the results to the appropriate Lookup objects.
 */
class Client {
    private $sender,
            $serializer;

    public function __construct(Sender $sender, ?Serializer $serializer = null) {
        $this->sender = $sender;
        $this->serializer = $serializer;
    }

    public function sendLookup(Lookup $lookup) {
        $request = $this->buildRequest($lookup);
        $response = $this->sender->send($request);

        $lookupResponse = new Response($this->serializer->deserialize($response->getPayload()));

        $lookup->setResponse($lookupResponse);
    }


    private function buildRequest(Lookup $lookup) {
        $request = new Request();

        $request->setUrlComponents("/lookup");

        $request->setParameter("latitude", $lookup->getLatitude());
        $request->setParameter("longitude", $lookup->getLongitude());
        $request->setParameter("source", $lookup->getSource());

        foreach ($lookup->getCustomParamArray() as $key => $value) {
            $request->setParameter($key, $value);
        }

        return $request;
    }
}