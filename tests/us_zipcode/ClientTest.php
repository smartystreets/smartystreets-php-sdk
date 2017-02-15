<?php

namespace SmartyStreets\Tests\US_ZipCode;

require_once(dirname(dirname(__FILE__)) . '/Mocks/MockSerializer.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/MockDeserializer.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/RequestCapturingSender.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/MockSender.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_Zipcode/Client.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_Zipcode/Lookup.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_Zipcode/Result.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/Batch.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/Response.php');
use SmartyStreets\Tests\Mocks\MockSerializer;
use SmartyStreets\Tests\Mocks\MockDeserializer;
use SmartyStreets\Tests\Mocks\RequestCapturingSender;
use SmartyStreets\Tests\Mocks\MockSender;
use SmartyStreets\US_ZipCode\Client;
use SmartyStreets\US_ZipCode\Lookup;
use SmartyStreets\US_ZipCode\Result;
use SmartyStreets\Batch;
use SmartyStreets\Response;

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
        $rawResults = array(array('input_index' => 0), array('input_index' => 1));
        $expectedResults = array(new Result($rawResults[0]), new Result($rawResults[1]));

        $batch = new Batch();
        $batch->add(new Lookup());
        $batch->add(new Lookup());

        $sender = new MockSender(new Response(0, "[]"));
        $deserializer = new MockDeserializer($rawResults);
        $client = new Client($sender, $deserializer);

        $client->sendBatch($batch);

        $this->assertEquals($expectedResults[0], $batch->getLookupByIndex(0)->getResult());
        $this->assertEquals($expectedResults[1], $batch->getLookupByIndex(1)->getResult());
    }

    //endregion
}
