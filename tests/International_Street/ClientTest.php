<?php

namespace SmartyStreets\PhpSdk\Tests\International_Street;

require_once(dirname(dirname(__FILE__)) . '/Mocks/MockSerializer.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/MockDeserializer.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/RequestCapturingSender.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/MockStatusCodeSender.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/MockSender.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/MockCrashingSender.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/International_Street/Client.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/International_Street/Lookup.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/International_Street/Candidate.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/International_Street/LanguageMode.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/Batch.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/Response.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/URLPrefixSender.php');
use SmartyStreets\PhpSdk\Tests\Mocks\MockSerializer;
use SmartyStreets\PhpSdk\Tests\Mocks\MockDeserializer;
use SmartyStreets\PhpSdk\Tests\Mocks\RequestCapturingSender;
use SmartyStreets\PhpSdk\Tests\Mocks\MockCrashingSender;
use SmartyStreets\PhpSdk\Tests\Mocks\MockSender;
use SmartyStreets\PhpSdk\URLPrefixSender;
use SmartyStreets\PhpSdk\International_Street\Client;
use SmartyStreets\PhpSdk\International_Street\Lookup;
use SmartyStreets\PhpSdk\International_Street\Candidate;
use SmartyStreets\PhpSdk\International_Street\LanguageMode;
use SmartyStreets\PhpSdk\Response;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase {

    public function testSendingFreeformLookup() {
        $capturingSender = new RequestCapturingSender();
        $sender = new URLPrefixSender("http://localhost/", $capturingSender);
        $serializer = new MockSerializer(null);
        $client = new Client($sender, $serializer);
        $lookup = new Lookup();
        $lookup->setFreeformInput("freeform", "USA");

        $client->sendLookup($lookup);

        $this->assertEquals("http://localhost/?country=USA&freeform=freeform", $capturingSender->getRequest()->getUrl());
    }

    public function testSendingSingleFullyPopulatedLookup() {
        $capturingSender = new RequestCapturingSender();
        $sender = new URLPrefixSender("http://localhost/", $capturingSender);
        $expectedUrl = "http://localhost/?input_id=1234&country=0&geocode=true&language=native&freeform=1" .
            "&address1=2&address2=3&address3=4&address4=5&organization=6&locality=7&administrative_area=8&postal_code=9";
        $serializer = new MockSerializer(null);
        $client = new Client($sender, $serializer);
        $lookup = new Lookup();
        $lookup->setInputId("1234");
        $lookup->setCountry("0");
        $lookup->setGeocode(true);
        $lookup->setLanguage(new LanguageMode(LANGUAGE_MODE_NATIVE));
        $lookup->setFreeform("1");
        $lookup->setAddress1("2");
        $lookup->setAddress2("3");
        $lookup->setAddress3("4");
        $lookup->setAddress4("5");
        $lookup->setOrganization("6");
        $lookup->setLocality("7");
        $lookup->setAdministrativeArea("8");
        $lookup->setPostalCode("9");

        $client->sendLookup($lookup);

        $this->assertEquals($expectedUrl, $capturingSender->getRequest()->getUrl());
    }

    public function testEmptyLookupRejected() {
        $this->assertLookupRejected(new Lookup());
    }

    public function testBlankLookupRejected() {
        $lookup = new Lookup();
        $lookup->setFreeformInput(" ", " ");
        $this->assertLookupRejected($lookup);
    }

    public function testRejectsLookupsWithOnlyCountry() {
        $lookup = new Lookup();
        $lookup->setCountry("0");

        $this->assertLookupRejected($lookup);
    }

    public function testRejectsLookupsWithOnlyCountryAndAddress1() {
        $lookup = new Lookup();
        $lookup->setCountry("0");
        $lookup->setAddress1("1");

        $this->assertLookupRejected($lookup);
    }

    public function testRejectsLookupsWithOnlyCountryAndAddress1AndLocality() {
        $lookup = new Lookup();
        $lookup->setCountry("0");
        $lookup->setAddress1("1");
        $lookup->setLocality("2");

        $this->assertLookupRejected($lookup);
    }

    public function testRejectsLookupsWithOnlyCountryAndAddress1AndAdministrativeArea() {
        $lookup = new Lookup();
        $lookup->setCountry("0");
        $lookup->setAddress1("1");
        $lookup->setAdministrativeArea("2");

        $this->assertLookupRejected($lookup);
    }

    private function assertLookupRejected($lookup) {
        $classType = \SmartyStreets\PhpSdk\Exceptions\SmartyException::class;
        $sender = new MockCrashingSender();
        $client = new Client($sender, null);

        $this->expectException($classType);

        $client->sendLookup($lookup);
    }

    public function testAcceptsLookupsWithEnoughInfo() {
        $sender = new RequestCapturingSender();
        $serializer = new MockSerializer(null);
        $client = new Client($sender, $serializer);
        $lookup = new Lookup();

        $lookup->setCountry("0");
        $lookup->setFreeform("1");
        $client->sendLookup($lookup);
        $this->assertNotNull($lookup->getResult());

        $lookup->setFreeform(null);
        $lookup->setAddress1("1");
        $lookup->setPostalCode("2");
        $client->sendLookup($lookup);
        $this->assertNotNull($lookup->getResult());

        $lookup->setPostalCode(null);
        $lookup->setLocality("3");
        $lookup->setAdministrativeArea("4");
        $client->sendLookup($lookup);
        $this->assertNotNull($lookup->getResult());
    }

    public function testDeserializeCalledWithResponseBody() {
        $response = new Response(0, "Hello, World!", "");
        $sender = new MockSender($response);
        $deserializer = new MockDeserializer(null);
        $client = new Client($sender, $deserializer);
        $lookup = new Lookup();
        $lookup->setFreeformInput("1", "2");

        $client->sendLookup($lookup);

        $this->assertEquals($response->getPayload(), $deserializer->getPayload());
    }

    public function testCandidatesCorrectlyAssignedToLookup() {
        $rawResults = array(array('organization' => 0), array('address1' => 1));
        $expectedResults = array(new Candidate($rawResults[0]), new Candidate($rawResults[1]));

        $lookup = new Lookup();
        $lookup->setFreeformInput("1", "2");

        $sender = new MockSender(new Response(0, "", ""));
        $deserializer = new MockDeserializer($rawResults);
        $client = new Client($sender, $deserializer);

        $client->sendLookup($lookup);

        $this->assertEquals($expectedResults[0], $lookup->getResult()[0]);
        $this->assertEquals($expectedResults[1], $lookup->getResult()[1]);
    }
}
