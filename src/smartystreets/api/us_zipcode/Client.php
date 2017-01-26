<?php

namespace smartystreets\api\us_zipcode;

require_once(dirname(dirname(dirname(__FILE__))) . '/api/Sender.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/api/Serializer.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/api/Request.php');
require_once('Batch.php');
use smartystreets\api\Sender;
use smartystreets\api\Serializer;
use smartystreets\api\Request;

class Client {
    private $urlPrefix,
            $sender,
            $serializer;

    public function __construct($urlPrefix, Sender $sender, Serializer $serializer = null) {
        $this->urlPrefix = $urlPrefix;
        $this->sender = $sender;
        $this->serializer = $serializer;
    }

    public function sendLookup(Lookup $lookup) {
        $batch = new Batch();
        $batch->add($lookup);
        $this->sendBatch($batch);
    }

    public function sendBatch(Batch $batch) {
        $request = new Request($this->urlPrefix);

        if ($batch->size() == 0)
            return;

        if ($batch->size() == 1)
            $this->populateQueryString($batch->getLookupByIndex(0), $request);
        else
            $request->setPayload($this->serializer->serialize($batch->getAllLookups()));

        $response = $this->sender->send($request);

        $results = $this->serializer->deserialize($response->getPayload());
        if ($results == null) {
            $results = array();
            $results[0] = new Result();
        }

        $this->assignResultsToLookups($batch, $results);
    }

    private function populateQueryString(Lookup $lookup, Request $request) {
        $request->setParameter("input_id", $lookup->getInputId());
        $request->setParameter("city", $lookup->getCity());
        $request->setParameter("state", $lookup->getState());
        $request->setParameter("zipcode", $lookup->getZipCode());
    }

    private function assignResultsToLookups(Batch $batch, $results) {

    }

}