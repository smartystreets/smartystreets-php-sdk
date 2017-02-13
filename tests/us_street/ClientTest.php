<?php

require_once(dirname(dirname(__FILE__)) . '/mocks/MockSerializer.php');
require_once(dirname(dirname(__FILE__)) . '/mocks/MockDeserializer.php');
require_once(dirname(dirname(__FILE__)) . '/mocks/RequestCapturingSender.php');
require_once(dirname(dirname(__FILE__)) . '/mocks/MockSender.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/smartystreets/api/us_street/Client.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/smartystreets/api/us_street/Lookup.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/smartystreets/api/us_street/Candidate.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/smartystreets/api/Batch.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/smartystreets/api/Response.php');
use mocks\MockSerializer;
use mocks\MockDeserializer;
use mocks\RequestCapturingSender;
use mocks\MockSender;
use smartystreets\api\us_street\Client;
use smartystreets\api\us_street\Lookup;
use smartystreets\api\us_street\Candidate;
use smartystreets\api\Batch;
use smartystreets\api\Response;

class ClientTest extends \PHPUnit_Framework_TestCase {

    //region [Batch Lookup ]

    public function testEmptyBatchNotSent() {
        $sender = new RequestCapturingSender();
        $client = new Client($sender, null);

        $client->sendBatch(new Batch());

        $this->assertNull($sender->getRequest());
    }

    public function testSuccessfullySendsBatchOfLookups() {
        $expectedPayload = "Hello, World!";
        $sender = new RequestCapturingSender();
        $serializer = new MockSerializer($expectedPayload);
        $client = new Client($sender, $serializer);
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
        $client = new Client($sender, $deserializer);

        $client->sendLookup(new Lookup());

        $this->assertEquals($response->getPayload(), $deserializer->getPayload());
    }

    public function testCandidatesCorrectlyAssignedToCorrespondingLookup() {
        $rawResults = array(array('input_index' => 0, 'candidate_index' => 0), array('input_index' => 1, 'candidate_index' => 1));
        $expectedResults = array(new Candidate($rawResults[0]), new Candidate($rawResults[1]));

        $batch = new Batch();
        $batch->add(new Lookup());
        $batch->add(new Lookup());

        $sender = new MockSender(new Response(0, "[]"));
        $deserializer = new MockDeserializer($rawResults);
        $client = new Client($sender, $deserializer);

        $client->sendBatch($batch);

        $this->assertEquals($expectedResults[0], $batch->getLookupByIndex(0)->getResult()[0]);
        $this->assertEquals($expectedResults[1], $batch->getLookupByIndex(1)->getResult()[0]);
    }

    //endregion

}
