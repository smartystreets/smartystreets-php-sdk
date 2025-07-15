<?php

namespace SmartyStreets\PhpSdk\US_ZIPCode;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use SmartyStreets\PhpSdk\Serializer;
use SmartyStreets\PhpSdk\Batch;
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
     * Sends a single lookup to the US ZIPCode API.
     * @param Lookup $lookup
     * @throws \SmartyStreets\PhpSdk\Exceptions\SmartyException If input is invalid, HTTP error, or response is malformed.
     */
    public function sendLookup(Lookup $lookup) {
        // Validate input: require at least one of city, state, or zipcode, and must be non-empty and plausible
        $city = $lookup->getCity();
        $state = $lookup->getState();
        $zip = $lookup->getZIPCode();
        if ((empty($city) || !preg_match('/^[a-zA-Z .\'-]+$/', $city)) &&
            (empty($state) || !preg_match('/^[A-Z]{2}$/', $state)) &&
            (empty($zip) || !preg_match('/^\d{5}(-\d{4})?$/', $zip))) {
            throw new SmartyException('At least one of city, state, or zipcode must be provided and valid.');
        }
        $batch = new Batch();
        $batch->add($lookup);
        $this->sendBatch($batch);
    }

    /**
     * Sends a batch of lookups to the US ZIPCode API.
     * @param Batch $batch
     * @throws \SmartyStreets\PhpSdk\Exceptions\SmartyException If batch is empty, HTTP error, or response is malformed.
     */
    public function sendBatch(Batch $batch) {
        if ($batch->size() == 0)
            throw new SmartyException('Batch must contain at least one lookup.');

        $url = '/lookup';
        $request = $this->requestFactory->createRequest('POST', $url)
            ->withHeader('Content-Type', 'application/json');
        $payload = $this->serializer->serialize($batch->getAllLookups());
        $stream = $this->streamFactory->createStream($payload);
        $request = $request->withBody($stream);

        $response = $this->httpClient->sendRequest($request);
        if ($response->getStatusCode() >= 400) {
            throw new SmartyException('HTTP error: ' . $response->getStatusCode());
        }
        try {
            $results = $this->serializer->deserialize((string)$response->getBody());
        } catch (\Throwable $e) {
            throw new SmartyException('Malformed JSON in API response', 0, $e);
        }
        if ($results == null || !is_array($results) || count($results) === 0) {
            foreach ($batch->getAllLookups() as $lookup) {
                $lookup->setResult(new Result());
            }
            return;
        }
        // Group results by input index
        $lookupResults = [];
        foreach ($results as $rawResult) {
            $result = new Result($rawResult);
            $inputIndex = $result->getInputIndex();
            $lookupResults[$inputIndex] = $result;
        }
        foreach ($batch->getAllLookups() as $i => $lookup) {
            $lookup->setResult($lookupResults[$i] ?? new Result());
        }
    }

    private function assignResultsToLookups(Batch $batch, $results) {
        foreach ($results as $rawResult) {
            $result = new Result($rawResult);
            $lookup = $batch->getLookupByIndex($result->getInputIndex());
            if ($lookup !== null) {
                $lookup->setResult($result);
            }
        }
    }
}