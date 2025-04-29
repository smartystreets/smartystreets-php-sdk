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

    public function __construct(Sender $sender, ?Serializer $serializer = null) {
        $this->sender = $sender;
        $this->serializer = $serializer;
    }

    public function sendPropertyFinancialLookup($financialLookup){
        if (is_string($financialLookup)) {
            $lookup = new Lookup($financialLookup, "property", "financial");
            $this->sendLookup($lookup);
            return $lookup->getResponse();
        } 
        else if (is_object($financialLookup)) {
            $financialLookup->setDataSetName("property");
            $financialLookup->setDataSubSetName("financial");
            $this->sendLookup($financialLookup);
            return $financialLookup->getResponse();
        }
        else {
            return null;
        }
    }

    public function sendPropertyPrincipalLookup($principalLookup){
        if (is_string($principalLookup)) {
            $lookup = new Lookup($principalLookup, "property", "principal");
            $this->sendLookup($lookup);
            return $lookup->getResponse();
        }
        else if (is_object($principalLookup)) {
            $principalLookup->setDataSetName("property");
            $principalLookup->setDataSubSetName("principal");
            $this->sendLookup($principalLookup);
            return $principalLookup->getResponse();
        }
        else {
            return null;
        }
    }

    public function sendGeoReferenceLookup($geoReferenceLookup){
        if (is_string($geoReferenceLookup)) {
            $lookup = new Lookup($geoReferenceLookup, "geo-reference");
            $this->sendLookup($lookup);
            return $lookup->getResponse();
        }
        else if (is_object($geoReferenceLookup)) {
            $geoReferenceLookup->setDataSetName("geo-reference");
            $geoReferenceLookup->setDataSubSetName(null);
            $this->sendLookup($geoReferenceLookup);
            return $geoReferenceLookup->getResponse();
        }
        else {
            return null;
        }
    }

    public function sendSecondaryLookup($secondaryLookup){
        if (is_string($secondaryLookup)) {
            $lookup = new Lookup($secondaryLookup, "secondary");
            $this->sendLookup($lookup);
            return $lookup->getResponse();
        }
        else if (is_object($secondaryLookup)) {
            $secondaryLookup->setDataSetName("secondary");
            $secondaryLookup->setDataSubSetName(null);
            $this->sendLookup($secondaryLookup);
            return $secondaryLookup->getResponse();
        }
        else {
            return null;
        }
    }

    public function sendSecondaryCountLookup($secondaryCountLookup){
        if (is_string($secondaryCountLookup)) {
            $lookup = new Lookup($secondaryCountLookup, "secondary", "count");
            $this->sendLookup($lookup);
            return $lookup->getResponse();
        }
        else if (is_object($secondaryCountLookup)) {
            $secondaryCountLookup->setDataSetName("secondary");
            $secondaryCountLookup->setDataSubSetName("count");
            $this->sendLookup($secondaryCountLookup);
            return $secondaryCountLookup->getResponse();
        }
        else {
            return null;
        }
    }

    public function sendGenericLookup($genericLookup, $dataSetName, $dataSubsetName){
        if (is_string($genericLookup)) {
            $lookup = new Lookup($genericLookup, $dataSetName, $dataSubsetName);
            $this->sendLookup($lookup);
            return $lookup->getResponse();
        }
        else if (is_object($genericLookup)) {
            $genericLookup->setDataSetName($dataSetName);
            $genericLookup->setDataSubSetName($dataSubsetName);
            $this->sendLookup($genericLookup);
            return $genericLookup->getResponse();
        }
        else {
            return null;
        }
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

        if ($lookup->getSmartyKey() == null) {
            $request->setParameter("freeform", $lookup->getFreeform());
            $request->setParameter("street", $lookup->getStreet());
            $request->setParameter("city", $lookup->getCity());
            $request->setParameter("state", $lookup->getState());
            $request->setParameter("zipcode", $lookup->getZipcode());
        }

        $request->setParameter("include", $this->buildFilterString($lookup->getIncludeArray()));
        $request->setParameter("exclude", $this->buildFilterString($lookup->getExcludeArray()));

        foreach ($lookup->getCustomParamArray() as $key => $value) {
            $request->setParameter($key, $value);
        }

        return $request;
    }

    private function getUrlPrefix($lookup){
        if ($lookup->getSmartyKey() == null) {
            if ($lookup->getDataSubsetName() == null) {
                return "search/" . $lookup->getDataSetName();
            }
            return "search/" . $lookup->getDataSetName() . "/" . $lookup->getDataSubsetName();
        }
        else {
            if ($lookup->getDataSubsetName() == null) {
                return $lookup->getSmartyKey() . "/" . $lookup->getDataSetName();
            }
            return $lookup->getSmartyKey() . "/" . $lookup->getDataSetName() . "/" . $lookup->getDataSubsetName();
        }
    }

    private function buildFilterString($list) {
        if (empty($list))
            return null;

        return join(',', $list);
    }
}