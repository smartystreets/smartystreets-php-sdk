<?php

namespace SmartyStreets\PhpSdk\Tests\InternationalPostalCode;

require_once(dirname(dirname(__FILE__)) . '/Mocks/MockSerializer.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/MockDeserializer.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/RequestCapturingSender.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/MockStatusCodeSender.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/MockSender.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/MockCrashingSender.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/International_Postal_Code/Client.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/International_Postal_Code/Lookup.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/International_Postal_Code/Candidate.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/Batch.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/Response.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/Exceptions/SmartyException.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/URLPrefixSender.php');
use SmartyStreets\PhpSdk\Tests\Mocks\MockSerializer;
use SmartyStreets\PhpSdk\Tests\Mocks\MockDeserializer;
use SmartyStreets\PhpSdk\Tests\Mocks\RequestCapturingSender;
use SmartyStreets\PhpSdk\Tests\Mocks\MockCrashingSender;
use SmartyStreets\PhpSdk\Tests\Mocks\MockSender;
use SmartyStreets\PhpSdk\URLPrefixSender;
use SmartyStreets\PhpSdk\International_Postal_Code\Client;
use SmartyStreets\PhpSdk\International_Postal_Code\Lookup;
use SmartyStreets\PhpSdk\International_Postal_Code\Candidate;
use SmartyStreets\PhpSdk\Response;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase {

    public function testLookupSerializedAndSent_ResponseCandidatesIncorporatedIntoLookup() {
        $capturingSender = new RequestCapturingSender();
        $sender = new URLPrefixSender("http://localhost", $capturingSender);
        $expectedUrl = "http://localhost/lookup?administrative_area=42";
        $rawCandidates = array(
            array('input_id' => '1'),
            array('administrative_area' => '2'),
            array('locality' => '3'),
            array('postal_code' => '4')
        );
        $deserializer = new MockDeserializer($rawCandidates);
        $client = new Client($sender, $deserializer);
        $lookup = new Lookup();
        $lookup->setAdministrativeArea("42");

        $client->sendLookup($lookup);

        $this->assertEquals($expectedUrl, $capturingSender->getRequest()->getUrl());
        $this->assertEquals("GET", $capturingSender->getRequest()->getMethod());
        $this->assertEquals("/lookup", $capturingSender->getRequest()->getUrlComponents());
        $this->assertEquals(4, count($lookup->getResult()));
        $this->assertEquals("1", $lookup->getResult()[0]->getInputId());
        $this->assertEquals("2", $lookup->getResult()[1]->getAdministrativeArea());
        $this->assertEquals("3", $lookup->getResult()[2]->getLocality());
        $this->assertEquals("4", $lookup->getResult()[3]->getPostalCodeShort());
    }

    public function testNilLookupNOP() {
        $classType = \SmartyStreets\PhpSdk\Exceptions\SmartyException::class;
        $sender = new MockCrashingSender();
        $client = new Client($sender, null);

        $this->expectException($classType);
        $this->expectExceptionMessage("lookup cannot be nil");

        $client->sendLookup(null);
    }

    public function testEmptyLookup_NOP() {
        $response = new Response(200, "", "");
        $sender = new MockSender($response);
        $deserializer = new MockDeserializer(null);
        $client = new Client($sender, $deserializer);
        $lookup = new Lookup();

        $client->sendLookup($lookup);

        $this->assertEquals(0, count($lookup->getResult()));
    }

    public function testSenderErrorPreventsDeserialization() {
        $response = new Response(200, '[{"input_id": "1"}]', "");
        $sender = new MockCrashingSender();
        $deserializer = new MockDeserializer(array(array('input_id' => '1')));
        $client = new Client($sender, $deserializer);
        $lookup = new Lookup();
        $lookup->setLocality("HI");

        try {
            $client->sendLookup($lookup);
            $this->fail("Expected exception was not thrown");
        } catch (\Exception $e) {
            // Expected
        }

        $this->assertEquals(0, count($lookup->getResult()));
    }

    public function testDeserializationErrorPreventsDeserialization() {
        $response = new Response(200, "I have no JSON", "");
        $sender = new MockSender($response);
        $deserializer = new MockDeserializer(null);
        $client = new Client($sender, $deserializer);
        $lookup = new Lookup();
        $lookup->setLocality("HI");

        $client->sendLookup($lookup);

        $this->assertEquals(0, count($lookup->getResult()));
    }

    public function testFullJSONResponseDeserialization() {
        $rawCandidates = array(
            array(
                'input_id' => '1',
                'country_iso_3' => '2',
                'locality' => '3',
                'administrative_area' => '4',
                'sub_administrative_area' => '5',
                'super_administrative_area' => '6',
                'postal_code' => '7'
            )
        );
        $response = new Response(200, "", "");
        $sender = new MockSender($response);
        $deserializer = new MockDeserializer($rawCandidates);
        $client = new Client($sender, $deserializer);
        $lookup = new Lookup();

        $client->sendLookup($lookup);

        $candidate = $lookup->getResult()[0];
        $this->assertEquals("1", $candidate->getInputId());
        $this->assertEquals("2", $candidate->getCountryIso3());
        $this->assertEquals("3", $candidate->getLocality());
        $this->assertEquals("4", $candidate->getAdministrativeArea());
        $this->assertEquals("5", $candidate->getSubAdministrativeArea());
        $this->assertEquals("6", $candidate->getSuperAdministrativeArea());
        $this->assertEquals("7", $candidate->getPostalCodeShort());
    }

    public function testSendingSingleFullyPopulatedLookup() {
        $capturingSender = new RequestCapturingSender();
        $sender = new URLPrefixSender("http://localhost", $capturingSender);
        $expectedUrl = "http://localhost/lookup?input_id=ID-8675309&country=Brazil&locality=Sao+Paulo&administrative_area=SP&postal_code=02516";
        $serializer = new MockSerializer(null);
        $client = new Client($sender, $serializer);
        $lookup = new Lookup();
        $lookup->setInputId("ID-8675309");
        $lookup->setCountry("Brazil");
        $lookup->setLocality("Sao Paulo");
        $lookup->setAdministrativeArea("SP");
        $lookup->setPostalCode("02516");

        $client->sendLookup($lookup);

        $this->assertEquals($expectedUrl, $capturingSender->getRequest()->getUrl());
    }
}

