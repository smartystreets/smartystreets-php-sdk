<?php

namespace SmartyStreets\PhpSdk\US_ZIPCode;

require_once(dirname(dirname(__FILE__)) . '/Sender.php');
require_once(dirname(dirname(__FILE__)) . '/Serializer.php');
require_once(dirname(dirname(__FILE__)) . '/Request.php');
require_once(dirname(dirname(__FILE__)) . '/Batch.php');
use SmartyStreets\PhpSdk\Sender;
use SmartyStreets\PhpSdk\Serializer;
use SmartyStreets\PhpSdk\Request;
use SmartyStreets\PhpSdk\Batch;

class Client {
    private $sender,
            $serializer,
            $referer;

    public function __construct(Sender $sender, Serializer $serializer = null, $referer = null) {
        $this->sender = $sender;
        $this->serializer = $serializer;
        $this->referer = $referer;
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
        $request->setReferer($this->referer);

        $response = $this->sender->send($request);

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