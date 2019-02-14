<?php

namespace SmartyStreets\PhpSdk\Tests\US_Street;

require_once(dirname(dirname(__FILE__)) . '/Mocks/MockSerializer.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/MockDeserializer.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/RequestCapturingSender.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/MockSender.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_Street/Client.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_Street/Lookup.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_Street/Candidate.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/Batch.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/Response.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/URLPrefixSender.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/NativeSerializer.php');
use SmartyStreets\PhpSdk\NativeSerializer;
use SmartyStreets\PhpSdk\Tests\Mocks\MockSerializer;
use SmartyStreets\PhpSdk\Tests\Mocks\MockDeserializer;
use SmartyStreets\PhpSdk\Tests\Mocks\RequestCapturingSender;
use SmartyStreets\PhpSdk\Tests\Mocks\MockSender;
use SmartyStreets\PhpSdk\US_Street\Client;
use SmartyStreets\PhpSdk\US_Street\Lookup;
use SmartyStreets\PhpSdk\US_Street\Candidate;
use SmartyStreets\PhpSdk\Batch;
use SmartyStreets\PhpSdk\Response;
use SmartyStreets\PhpSdk\URLPrefixSender;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase {

    //region [ Single Lookup ]

    public function testSendingSingleFreeformLookup() {
        $expectedPayload = "?street=freeform&candidates=1";
        $sender = new RequestCapturingSender();
        $serializer = new MockSerializer($expectedPayload);
        $client = new Client($sender, $serializer);

        $client->sendLookup(new Lookup("freeform"));

        $this->assertEquals($expectedPayload, $sender->getRequest()->getURL());
    }

    public function testSendingSingleFullyPopulatedLookup() {
        $capturingSender = new RequestCapturingSender();
        $sender = new URLPrefixSender("http://localhost/", $capturingSender);
        $serializer = new NativeSerializer();
        $expectedURL = ("http://localhost/?input_id=1&street=2&street2=3&secondary=4&city=5&" .
            "state=6&zipcode=7&lastline=8&addressee=9&" .
            "urbanization=10&match=invalid&candidates=12");

        $client = new Client($sender, $serializer);
        $lookup = new Lookup();
        $lookup->setInputId(1);
        $lookup->setStreet("2");
        $lookup->setStreet2("3");
        $lookup->setSecondary("4");
        $lookup->setCity("5");
        $lookup->setState("6");
        $lookup->setZipCode("7");
        $lookup->setLastline("8");
        $lookup->setAddressee("9");
        $lookup->setUrbanization("10");
        $lookup->setMatchStrategy(Lookup::INVALID);
        $lookup->setMaxCandidates(12);

        $client->sendLookup($lookup);

        $this->assertEquals($expectedURL, $capturingSender->getRequest()->getURL());
        $this->assertEquals("GET", $capturingSender->getRequest()->getMethod());
}

//endregion

    //region [Batch Lookup ]

    public function testEmptyBatchNotSent() {
        $sender = new RequestCapturingSender();
        $client = new Client($sender, null);

        $client->sendBatch(new Batch());

        $this->assertNull($sender->getRequest());
    }

    public function testSuccessfullySendsBatchOfLookups() {
        $expectedPayload = "Hello, World!";
        $sender = new RequestCapturingSender();
        $serializer = new MockSerializer($expectedPayload);
        $client = new Client($sender, $serializer);
        $batch = new Batch();
        $batch->add(new Lookup());
        $batch->add(new Lookup());

        $client->sendBatch($batch);

        $this->assertEquals($expectedPayload, $sender->getRequest()->getPayload());
    }

    //endregion

    //region [ Response Handling ]

    public function testDeserializeCalledWithResponseBody() {
        $response = new Response(0, "Hello, World!");
        $sender = new MockSender($response);
        $deserializer = new MockDeserializer(null);
        $client = new Client($sender, $deserializer);

        $client->sendLookup(new Lookup());

        $this->assertEquals($response->getPayload(), $deserializer->getPayload());
    }

    public function testCandidatesCorrectlyAssignedToCorrespondingLookup() {
        $rawResults = array(array('input_index' => 0, 'candidate_index' => 0), array('input_index' => 1, 'candidate_index' => 1));
        $expectedResults = array(new Candidate($rawResults[0]), new Candidate($rawResults[1]));

        $batch = new Batch();
        $batch->add(new Lookup());
        $batch->add(new Lookup());

        $sender = new MockSender(new Response(0, "[]"));
        $deserializer = new MockDeserializer($rawResults);
        $client = new Client($sender, $deserializer);

        $client->sendBatch($batch);

        $this->assertEquals($expectedResults[0], $batch->getLookupByIndex(0)->getResult()[0]);
        $this->assertEquals($expectedResults[1], $batch->getLookupByIndex(1)->getResult()[0]);
    }

    public function testFullJSONResponseDeserialization() {
        $expected_json_output = "[{\"input_index\":0,\"candidate_index\":4242,\"addressee\":\"John Smith\",
        \"delivery_line_1\":\"3214 N University Ave # 409\",\"delivery_line_2\":\"blah blah\",\"last_line\":
        \"Provo UT 84604-4405\",\"delivery_point_barcode\":\"846044405140\",\"components\":[{\"primary_number\":
        \"3214\",\"street_predirection\":\"N\",\"street_postdirection\":\"Q\",\"street_name\":\"University\",
        \"street_suffix\":\"Ave\",\"secondary_number\":\"409\",\"secondary_designator\":\"#\",
        \"extra_secondary_number\":\"410\",\"extra_secondary_designator\":\"Apt\",\"pmb_number\":\"411\",
        \"pmb_designator\":\"Box\",\"city_name\":\"Provo\",\"default_city_name\":\"Provo\",\"state_abbreviation\":
        \"UT\",\"zipcode\":\"84604\",\"plus4_code\":\"4405\",\"delivery_point\":\"14\",\"delivery_point_check_digit\":
        \"0\",\"urbanization\":\"urbanization\"}],\"metadata\":[{\"record_type\":\"S\",\"zip_type\":\"Standard\",
        \"county_fips\":\"49049\",\"county_name\":\"Utah\",\"carrier_route\":\"C016\",\"congressional_district\":
        \"03\",\"building_default_indicator\":\"hi\",\"rdi\":\"Commercial\",\"elot_sequence\":\"0016\",\"elot_sort\":
        \"A\",\"latitude\":40.27658,\"longitude\":-111.65759,\"precision\":\"Zip9\",\"time_zone\":\"Mountain\",
        \"utc_offset\":-7,\"dst\":true,\"ews_match\":true}],\"analysis\":[{\"dpv_match_code\":\"S\",\"dpv_footnotes\":
        \"AACCRR\",\"dpv_cmra\":\"Y\",\"dpv_vacant\":\"N\",\"active\":\"Y\",\"footnotes\":\"footnotes\",
        \"lacslink_code\":\"lacslink_code\",\"lacslink_indicator\":\"lacslink_indicator\",\"suitelink_match\":true}]}]";
        $serializer = new NativeSerializer();

        $results = $serializer->deserialize($expected_json_output);

        $components = $results[0]['components'][0];
        $metadata = $results[0]['metadata'][0];
        $analysis = $results[0]['analysis'][0];

        $this->assertNotNull($results, 'Not supposed to be null');
        $this->assertEquals(0, $results[0]['input_index']);
        $this->assertEquals(4242, $results[0]['candidate_index']);
        $this->assertEquals('John Smith', $results[0]['addressee']);
        $this->assertEquals('3214 N University Ave # 409', $results[0]['delivery_line_1']);
        $this->assertEquals('blah blah', $results[0]['delivery_line_2']);
        $this->assertEquals('Provo UT 84604-4405', $results[0]['last_line']);
        $this->assertEquals('846044405140', $results[0]['delivery_point_barcode']);
        $this->assertEquals('3214', $results[0]['components'][0]['primary_number']);
        $this->assertEquals('N', $components['street_predirection']);
        $this->assertEquals('Q', $components['street_postdirection']);
        $this->assertEquals('University', $components['street_name']);
        $this->assertEquals('Ave', $components['street_suffix']);
        $this->assertEquals('409', $components['secondary_number']);
        $this->assertEquals('#', $components['secondary_designator']);
        $this->assertEquals('410', $components['extra_secondary_number']);
        $this->assertEquals('Apt', $components['extra_secondary_designator']);
        $this->assertEquals('411', $components['pmb_number']);
        $this->assertEquals('Box', $components['pmb_designator']);
        $this->assertEquals('Provo', $components['city_name']);
        $this->assertEquals('Provo', $components['default_city_name']);
        $this->assertEquals('UT', $components['state_abbreviation']);
        $this->assertEquals('84604', $components['zipcode']);
        $this->assertEquals('4405', $components['plus4_code']);
        $this->assertEquals('14', $components['delivery_point']);
        $this->assertEquals('0', $components['delivery_point_check_digit']);
        $this->assertEquals('urbanization', $components['urbanization']);
        $this->assertEquals('S', $metadata['record_type']);
        $this->assertEquals('Standard', $metadata['zip_type']);
        $this->assertEquals('49049', $metadata['county_fips']);
        $this->assertEquals('Utah', $metadata['county_name']);
        $this->assertEquals('C016', $metadata['carrier_route']);
        $this->assertEquals('03', $metadata['congressional_district']);
        $this->assertEquals('hi', $metadata['building_default_indicator']);
        $this->assertEquals('Commercial', $metadata['rdi']);
        $this->assertEquals('0016', $metadata['elot_sequence']);
        $this->assertEquals('A', $metadata['elot_sort']);
        $this->assertEquals(40.27658, $metadata['latitude']);
        $this->assertEquals(-111.65759, $metadata['longitude']);
        $this->assertEquals('Zip9', $metadata['precision']);
        $this->assertEquals('Mountain', $metadata['time_zone']);
        $this->assertEquals(-7, $metadata['utc_offset']);
        $this->assertEquals(true, $metadata['dst']);
        $this->assertEquals(true, $metadata['ews_match']);
        $this->assertEquals('S', $analysis['dpv_match_code']);
        $this->assertEquals('AACCRR', $analysis['dpv_footnotes']);
        $this->assertEquals('Y', $analysis['dpv_cmra']);
        $this->assertEquals('N', $analysis['dpv_vacant']);
        $this->assertEquals('Y', $analysis['active']);
        $this->assertEquals('footnotes', $analysis['footnotes']);
        $this->assertEquals('lacslink_code', $analysis['lacslink_code']);
        $this->assertEquals('lacslink_indicator', $analysis['lacslink_indicator']);
        $this->assertEquals(true, $analysis['suitelink_match']);

    }

    //endregion

}
