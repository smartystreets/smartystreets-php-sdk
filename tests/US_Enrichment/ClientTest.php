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
        $sender = new URLPrefixSender("http://localhost", $capturingSender);
        $serializer = new MockSerializer(null);
        $client = new Client($sender, $serializer);
        $smartyKey = "123";
        $client->sendPropertyPrincipalLookup($smartyKey);

        $this->assertEquals("http://localhost/lookup/123/property/principal?", $capturingSender->getRequest()->getUrl());
    }

    public function testSendingAddressComponentLookup() {
        $capturingSender = new RequestCapturingSender();
        $sender = new URLPrefixSender("http://localhost", $capturingSender);
        $serializer = new MockSerializer(null);
        $client = new Client($sender, $serializer);
        $lookup = new Lookup();
        $lookup->setStreet("123 Test Street");
        $lookup->setCity("Test City");
        $lookup->setState("Test State");
        $lookup->setZipcode("Test Zipcode");
        $lookup->addIncludeAttribute("Test Include 1");
        $lookup->addIncludeAttribute("Test Include 2");
        $lookup->addExcludeAttribute("Test Exclude 1");
        $lookup->addExcludeAttribute("Test Exclude 2");

        $client->sendPropertyPrincipalLookup($lookup);

        $this->assertEquals("http://localhost/lookup/search/property/principal?street=123+Test+Street&city=Test+City&state=Test+State&zipcode=Test+Zipcode&include=Test+Include+1%2CTest+Include+2&exclude=Test+Exclude+1%2CTest+Exclude+2", $capturingSender->getRequest()->getUrl());
    }

    public function testSendingCustomParameterLookup() {
        $capturingSender = new RequestCapturingSender();
        $sender = new URLPrefixSender("http://localhost", $capturingSender);
        $serializer = new MockSerializer(null);
        $client = new Client($sender, $serializer);
        $lookup = new Lookup();
        $lookup->setStreet("123 Test Street");
        $lookup->setCity("Test City");
        $lookup->setState("Test State");
        $lookup->setZipcode("Test Zipcode");
        $lookup->addCustomParameter("parameter", "custom");
        $lookup->addCustomParameter("second", "parameter");
        $includeArray = array("Test Include 1","Test Include 2");
        $excludeArray = array("Test Exclude 1","Test Exclude 2");
        $lookup->setIncludeArray($includeArray);
        $lookup->setExcludeArray($excludeArray);

        $client->sendPropertyPrincipalLookup($lookup);

        $this->assertEquals("http://localhost/lookup/search/property/principal?street=123+Test+Street&city=Test+City&state=Test+State&zipcode=Test+Zipcode&include=Test+Include+1%2CTest+Include+2&exclude=Test+Exclude+1%2CTest+Exclude+2&parameter=custom&second=parameter", $capturingSender->getRequest()->getUrl());
    }
    
    public function testSendingFreeformLookup() {
        $capturingSender = new RequestCapturingSender();
        $sender = new URLPrefixSender("http://localhost", $capturingSender);
        $serializer = new MockSerializer(null);
        $client = new Client($sender, $serializer);
        $lookup = new Lookup();
        $lookup->setFreeform("123 Test Street City State Zipcode");

        $client->sendPropertyPrincipalLookup($lookup);

        $this->assertEquals("http://localhost/lookup/search/property/principal?freeform=123+Test+Street+City+State+Zipcode", $capturingSender->getRequest()->getUrl());
    }
}
