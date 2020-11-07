<?php

namespace SmartyStreets\PhpSdk\US_Reverse_Geo;

require_once(dirname(dirname(__FILE__)) . '/Exceptions/UnprocessableEntityException.php');
require_once(dirname(dirname(__FILE__)) . '/Sender.php');
require_once(dirname(dirname(__FILE__)) . '/Serializer.php');
require_once(dirname(dirname(__FILE__)) . '/Request.php');
require_once(dirname(dirname(__FILE__)) . '/Batch.php');
require_once('Response.php');
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

    public function __construct(Sender $sender, Serializer $serializer = null) {
        $this->sender = $sender;
        $this->serializer = $serializer;
    }

    public function sendLookup(Lookup $lookup) {
        $request = $this->buildRequest($lookup);
        $response = $this->sender->send($request);

        echo($response->getPayload());
        $lookupResponse = new Response($this->serializer->deserialize($response->getPayload()));

        $lookup->setResponse($lookupResponse);
    }


    private function buildRequest(Lookup $lookup) {
        $request = new Request();

        $request->setParameter("latitude", $lookup->getLatitude());
        $request->setParameter("longitude", $lookup->getLongitude());

        return $request;
    }
}