<?php

namespace SmartyStreets\PhpSdk\Tests\US_Autocomplete;

require_once(dirname(dirname(__FILE__)) . '/Mocks/MockSerializer.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/MockDeserializer.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/RequestCapturingSender.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/MockStatusCodeSender.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/MockSender.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/MockCrashingSender.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_Autocomplete/Client.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_Autocomplete/Lookup.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/Batch.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/Response.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/URLPrefixSender.php');
use SmartyStreets\PhpSdk\Tests\Mocks\MockSerializer;
use SmartyStreets\PhpSdk\Tests\Mocks\RequestCapturingSender;
use SmartyStreets\PhpSdk\URLPrefixSender;
use SmartyStreets\PhpSdk\US_Autocomplete\Client;
use SmartyStreets\PhpSdk\US_Autocomplete\Lookup;
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

        $this->assertEquals('http://localhost/v2/lookup?search=testSearch&prefer_cities=testCity&prefer_geolocation=city', $capturingSender->getRequest()->getUrl());
    }

    public function testSendingFullyPopulatedLookup() {
        $capturingSender = new RequestCapturingSender();
        $sender = new URLPrefixSender("http://localhost", $capturingSender);
        $serializer = new MockSerializer(null);
        $client = new Client($sender, $serializer);

        $lookup = new Lookup("testSearch");
        $lookup->setMaxResults(5);
        $lookup->addCityFilter("testCity");
        $lookup->addStateFilter("testState");
        $lookup->addStateExclusion("excludedState");
        $lookup->addPreferCity("preferCity");
        $lookup->addPreferState("preferState");
        $lookup->setPreferRatio(3);
        $lookup->setSource("all");
        $lookup->setSelected("selectedAddress");
        $lookup->setExclude("excludedAddress");

        $client->sendLookup($lookup);

        $this->assertEquals('http://localhost/v2/lookup?search=testSearch&max_results=5&include_only_cities=testCity&include_only_states=testState&exclude_states=excludedState&prefer_cities=preferCity&prefer_states=preferState&prefer_ratio=3&prefer_geolocation=city&source=all&selected=selectedAddress&exclude=excludedAddress', $capturingSender->getRequest()->getUrl());
    }

    public function testSendingExclude() {
        $capturingSender = new RequestCapturingSender();
        $sender = new URLPrefixSender("http://localhost", $capturingSender);
        $serializer = new MockSerializer(null);
        $client = new Client($sender, $serializer);

        $lookup = new Lookup("testSearch");
        $lookup->setExclude("excludedAddress");

        $client->sendLookup($lookup);

        $this->assertStringContainsString('&exclude=excludedAddress', $capturingSender->getRequest()->getUrl());
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

        $this->assertEquals('http://localhost/v2/lookup?search=testSearch&prefer_cities=testCity&prefer_geolocation=city&parameter=value', $capturingSender->getRequest()->getUrl());
    }
}
