<?php

namespace SmartyStreets\PhpSdk\Tests\InternationalAutocomplete;

require_once(dirname(dirname(__FILE__)) . '/Mocks/MockSerializer.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/MockDeserializer.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/RequestCapturingSender.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/MockStatusCodeSender.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/MockSender.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/MockCrashingSender.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/International_Autocomplete/Client.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/International_Autocomplete/Lookup.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/International_Autocomplete/Candidate.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/Batch.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/Response.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/URLPrefixSender.php');
use SmartyStreets\PhpSdk\Tests\Mocks\MockSerializer;
use SmartyStreets\PhpSdk\Tests\Mocks\MockDeserializer;
use SmartyStreets\PhpSdk\Tests\Mocks\RequestCapturingSender;
use SmartyStreets\PhpSdk\Tests\Mocks\MockCrashingSender;
use SmartyStreets\PhpSdk\Tests\Mocks\MockSender;
use SmartyStreets\PhpSdk\URLPrefixSender;
use SmartyStreets\PhpSdk\International_Autocomplete\Client;
use SmartyStreets\PhpSdk\International_Autocomplete\Lookup;
use SmartyStreets\PhpSdk\International_Autocomplete\Candidate;
use SmartyStreets\PhpSdk\Response;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase {

    public function testSendingSingleFullyPopulatedLookup() {
        $capturingSender = new RequestCapturingSender();
        $sender = new URLPrefixSender("http://localhost/", $capturingSender);
        $expectedUrl = "http://localhost/?country=0&search=1&max_results=2&include_only_administrative_area=3" .
            "&include_only_locality=4&include_only_postal_code=5";
        $serializer = new MockSerializer(null);
        $client = new Client($sender, $serializer);
        $lookup = new Lookup();
        $lookup->setCountry("0");
        $lookup->setSearch("1");
        $lookup->setMaxResults(2);
        $lookup->setAdministrativeArea("3");
        $lookup->setLocality("4");
        $lookup->setPostalCode("5");

        $client->sendLookup($lookup);

        $this->assertEquals($expectedUrl, $capturingSender->getRequest()->getUrl());
    }

    public function testEmptyLookupRejected() {
        $this->assertLookupRejected(new Lookup());
    }

    public function testBlankLookupRejected() {
        $lookup = new Lookup();
        $this->assertLookupRejected($lookup);
    }

    public function testRejectsLookupsWithOnlyCountry() {
        $lookup = new Lookup();
        $lookup->setCountry("0");

        $this->assertLookupRejected($lookup);
    }

    private function assertLookupRejected($lookup) {
        $classType = \SmartyStreets\PhpSdk\Exceptions\SmartyException::class;
        $sender = new MockCrashingSender();
        $client = new Client($sender, null);

        $this->expectException($classType);

        $client->sendLookup($lookup);
    }

    public function testDeserializeCalledWithResponseBody() {
        $response = new Response(0, "Hello, World!", "");
        $sender = new MockSender($response);
        $deserializer = new MockDeserializer(null);
        $client = new Client($sender, $deserializer);
        $lookup = new Lookup();
        $lookup->setCountry("0");
        $lookup->setSearch("1");

        $client->sendLookup($lookup);

        $this->assertEquals($response->getPayload(), $deserializer->getPayload());
    }

    public function testCandidatesCorrectlyAssignedToLookup() {
        $rawCandidates = array(array('street' => '0'), array('locality' => '1'));
        $rawResults = array('candidates' => $rawCandidates);
        $expectedResults = array(new Candidate($rawCandidates[0]), new Candidate($rawCandidates[1]));

        $lookup = new Lookup();
        $lookup->setCountry("0");
        $lookup->setSearch("1");

        $sender = new MockSender(new Response(0, "", ""));
        $deserializer = new MockDeserializer($rawResults);
        $client = new Client($sender, $deserializer);

        $client->sendLookup($lookup);

        $this->assertEquals($expectedResults[0], $lookup->getResult()[0]);
        $this->assertEquals($expectedResults[1], $lookup->getResult()[1]);
    }
}
