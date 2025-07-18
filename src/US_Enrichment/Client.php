<?php

namespace SmartyStreets\PhpSdk\US_Enrichment;

require_once(__DIR__ . '/../Exceptions/UnprocessableEntityException.php');
require_once(__DIR__ . '/Lookup.php');
require_once(__DIR__ . '/Result.php');
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use SmartyStreets\PhpSdk\Serializer;
use SmartyStreets\PhpSdk\Exceptions\SmartyException;

class Client {
    const US_ENRICHMENT_API_URL = 'https://us-enrichment.api.smarty.com';
    private $baseUrl;
    private $httpClient;
    private $requestFactory;
    private $streamFactory;
    private $serializer;

    public function __construct(ClientInterface $httpClient, RequestFactoryInterface $requestFactory, StreamFactoryInterface $streamFactory, Serializer $serializer, $baseUrl = null) {
        $this->httpClient = $httpClient;
        $this->requestFactory = $requestFactory;
        $this->streamFactory = $streamFactory;
        $this->serializer = $serializer;
        $this->baseUrl = $baseUrl ?: self::US_ENRICHMENT_API_URL;
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

    /**
     * Sends a single lookup to the US Enrichment API.
     * @param Lookup $lookup
     * @throws \SmartyStreets\PhpSdk\Exceptions\SmartyException If input is invalid, HTTP error, or response is malformed.
     */
    public function sendLookup(Lookup $lookup) {
        // Validate input: require at least one of freeform, street, city, state, or zipcode
        if ($lookup == null || (
            empty($lookup->getFreeform()) &&
            empty($lookup->getStreet()) &&
            empty($lookup->getCity()) &&
            empty($lookup->getState()) &&
            empty($lookup->getZipcode())
        )) {
            throw new SmartyException('At least one of freeform, street, city, state, or zipcode must be provided.');
        }
        $url = $this->baseUrl;
        $request = $this->requestFactory->createRequest('POST', $url)
            ->withHeader('Content-Type', 'application/json');
        $payload = $this->serializer->serialize([$lookup]);
        $stream = $this->streamFactory->createStream($payload);
        $request = $request->withBody($stream);

        $response = $this->httpClient->sendRequest($request);
        if ($response->getStatusCode() >= 400) {
            throw new SmartyException('HTTP error: ' . $response->getStatusCode());
        }
        try {
            $result = $this->serializer->deserialize((string)$response->getBody());
        } catch (\Throwable $e) {
            throw new SmartyException('Malformed JSON in API response', 0, $e);
        }
        if ($result == null || !is_array($result) || count($result) === 0) {
            $lookup->setResponse([]);
            return;
        }
        // Always wrap in Result objects
        $responseObjs = [];
        foreach ($result as $item) {
            $responseObjs[] = new Result($item);
        }
        $lookup->setResponse($responseObjs);
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