<?php

namespace SmartyStreets\PhpSdk\US_Enrichment;

require_once(dirname(dirname(__FILE__)) . '/Exceptions/UnprocessableEntityException.php');
require_once(dirname(dirname(__FILE__)) . '/Sender.php');
require_once(dirname(dirname(__FILE__)) . '/Serializer.php');
require_once(dirname(dirname(__FILE__)) . '/Request.php');
require_once('Response.php');
require_once('Lookup.php');
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

    public function sendPropertyFinancialLookup($smartyKey){
        $lookup = new Lookup($smartyKey, "property", "financial");
        $this->sendLookup($lookup);
        return $lookup->getResponse();
    }

    public function sendPropertyPrincipalLookup($smartyKey){
        $lookup = new Lookup($smartyKey, "property", "principal");
        $this->sendLookup($lookup);
        return $lookup->getResponse();
    }

    private function sendLookup(Lookup $lookup) {
        $request = $this->buildRequest($lookup);
        $response = $this->sender->send($request);

        echo($response->getPayload());
        $lookupResponse = $this->buildResponse($this->serializer->deserialize($response->getPayload()));

        $lookup->setResponse($lookupResponse);
    }

    private function buildResponse($objArray){
        $response = []
        foreach($objArray as $result) {
            $response[] = new Result($result);
        }
    }


    private function buildRequest(Lookup $lookup) {
        $request = new Request();

        $request->setUrlPrefix($this->getUrlPrefix($lookup));

        return $request;
    }

    private function getUrlPrefix($lookup){
        return "/" . $lookup->getSmartyKey() . "/" . $lookup->getDataSetName() . "/" . $lookup->getDataSubsetName();
    }
}