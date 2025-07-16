<?php

namespace SmartyStreets\PhpSdk\International_Street;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use SmartyStreets\PhpSdk\Serializer;
use SmartyStreets\PhpSdk\Exceptions\SmartyException;

/**
 * This client sends lookups to the SmartyStreets International Street API, <br>
 *     and attaches the results to the appropriate Lookup objects.
 */
class Client {
    const INTERNATIONAL_STREET_API_URL = 'https://international-street.api.smarty.com';
    private $httpClient;
    private $requestFactory;
    private $streamFactory;
    private $serializer;

    public function __construct(ClientInterface $httpClient, RequestFactoryInterface $requestFactory, StreamFactoryInterface $streamFactory, Serializer $serializer) {
        $this->httpClient = $httpClient;
        $this->requestFactory = $requestFactory;
        $this->streamFactory = $streamFactory;
        $this->serializer = $serializer;
    }

    /**
     * Sends a single lookup to the International Street API.
     * @param Lookup $lookup
     * @throws \SmartyStreets\PhpSdk\Exceptions\SmartyException If input is invalid, HTTP error, or response is malformed.
     */
    public function sendLookup(Lookup $lookup) {
        try {
            $this->ensureEnoughInfo($lookup);
        } catch (\Throwable $e) {
            throw new SmartyException($e->getMessage(), 0, $e);
        }
        $url = self::INTERNATIONAL_STREET_API_URL;
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
            $candidates = $this->serializer->deserialize((string)$response->getBody());
        } catch (\Throwable $e) {
            throw new SmartyException('Malformed JSON in API response', 0, $e);
        }
        if ($candidates == null || !is_array($candidates) || count($candidates) === 0) {
            $lookup->setResult([]);
            return;
        }
        $result = array();
        foreach ($candidates as $c) {
            $candidate = new Candidate($c);
            $result[] = $candidate;
        }
        $lookup->setResult($result);
    }

    private function assignResultsToLookup(Lookup $lookup, $candidates) {
        $result = array();

        foreach ($candidates as $c) {
            $candidate = new Candidate($c);
            $result[] = $candidate;
        }

        $lookup->setResult($result);
    }

    private function ensureEnoughInfo(Lookup $lookup) {
        if ($lookup->missingCountry())
            throw new SmartyException("Country field is required.");

        if ($lookup->hasFreeform())
            return;

        if ($lookup->missingAddress1())
            throw new SmartyException("Either freeform or address1 is required.");

        if ($lookup->hasPostalCode())
            return;

        if ($lookup->missingLocalityOrAdministrativeArea())
            throw new SmartyException("Insufficient information: One or more required fields were not set on the lookup.");
    }
}