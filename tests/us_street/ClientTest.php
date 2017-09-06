<?php

namespace SmartyStreets\PhpSdk\Tests\US_Street;

require_once(dirname(dirname(__FILE__)) . '/Mocks/MockSerializer.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/MockDeserializer.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/RequestCapturingSender.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/MockSender.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_Street/Client.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_Street/Lookup.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_Street/Candidate.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/Batch.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/Response.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/URLPrefixSender.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/NativeSerializer.php');
use SmartyStreets\PhpSdk\NativeSerializer;
use SmartyStreets\PhpSdk\Tests\Mocks\MockSerializer;
use SmartyStreets\PhpSdk\Tests\Mocks\MockDeserializer;
use SmartyStreets\PhpSdk\Tests\Mocks\RequestCapturingSender;
use SmartyStreets\PhpSdk\Tests\Mocks\MockSender;
use SmartyStreets\PhpSdk\US_Street\Client;
use SmartyStreets\PhpSdk\US_Street\Lookup;
use SmartyStreets\PhpSdk\US_Street\Candidate;
use SmartyStreets\PhpSdk\Batch;
use SmartyStreets\PhpSdk\Response;
use SmartyStreets\PhpSdk\URLPrefixSender;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase {

    //region [ Single Lookup ]

    public function testSendingSingleFreeformLookup() {
        $expectedPayload = "Hello, World!";
        $sender = new RequestCapturingSender();
        $serializer = new MockSerializer($expectedPayload);
        $client = new Client($sender, $serializer);

        $client->sendLookup(new Lookup("freeform"));

        $this->assertEquals($expectedPayload, $sender->getRequest()->getPayload());
    }

    public function testSendingSingleFullyPopulatedLookup() {
        $capturingSender = new RequestCapturingSender();
        $sender = new URLPrefixSender("http://localhost/", $capturingSender);
        $serializer = new NativeSerializer();
        $expectedPayload = ("[{\"input_id\":1,\"street\":\"2\",\"street2\":\"3\",\"secondary\":\"4\",\"city\":\"5\"," .
            "\"state\":\"6\",\"zipcode\":\"7\",\"lastline\":\"8\",\"addressee\":\"9\"," .
            "\"urbanization\":\"10\",\"match\":\"invalid\",\"candidates\":12}]");

        $client = new Client($sender, $serializer);
        $lookup = new Lookup();
        $lookup->setInputId(1);
        $lookup->setStreet("2");
        $lookup->setStreet2("3");
        $lookup->setSecondary("4");
        $lookup->setCity("5");
        $lookup->setState("6");
        $lookup->setZipCode("7");
        $lookup->setLastline("8");
        $lookup->setAddressee("9");
        $lookup->setUrbanization("10");
        $lookup->setMatchStrategy(Lookup::INVALID);
        $lookup->setMaxCandidates(12);

        $client->sendLookup($lookup);

        $this->assertEquals($expectedPayload, $capturingSender->getRequest()->getPayload());
}

//endregion

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
