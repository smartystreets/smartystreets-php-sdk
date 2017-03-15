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
use SmartyStreets\PhpSdk\Tests\Mocks\MockDeserializer;
use SmartyStreets\PhpSdk\Tests\Mocks\MockSender;
use SmartyStreets\PhpSdk\Tests\Mocks\MockSerializer;
use SmartyStreets\PhpSdk\Tests\Mocks\RequestCapturingSender;
use SmartyStreets\PhpSdk\URLPrefixSender;
use SmartyStreets\PhpSdk\Response;
use SmartyStreets\PhpSdk\US_Extract\Result;
use SmartyStreets\PhpSdk\US_Extract\Client;
use SmartyStreets\PhpSdk\US_Extract\Lookup;

class ClientTest extends \PHPUnit_Framework_TestCase {
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


}
