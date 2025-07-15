<?php

namespace SmartyStreets\PhpSdk\US_Autocomplete_Pro;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use SmartyStreets\PhpSdk\Serializer;
use SmartyStreets\PhpSdk\Exceptions\SmartyException;

class Client {
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
     * Sends a single lookup to the US Autocomplete Pro API.
     * @param Lookup $lookup
     * @throws \SmartyStreets\PhpSdk\Exceptions\SmartyException If input is invalid, HTTP error, or response is malformed.
     */
    public function sendLookup(Lookup $lookup) {
        if ($lookup == null || $lookup->getSearch() == null || strlen($lookup->getSearch()) == 0)
            throw new SmartyException("sendLookup() must be passed a Lookup with the prefix field set.");

        $url = '/autocomplete-pro';
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
            $lookup->setResult(new Result());
            throw new SmartyException('Malformed JSON in API response', 0, $e);
        }
        if ($result == null || !is_array($result)) {
            $lookup->setResult(new Result());
            return;
        }
        $lookup->setResult(new Result($result));
    }
}
