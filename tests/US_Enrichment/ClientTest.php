<?php

namespace SmartyStreets\PhpSdk\Tests\US_Enrichment;

require_once(dirname(dirname(__FILE__)) . '/Mocks/MockSerializer.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/MockDeserializer.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/RequestCapturingSender.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/MockStatusCodeSender.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/MockSender.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/MockCrashingSender.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_Enrichment/Client.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_Enrichment/Lookup.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/URLPrefixSender.php');
use SmartyStreets\PhpSdk\Tests\Mocks\MockSerializer;
use SmartyStreets\PhpSdk\Tests\Mocks\RequestCapturingSender;
use SmartyStreets\PhpSdk\URLPrefixSender;
use SmartyStreets\PhpSdk\US_Enrichment\Client;
use SmartyStreets\PhpSdk\US_Enrichment\Lookup;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase {

    public function testSendingLookup() {
        $capturingSender = new RequestCapturingSender();
        $sender = new URLPrefixSender("http://localhost/", $capturingSender);
        $serializer = new MockSerializer(null);
        $client = new Client($sender, $serializer);
        $smartyKey = "123";
        $client->sendPropertyPrincipalLookup($smartyKey);

        $this->assertEquals("http://localhost/123/property/principal?", $capturingSender->getRequest()->getUrl());
    }

    public function testSendingAddressComponentLookup() {
        $capturingSender = new RequestCapturingSender();
        $sender = new URLPrefixSender("http://localhost/", $capturingSender);
        $serializer = new MockSerializer(null);
        $client = new Client($sender, $serializer);
        $lookup = new Lookup();
        $lookup->setStreet("123 Test Street");
        $lookup->setCity("Test City");
        $lookup->setState("Test State");
        $lookup->setZipcode("Test Zipcode");

        $client->sendPropertyPrincipalLookup($lookup);

        $this->assertEquals("http://localhost/search/property/principal?street=123+Test+Street&city=Test+City&state=Test+State&zipcode=Test+Zipcode", $capturingSender->getRequest()->getUrl());
    }

    public function testSendingCustomParameterLookup() {
        $capturingSender = new RequestCapturingSender();
        $sender = new URLPrefixSender("http://localhost/", $capturingSender);
        $serializer = new MockSerializer(null);
        $client = new Client($sender, $serializer);
        $lookup = new Lookup();
        $lookup->setStreet("123 Test Street");
        $lookup->setCity("Test City");
        $lookup->setState("Test State");
        $lookup->setZipcode("Test Zipcode");
        $lookup->addCustomParameter("parameter", "custom");
        $lookup->addCustomParameter("second", "parameter");

        $client->sendPropertyPrincipalLookup($lookup);

        $this->assertEquals("http://localhost/search/property/principal?street=123+Test+Street&city=Test+City&state=Test+State&zipcode=Test+Zipcode&parameter=custom&second=parameter", $capturingSender->getRequest()->getUrl());
    }
    
    public function testSendingFreeformLookup() {
        $capturingSender = new RequestCapturingSender();
        $sender = new URLPrefixSender("http://localhost/", $capturingSender);
        $serializer = new MockSerializer(null);
        $client = new Client($sender, $serializer);
        $lookup = new Lookup();
        $lookup->setFreeform("123 Test Street City State Zipcode");

        $client->sendPropertyPrincipalLookup($lookup);

        $this->assertEquals("http://localhost/search/property/principal?freeform=123+Test+Street+City+State+Zipcode", $capturingSender->getRequest()->getUrl());
    }
}
