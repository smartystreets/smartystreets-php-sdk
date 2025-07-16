<?php

namespace SmartyStreets\PhpSdk\US_Street;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use SmartyStreets\PhpSdk\Serializer;
use SmartyStreets\PhpSdk\Batch;
use SmartyStreets\PhpSdk\Exceptions\SmartyException;

/**
 * This client sends lookups to the SmartyStreets US Street API, <br>
 *     and attaches the results to the appropriate Lookup objects.
 */
class Client {
    const US_STREET_API_URL = 'https://us-street.api.smarty.com/street-address';
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
     * Sends a single lookup to the US Street API.
     * @param Lookup $lookup
     * @throws \SmartyStreets\PhpSdk\Exceptions\SmartyException If input is invalid, HTTP error, or response is malformed.
     */
    public function sendLookup(Lookup $lookup) {
        // Validate input: require at least one of street, city, state, or zipcode
        if (empty($lookup->getStreet()) && empty($lookup->getCity()) && empty($lookup->getState()) && empty($lookup->getZipcode())) {
            throw new SmartyException('At least one of street, city, state, or zipcode must be provided.');
        }
        $batch = new Batch();
        $batch->add($lookup);
        $this->sendBatch($batch);
    }

    /**
     * Sends a batch of no more than 100 lookups.
     * @param Batch $batch
     * @throws \SmartyStreets\PhpSdk\Exceptions\SmartyException If batch is empty, HTTP error, or response is malformed.
     */
    public function sendBatch(Batch $batch) {
        if ($batch->size() == 0)
            throw new SmartyException('Batch must contain at least one lookup.');

        $url = self::US_STREET_API_URL;
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
            $candidates = $this->serializer->deserialize((string)$response->getBody());
        } catch (\Throwable $e) {
            throw new SmartyException('Malformed JSON in API response', 0, $e);
        }
        // Always set a flat array of Candidate objects for each lookup
        $lookupResults = [];
        if ($candidates == null || !is_array($candidates) || count($candidates) === 0) {
            foreach ($batch->getAllLookups() as $lookup) {
                $lookup->setResult([]);
            }
            return;
        }
        foreach ($candidates as $candidateData) {
            $candidate = new Candidate($candidateData);
            $inputIndex = $candidate->getInputIndex();
            if (!isset($lookupResults[$inputIndex])) {
                $lookupResults[$inputIndex] = [];
            }
            $lookupResults[$inputIndex][] = $candidate;
        }
        if ($batch->size() === 1) {
            $lookup = $batch->getAllLookups()[0];
            $res = isset($lookupResults[0]) ? $lookupResults[0] : [];
            // Forcibly flatten any array-of-arrays structure to a flat array of Candidate objects
            $flat = [];
            $stack = is_array($res) ? $res : [$res];
            while ($stack) {
                $item = array_shift($stack);
                if ($item instanceof Candidate) {
                    $flat[] = $item;
                } elseif (is_array($item)) {
                    foreach ($item as $subitem) {
                        $stack[] = $subitem;
                    }
                }
            }
            $lookup->setResult($flat);
            return;
        }
        foreach ($batch->getAllLookups() as $i => $lookup) {
            $result = isset($lookupResults[$i]) ? $lookupResults[$i] : [];
            if (is_array($result) && count($result) === 1 && is_array($result[0]) && count($result[0]) === 0) {
                $lookup->setResult([]);
            } else {
                $lookup->setResult($result);
            }
        }
    }

    private function assignResultsToLookups(Batch $batch, $candidates) {
        foreach ($candidates as $candidateData) {
            $candidate = new Candidate($candidateData);
            $lookup = $batch->getLookupByIndex($candidate->getInputIndex());
            if ($lookup !== null) {
                $lookup->setResult([$candidate]);
            }
        }
    }
}