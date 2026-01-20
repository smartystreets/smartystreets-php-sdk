<?php

namespace SmartyStreets\PhpSdk\US_Enrichment;

require_once(__DIR__ . '/../Exceptions/UnprocessableEntityException.php');
require_once(__DIR__ . '/../Sender.php');
require_once(__DIR__ . '/../Serializer.php');
require_once(__DIR__ . '/../Request.php');
require_once(__DIR__ . '/Lookup.php');
require_once(__DIR__ . '/Result.php');
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

    public function sendPropertyPrincipalLookup($principalLookup){
        return $this->sendPropertyPrincipalLookupWithAuth($principalLookup, null, null);
    }

    /**
     * Sends a property principal lookup with per-request credentials.
     * If authId and authToken are both non-empty, they will be used for this request
     * instead of the client-level credentials. This is useful for multi-tenant scenarios
     * where different requests require different credentials.
     *
     * @param principalLookup string|Lookup
     * @param authId string|null Per-request auth ID
     * @param authToken string|null Per-request auth token
     * @return array|null
     */
    public function sendPropertyPrincipalLookupWithAuth($principalLookup, $authId = null, $authToken = null){
        if (is_string($principalLookup)) {
            $lookup = new Lookup($principalLookup, "property", "principal");
            $this->sendLookupWithAuth($lookup, $authId, $authToken);
            return $lookup->getResponse();
        }
        else if (is_object($principalLookup)) {
            $principalLookup->setDataSetName("property");
            $principalLookup->setDataSubSetName("principal");
            $this->sendLookupWithAuth($principalLookup, $authId, $authToken);
            return $principalLookup->getResponse();
        }
        else {
            return null;
        }
    }

    public function sendGeoReferenceLookup($geoReferenceLookup){
        return $this->sendGeoReferenceLookupWithAuth($geoReferenceLookup, null, null);
    }

    /**
     * Sends a geo reference lookup with per-request credentials.
     * If authId and authToken are both non-empty, they will be used for this request
     * instead of the client-level credentials. This is useful for multi-tenant scenarios
     * where different requests require different credentials.
     *
     * @param geoReferenceLookup string|Lookup
     * @param authId string|null Per-request auth ID
     * @param authToken string|null Per-request auth token
     * @return array|null
     */
    public function sendGeoReferenceLookupWithAuth($geoReferenceLookup, $authId = null, $authToken = null){
        if (is_string($geoReferenceLookup)) {
            $lookup = new Lookup($geoReferenceLookup, "geo-reference");
            $this->sendLookupWithAuth($lookup, $authId, $authToken);
            return $lookup->getResponse();
        }
        else if (is_object($geoReferenceLookup)) {
            $geoReferenceLookup->setDataSetName("geo-reference");
            $geoReferenceLookup->setDataSubSetName(null);
            $this->sendLookupWithAuth($geoReferenceLookup, $authId, $authToken);
            return $geoReferenceLookup->getResponse();
        }
        else {
            return null;
        }
    }

    public function sendRiskLookup($riskLookup){
        return $this->sendRiskLookupWithAuth($riskLookup, null, null);
    }

    /**
     * Sends a risk lookup with per-request credentials.
     * If authId and authToken are both non-empty, they will be used for this request
     * instead of the client-level credentials. This is useful for multi-tenant scenarios
     * where different requests require different credentials.
     *
     * @param riskLookup string|Lookup
     * @param authId string|null Per-request auth ID
     * @param authToken string|null Per-request auth token
     * @return array|null
     */
    public function sendRiskLookupWithAuth($riskLookup, $authId = null, $authToken = null){
        if (is_string($riskLookup)) {
            $lookup = new Lookup($riskLookup, "risk");
            $this->sendLookupWithAuth($lookup, $authId, $authToken);
            return $lookup->getResponse();
        }
        else if (is_object($riskLookup)) {
            $riskLookup->setDataSetName("risk");
            $riskLookup->setDataSubSetName(null);
            $this->sendLookupWithAuth($riskLookup, $authId, $authToken);
            return $riskLookup->getResponse();
        }
        else {
            return null;
        }
    }

    public function sendSecondaryLookup($secondaryLookup){
        return $this->sendSecondaryLookupWithAuth($secondaryLookup, null, null);
    }

    /**
     * Sends a secondary lookup with per-request credentials.
     * If authId and authToken are both non-empty, they will be used for this request
     * instead of the client-level credentials. This is useful for multi-tenant scenarios
     * where different requests require different credentials.
     *
     * @param secondaryLookup string|Lookup
     * @param authId string|null Per-request auth ID
     * @param authToken string|null Per-request auth token
     * @return array|null
     */
    public function sendSecondaryLookupWithAuth($secondaryLookup, $authId = null, $authToken = null){
        if (is_string($secondaryLookup)) {
            $lookup = new Lookup($secondaryLookup, "secondary");
            $this->sendLookupWithAuth($lookup, $authId, $authToken);
            return $lookup->getResponse();
        }
        else if (is_object($secondaryLookup)) {
            $secondaryLookup->setDataSetName("secondary");
            $secondaryLookup->setDataSubSetName(null);
            $this->sendLookupWithAuth($secondaryLookup, $authId, $authToken);
            return $secondaryLookup->getResponse();
        }
        else {
            return null;
        }
    }

    public function sendSecondaryCountLookup($secondaryCountLookup){
        return $this->sendSecondaryCountLookupWithAuth($secondaryCountLookup, null, null);
    }

    /**
     * Sends a secondary count lookup with per-request credentials.
     * If authId and authToken are both non-empty, they will be used for this request
     * instead of the client-level credentials. This is useful for multi-tenant scenarios
     * where different requests require different credentials.
     *
     * @param secondaryCountLookup string|Lookup
     * @param authId string|null Per-request auth ID
     * @param authToken string|null Per-request auth token
     * @return array|null
     */
    public function sendSecondaryCountLookupWithAuth($secondaryCountLookup, $authId = null, $authToken = null){
        if (is_string($secondaryCountLookup)) {
            $lookup = new Lookup($secondaryCountLookup, "secondary", "count");
            $this->sendLookupWithAuth($lookup, $authId, $authToken);
            return $lookup->getResponse();
        }
        else if (is_object($secondaryCountLookup)) {
            $secondaryCountLookup->setDataSetName("secondary");
            $secondaryCountLookup->setDataSubSetName("count");
            $this->sendLookupWithAuth($secondaryCountLookup, $authId, $authToken);
            return $secondaryCountLookup->getResponse();
        }
        else {
            return null;
        }
    }

    public function sendGenericLookup($genericLookup, $dataSetName, $dataSubsetName){
        return $this->sendGenericLookupWithAuth($genericLookup, $dataSetName, $dataSubsetName, null, null);
    }

    /**
     * Sends a generic lookup with per-request credentials.
     * If authId and authToken are both non-empty, they will be used for this request
     * instead of the client-level credentials. This is useful for multi-tenant scenarios
     * where different requests require different credentials.
     *
     * @param genericLookup string|Lookup
     * @param dataSetName string
     * @param dataSubsetName string
     * @param authId string|null Per-request auth ID
     * @param authToken string|null Per-request auth token
     * @return array|null
     */
    public function sendGenericLookupWithAuth($genericLookup, $dataSetName, $dataSubsetName, $authId = null, $authToken = null){
        if (is_string($genericLookup)) {
            $lookup = new Lookup($genericLookup, $dataSetName, $dataSubsetName);
            $this->sendLookupWithAuth($lookup, $authId, $authToken);
            return $lookup->getResponse();
        }
        else if (is_object($genericLookup)) {
            $genericLookup->setDataSetName($dataSetName);
            $genericLookup->setDataSubSetName($dataSubsetName);
            $this->sendLookupWithAuth($genericLookup, $authId, $authToken);
            return $genericLookup->getResponse();
        }
        else {
            return null;
        }
    }

    private function sendLookup(Lookup $lookup) {
        $this->sendLookupWithAuth($lookup, null, null);
    }

    /**
     * Sends a lookup with per-request credentials.
     * If authId and authToken are both non-empty, they will be used for this request
     * instead of the client-level credentials. This is useful for multi-tenant scenarios
     * where different requests require different credentials.
     *
     * @param lookup Lookup
     * @param authId string|null Per-request auth ID
     * @param authToken string|null Per-request auth token
     */
    private function sendLookupWithAuth(Lookup $lookup, $authId = null, $authToken = null) {
        $request = $this->buildRequest($lookup);

        if (!empty($authId) && !empty($authToken)) {
            $request->setBasicAuth($authId, $authToken);
        }

        $response = $this->sender->send($request);

        $results = $this->buildResults($this->serializer->deserialize($response->getPayload()));
        $headers = $response->getHeaders();
        if (count($results) > 0 && is_array($headers) && isset($headers['etag']) ) {
            $results[0]->setETag($headers['etag']);
        }

        $lookup->setResponse($results);
    }

    private function buildResults($objArray){
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

        $request->setUrlComponents("/lookup/". $this->getUrlPrefix($lookup));

        if ($lookup->getSmartyKey() == null) {
            $request->setParameter("freeform", $lookup->getFreeform());
            $request->setParameter("street", $lookup->getStreet());
            $request->setParameter("city", $lookup->getCity());
            $request->setParameter("state", $lookup->getState());
            $request->setParameter("zipcode", $lookup->getZipcode());
        }

        $request->setParameter("include", $this->buildFilterString($lookup->getIncludeArray()));
        $request->setParameter("exclude", $this->buildFilterString($lookup->getExcludeArray()));
        $request->setParameter("features", $lookup->getFeatures());
        $request->setHeader("etag", $lookup->getETag());

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