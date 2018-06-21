<?php

namespace SmartyStreets\PhpSdk\US_Street;

require_once(dirname(dirname(__FILE__)) . '/Sender.php');
require_once(dirname(dirname(__FILE__)) . '/Serializer.php');
require_once(dirname(dirname(__FILE__)) . '/Request.php');
require_once(dirname(dirname(__FILE__)) . '/Batch.php');
require_once('Candidate.php');
use SmartyStreets\PhpSdk\Exceptions\SmartyException;
use SmartyStreets\PhpSdk\Sender;
use SmartyStreets\PhpSdk\Serializer;
use SmartyStreets\PhpSdk\Request;
use SmartyStreets\PhpSdk\Batch;

/**
 * This client sends lookups to the SmartyStreets US Street API, <br>
 *     and attaches the results to the appropriate Lookup objects.
 */
class Client {
    private $sender,
            $serializer;

    public function __construct(Sender $sender, Serializer $serializer = null) {
        $this->sender = $sender;
        $this->serializer = $serializer;
    }

    /**
     * @param lookup Lookup
     * @throws SmartyException
     * @throws IOException
     */
    public function sendLookup(Lookup $lookup) {
        $batch = new Batch();
        $batch->add($lookup);
        $this->sendBatch($batch);
    }

    /**
     * Sends a batch of no more than 100 lookups.
     *
     * @param batch Batch must contain between 1 and 100 Lookup objects
     * @throws SmartyException
     * @throws IOException
     */
    public function sendBatch(Batch $batch) {
        $request = new Request();

        if ($batch->size() == 0)
            return;

        if ($batch->size() == 1)
            $this->buildParameters($request, $batch->getLookupByIndex(0));
        else
            $request->setPayload($this->serializer->serialize($batch->getAllLookups()));

        $response = $this->sender->send($request);

        $candidates = $this->serializer->deserialize($response->getPayload());
        if ($candidates == null)
            return;

        $this->assignResultsToLookups($batch, $candidates);
    }

    private function assignResultsToLookups(Batch $batch, $candidates) {
        foreach ($candidates as $c) {
            $candidate = new Candidate($c);
            $batch->getLookupByIndex($candidate->getInputIndex())->setResult($candidate);
        }
    }

    private function buildParameters(Request $request, Lookup $lookup) {
        foreach ($lookup->jsonSerialize() as $key => $value) {
            $request->setParameter($key, $value);
        }
    }
}