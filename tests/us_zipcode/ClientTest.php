<?php

namespace us_zipcode;

require_once(dirname(dirname(__FILE__)) . '/mocks/MockSerializer.php');
require_once(dirname(dirname(__FILE__)) . '/mocks/MockDeserializer.php');
require_once(dirname(dirname(__FILE__)) . '/mocks/RequestCapturingSender.php');
require_once(dirname(dirname(__FILE__)) . '/mocks/MockSender.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/smartystreets/api/us_zipcode/Client.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/smartystreets/api/us_zipcode/Lookup.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/smartystreets/api/us_zipcode/Batch.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/smartystreets/api/us_zipcode/Result.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/smartystreets/api/Response.php');
use mocks\MockDeserializer;
use mocks\MockSender;
use mocks\MockSerializer;
use mocks\RequestCapturingSender;
use smartystreets\api\us_zipcode\Client;
use smartystreets\api\us_zipcode\Lookup;
use smartystreets\api\us_zipcode\Batch;
use smartystreets\api\us_zipcode\Result;
use smartystreets\api\Response;

class ClientTest extends \PHPUnit_Framework_TestCase {

    //region [ Single Lookup ]

    public function testSendingSingleZipOnlyLookup() {
        $sender = new RequestCapturingSender();
        $serializer = new MockSerializer(null);
        $client = new Client("http://localhost/", $sender, $serializer);

        $client->sendLookup(new Lookup(null, null, "1"));
        $this->assertEquals("http://localhost/?zipcode=1", $sender->getRequest()->getUrl());
    }

    public function testSendingSingleFullyPopulatedLookup() {
        $sender = new RequestCapturingSender();
        $serializer = new MockSerializer(null);
        $client = new Client("http://localhost/", $sender, $serializer);
        $lookup = new Lookup();
        $lookup->setCity("1");
        $lookup->setState("2");
        $lookup->setZipcode("3");

        $client->sendLookup($lookup);

        $this->assertEquals("http://localhost/?city=1&state=2&zipcode=3", $sender->getRequest()->getUrl());
    }

    //endregion

    //region [Batch Lookup ]

    public function testEmptyBatchNotSent() {
        $sender = new RequestCapturingSender();
        $client = new Client("/", $sender, null);

        $client->sendBatch(new Batch());

        $this->assertNull($sender->getRequest());
    }

    public function testSuccessfullySendsBatchOfLookups() {
        $expectedPayload = "Hello, World!";
        $sender = new RequestCapturingSender();
        $serializer = new MockSerializer($expectedPayload);
        $client = new Client("http://localhost/", $sender, $serializer);
        $batch = new Batch();
        $batch->add(new Lookup());
        $batch->add(new Lookup());

        $client->sendBatch($batch);

        $this->assertEquals($expectedPayload, $sender->getRequest()->getPayload());
    }

    //endregion

    //region [ Response Handling ]

    public function testDeserializeCalledWithResponseBody() {
        $response = new Response(0, "Hello, World!");
        $sender = new MockSender($response);
        $deserializer = new MockDeserializer(null);
        $client = new Client("/", $sender, $deserializer);

        $client->sendLookup(new Lookup());

        $this->assertEquals($response->getPayload(), $deserializer->getPayload());
    }

    public function testCandidatesCorrectlyAssignedToCorrespondingLookup() {
        $expectedCandidates = array();
        $expectedCandidates[0] = new Result();
        $expectedCandidates[1] = new Result();
        $batch = new Batch();
        $batch->add(new Lookup());
        $batch->add(new Lookup());

        $sender = new MockSender(new Response(0, "[]"));
        $deserializer = new MockDeserializer($expectedCandidates);
        $client = new Client("/", $sender, $deserializer);

        $client->sendBatch($batch);

        $this->assertEquals($expectedCandidates[0], $batch->getLookupByIndex(0)->getResult());
        $this->assertEquals($expectedCandidates[1], $batch->getLookupByIndex(1)->getResult());
    }

    //endregion
}
