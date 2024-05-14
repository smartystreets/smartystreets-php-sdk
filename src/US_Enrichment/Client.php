<?php

namespace SmartyStreets\PhpSdk\US_Enrichment;

require_once(dirname(dirname(__FILE__)) . '/Exceptions/UnprocessableEntityException.php');
require_once(dirname(dirname(__FILE__)) . '/Sender.php');
require_once(dirname(dirname(__FILE__)) . '/Serializer.php');
require_once(dirname(dirname(__FILE__)) . '/Request.php');
require_once('Lookup.php');
require_once('Result.php');
use SmartyStreets\PhpSdk\Sender;
use SmartyStreets\PhpSdk\Serializer;
use SmartyStreets\PhpSdk\Request;

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
        
        $lookupResponse = $this->buildResponse($this->serializer->deserialize($response->getPayload()));

        $lookup->setResponse($lookupResponse);
    }

    private function buildResponse($objArray){
        $response = [];
        if($objArray == null){
            return $response;
        }
        foreach($objArray as $result) {
            $response[] = new Result($result);
        }
        return $response;
    }


    private function buildRequest(Lookup $lookup) {
        $request = new Request();

        $request->setUrlComponents($this->getUrlPrefix($lookup));

        return $request;
    }

    private function getUrlPrefix($lookup){
        return $lookup->getSmartyKey() . "/" . $lookup->getDataSetName() . "/" . $lookup->getDataSubsetName();
    }
}