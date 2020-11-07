<?php

namespace SmartyStreets\PhpSdk\Tests\US_Reverse_Geo;

require_once(dirname(dirname(__FILE__)) . '/Mocks/MockSerializer.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/MockDeserializer.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/RequestCapturingSender.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/MockStatusCodeSender.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/MockSender.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/MockCrashingSender.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_Reverse_Geo/Client.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_Reverse_Geo/Lookup.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/International_Street/Candidate.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/International_Street/LanguageMode.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/Batch.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/Response.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/URLPrefixSender.php');
use SmartyStreets\PhpSdk\Tests\Mocks\MockSerializer;
use SmartyStreets\PhpSdk\Tests\Mocks\RequestCapturingSender;
use SmartyStreets\PhpSdk\URLPrefixSender;
use SmartyStreets\PhpSdk\US_Reverse_Geo\Client;
use SmartyStreets\PhpSdk\US_Reverse_Geo\Lookup;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase {

    public function testSendingLookup() {
        $capturingSender = new RequestCapturingSender();
        $sender = new URLPrefixSender("http://localhost/", $capturingSender);
        $serializer = new MockSerializer(null);
        $client = new Client($sender, $serializer);
        $lookup = new Lookup(44.888888888, -111.111111111);

        $client->sendLookup($lookup);

        $this->assertEquals("http://localhost/?latitude=44.88888889&longitude=-111.11111111", $capturingSender->getRequest()->getUrl());
    }
}
