<?php

namespace SmartyStreets\PhpSdk\Tests\US_AutocompletePro;

require_once(dirname(dirname(__FILE__)) . '/Mocks/MockSerializer.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/MockDeserializer.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/RequestCapturingSender.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/MockStatusCodeSender.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/MockSender.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/MockCrashingSender.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_Autocomplete_Pro/Client.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_Autocomplete_Pro/Lookup.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/Batch.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/Response.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/URLPrefixSender.php');
use SmartyStreets\PhpSdk\Tests\Mocks\MockSerializer;
use SmartyStreets\PhpSdk\Tests\Mocks\RequestCapturingSender;
use SmartyStreets\PhpSdk\URLPrefixSender;
use SmartyStreets\PhpSdk\US_Autocomplete_Pro\Client;
use SmartyStreets\PhpSdk\US_Autocomplete_Pro\Lookup;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase {

    public function testSendingLookup() {
        $capturingSender = new RequestCapturingSender();
        $sender = new URLPrefixSender("http://localhost", $capturingSender);
        $serializer = new MockSerializer(null);
        $client = new Client($sender, $serializer);

        $lookup = new Lookup("testSearch");
        $lookup->addPreferCity("testCity");

        $client->sendLookup($lookup);

        $this->assertEquals('http://localhost/lookup?search=testSearch&prefer_cities=testCity&prefer_geolocation=city', $capturingSender->getRequest()->getUrl());
    }

    public function testSendingCustomParameterLookup() {
        $capturingSender = new RequestCapturingSender();
        $sender = new URLPrefixSender("http://localhost", $capturingSender);
        $serializer = new MockSerializer(null);
        $client = new Client($sender, $serializer);

        $lookup = new Lookup("testSearch");
        $lookup->addPreferCity("testCity");
        $lookup->addCustomParameter("parameter", "value");

        $client->sendLookup($lookup);

        $this->assertEquals('http://localhost/lookup?search=testSearch&prefer_cities=testCity&prefer_geolocation=city&parameter=value', $capturingSender->getRequest()->getUrl());
    }
}