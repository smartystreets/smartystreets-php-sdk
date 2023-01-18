<?php

namespace SmartyStreets\PhpSdk\Tests\US_Extract;

require_once(dirname(dirname(__FILE__)) . '/Mocks/MockSerializer.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/MockDeserializer.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/RequestCapturingSender.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/MockStatusCodeSender.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/MockSender.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/MockCrashingSender.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/URLPrefixSender.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_Extract/Result.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_Extract/Client.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_Extract/Lookup.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/Exceptions/SmartyException.php');

use SmartyStreets\PhpSdk\Tests\Mocks\MockDeserializer;
use SmartyStreets\PhpSdk\Tests\Mocks\MockSender;
use SmartyStreets\PhpSdk\Tests\Mocks\MockSerializer;
use SmartyStreets\PhpSdk\Tests\Mocks\RequestCapturingSender;
use SmartyStreets\PhpSdk\URLPrefixSender;
use SmartyStreets\PhpSdk\Response;
use SmartyStreets\PhpSdk\US_Extract\Result;
use SmartyStreets\PhpSdk\US_Extract\Client;
use SmartyStreets\PhpSdk\US_Extract\Lookup;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase {
    public function testSendingBodyOnlyLookup() {
        $capturingSender = new RequestCapturingSender();
        $sender = new URLPrefixSender('http://localhost/', $capturingSender);
        $serializer = new MockSerializer(null);
        $client = new Client($sender, $serializer);
        $expectedUrl = "http://localhost/?aggressive=false&addr_line_breaks=true&addr_per_line=0";
        $expectedPayload = "Hello, World!";

        $client->sendLookup(new Lookup("Hello, World!"));

        $this->assertEquals($expectedUrl, $capturingSender->getRequest()->getUrl());
        $this->assertEquals($expectedPayload, $capturingSender->getRequest()->getPayload());
    }

    public function testSendingFullyPopulatedLookup() {
        $capturingSender = new RequestCapturingSender();
        $sender = new URLPrefixSender('http://localhost/', $capturingSender);
        $serializer = new MockSerializer(null);
        $client = new Client($sender, $serializer);
        $expectedUrl = "http://localhost/?html=true&aggressive=true&addr_line_breaks=false&addr_per_line=2";
        $lookup = new Lookup('1');
        $lookup->specifyHtmlInput(true);
        $lookup->setAggressive(true);
        $lookup->setAddressesHaveLineBreaks(false);
        $lookup->setAddressesPerLine(2);

        $client->sendLookup($lookup);

        $this->assertEquals($expectedUrl, $capturingSender->getRequest()->getUrl());
    }

    public function testRejectNullLookup() {
        $classType = \SmartyStreets\PhpSdk\Exceptions\SmartyException::class;

        $capturingSender = new RequestCapturingSender();
        $sender = new URLPrefixSender('http://localhost/', $capturingSender);
        $serializer = new MockSerializer(null);
        $client = new Client($sender, $serializer);

        $this->expectException($classType);

        $client->sendLookup(null);
    }

    public function testDeserializeCalledWithResponseBody() {
        $response = new Response(0, 'Hello, World!', "");
        $sender = new MockSender($response);
        $deserializer = new MockDeserializer(null);
        $client = new Client($sender, $deserializer);

        $client->sendLookup(new Lookup('Hello, World'));

        $this->assertEquals($response->getPayload(), $deserializer->getPayload());
    }

    public function testResultCorrectlyAssignedToCorrespondingLookup() {
        $rawResult = array('meta' => array(), 'addresses' => array(array('text' => '1')));

        $expectedResult = new Result($rawResult);
        $lookup = new Lookup('Hello, World!');

        $sender = new MockSender(new Response(0, '[]', ""));
        $deserializer = new MockDeserializer($rawResult);
        $client = new Client($sender, $deserializer);

        $client->sendLookup($lookup);

        $this->assertEquals($expectedResult, $lookup->getResult());
    }

    public function testContentTypeSetCorrectly() {
        $sender = new RequestCapturingSender();
        $serializer = new MockSerializer(null);
        $client = new Client($sender, $serializer);
        $lookup = new Lookup('Hello, World!');

        $client->sendLookup($lookup);

        $this->assertEquals('text/plain', $sender->getRequest()->getContentType());
    }
}
