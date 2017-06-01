<?php

namespace SmartyStreets\PhpSdk\US_ZIPCode;

require_once(dirname(dirname(__FILE__)) . '/Sender.php');
require_once(dirname(dirname(__FILE__)) . '/Serializer.php');
require_once(dirname(dirname(__FILE__)) . '/Request.php');
require_once(dirname(dirname(__FILE__)) . '/Batch.php');
use SmartyStreets\PhpSdk\Exceptions\SmartyException;
use SmartyStreets\PhpSdk\Sender;
use SmartyStreets\PhpSdk\Serializer;
use SmartyStreets\PhpSdk\Request;
use SmartyStreets\PhpSdk\Batch;

/**
 * This client sends lookups to the SmartyStreets US ZIP Code API, <br>
 *     and attaches the results to the appropriate Lookup objects.
 */
class Client {
    private $sender,
            $serializer;

    public function __construct(Sender $sender, Serializer $serializer = null) {
        $this->sender = $sender;
        $this->serializer = $serializer;
    }

    public function sendLookup(Lookup $lookup) {
        $batch = new Batch();
        $batch->add($lookup);
        $this->sendBatch($batch);
    }

    public function sendBatch(Batch $batch) {
        $request = new Request();

        if ($batch->size() == 0)
            return;

        $request->setPayload($this->serializer->serialize($batch->getAllLookups()));

        $response = $this->sender->send($request);
        if ($response == null)
            throw new SmartyException("Response is null.");

        $results = $this->serializer->deserialize($response->getPayload());
        if ($results == null)
            return;

        $this->assignResultsToLookups($batch, $results);
    }

    private function assignResultsToLookups(Batch $batch, $results) {
        foreach ($results as $rawResult) {
            $result = new Result($rawResult);
            $batch->getLookupByIndex($result->getInputIndex())->setResult($result);
        }
    }
}