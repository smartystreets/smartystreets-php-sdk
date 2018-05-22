<?php

namespace SmartyStreets\PhpSdk\Tests\US_ZIPCode;

require_once(dirname(dirname(__FILE__)) . '/Mocks/MockSerializer.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/MockDeserializer.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/RequestCapturingSender.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/MockSender.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_ZIPCode/Client.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_ZIPCode/Lookup.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_ZIPCode/Result.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/Batch.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/Response.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/URLPrefixSender.php');
use SmartyStreets\PhpSdk\Tests\Mocks\MockSerializer;
use SmartyStreets\PhpSdk\Tests\Mocks\MockDeserializer;
use SmartyStreets\PhpSdk\Tests\Mocks\RequestCapturingSender;
use SmartyStreets\PhpSdk\Tests\Mocks\MockSender;
use SmartyStreets\PhpSdk\US_ZIPCode\Client;
use SmartyStreets\PhpSdk\US_ZIPCode\Lookup;
use SmartyStreets\PhpSdk\US_ZIPCode\Result;
use SmartyStreets\PhpSdk\Batch;
use SmartyStreets\PhpSdk\Response;
use SmartyStreets\PhpSdk\URLPrefixSender;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase {

    //region [Batch Lookup ]

    public function testEmptyBatchNotSent() {
        $sender = new RequestCapturingSender();
        $client = new Client($sender, null);

        $client->sendBatch(new Batch());

        $this->assertNull($sender->getRequest());
    }

    public function testSendingSingleFullyPopulatedLookup() {
        $capturingSender = new RequestCapturingSender();
        $sender = new URLPrefixSender("http://localhost/", $capturingSender);
        $serializer = new MockSerializer("");
        $expectedURL = ("http://localhost/?input_id=1&city=2&state=3&zipcode=4");

        $client = new Client($sender, $serializer);
        $lookup = new Lookup();
        $lookup->setInputId("1");
        $lookup->setCity("2");
        $lookup->setState("3");
        $lookup->setZipCode("4");


        $client->sendLookup($lookup);

        $this->assertEquals($expectedURL, $capturingSender->getRequest()->getURL());
        $this->assertEquals("GET", $capturingSender->getRequest()->getMethod());
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
