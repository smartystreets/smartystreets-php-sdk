<?php

namespace SmartyStreets\PhpSdk\US_Extract;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use SmartyStreets\PhpSdk\Serializer;
use SmartyStreets\PhpSdk\Exceptions\SmartyException;

class Client {
    const US_EXTRACT_API_URL = 'https://us-extract.api.smarty.com';
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
        $this->baseUrl = $baseUrl ?: self::US_EXTRACT_API_URL;
    }

    /**
     * Sends a single lookup to the US Extract API.
     * @param Lookup $lookup
     * @throws \SmartyStreets\PhpSdk\Exceptions\SmartyException If input is invalid, HTTP error, or response is malformed.
     */
    public function sendLookup(?Lookup $lookup = null) {
        if ($lookup == null || $lookup->getText() == null || strlen($lookup->getText()) == 0)
            throw new SmartyException("sendLookup() requires a Lookup with the 'text' field set");

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
            $lookup->setResult(new Result());
            return;
        }
        $lookup->setResult(new Result($result));
    }
}