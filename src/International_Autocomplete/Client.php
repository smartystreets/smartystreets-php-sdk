<?php

namespace SmartyStreets\PhpSdk\International_Autocomplete;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use SmartyStreets\PhpSdk\Serializer;
use SmartyStreets\PhpSdk\Exceptions\SmartyException;

class Client {
    const INTERNATIONAL_AUTOCOMPLETE_API_URL = 'https://international-autocomplete.api.smarty.com';
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
     * Sends a single lookup to the International Autocomplete API.
     * @param Lookup $lookup
     * @throws \SmartyStreets\PhpSdk\Exceptions\SmartyException If input is invalid, HTTP error, or response is malformed.
     */
    public function sendLookup(Lookup $lookup) {
        // Validate input: require search string
        if ($lookup == null || $lookup->getSearch() == null || strlen($lookup->getSearch()) == 0) {
            throw new SmartyException('sendLookup() must be passed a Lookup with the search field set.');
        }
        $url = self::INTERNATIONAL_AUTOCOMPLETE_API_URL;
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
            $lookup->setResult(new Result());
            return;
        }
        $lookup->setResult(new Result($result));
    }
}