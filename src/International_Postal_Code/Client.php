<?php

namespace SmartyStreets\PhpSdk\International_Postal_Code;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use SmartyStreets\PhpSdk\Serializer;
use SmartyStreets\PhpSdk\Exceptions\SmartyException;

/**
 * This client sends lookups to the SmartyStreets International Postal Code API, <br>
 *     and attaches the results to the appropriate Lookup objects.
 */
class Client {
    const INTERNATIONAL_POSTAL_CODE_API_URL = 'https://international-postal-code.api.smarty.com';
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
        $this->baseUrl = $baseUrl ?: self::INTERNATIONAL_POSTAL_CODE_API_URL;
    }

    /**
     * Sends a single lookup to the International Postal Code API.
     * @param Lookup|null $lookup
     * @throws \SmartyStreets\PhpSdk\Exceptions\SmartyException If input is invalid, HTTP error, or response is malformed.
     */
    public function sendLookup(?Lookup $lookup) {
        if ($lookup == null) {
            throw new SmartyException('lookup cannot be null');
        }

        $queryParams = array();
        $lookup->populateQuery($queryParams);

        $url = $this->baseUrl . '/lookup';
        if (!empty($queryParams)) {
            $url .= '?' . http_build_query($queryParams);
        }

        $request = $this->requestFactory->createRequest('GET', $url);

        $response = $this->httpClient->sendRequest($request);
        if ($response->getStatusCode() >= 400) {
            throw new SmartyException('HTTP error: ' . $response->getStatusCode());
        }
        try {
            $candidates = $this->serializer->deserialize((string)$response->getBody());
        } catch (\Throwable $e) {
            throw new SmartyException('Malformed JSON in API response', 0, $e);
        }
        if ($candidates == null || !is_array($candidates) || count($candidates) === 0) {
            $lookup->setResults([]);
            return;
        }
        $result = array();
        foreach ($candidates as $c) {
            $candidate = new Candidate($c);
            $result[] = $candidate;
        }
        $lookup->setResults($result);
    }
}

