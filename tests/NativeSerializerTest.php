<?php

namespace SmartyStreets\PhpSdk\Tests\US_ZIPCode;

require_once(dirname(dirname(__FILE__)) . '/src/NativeSerializer.php');
use SmartyStreets\PhpSdk\NativeSerializer;
use SmartyStreets\PhpSdk\US_ZIPCode\Lookup;
use PHPUnit\Framework\TestCase;

class NativeSerializerTest extends TestCase {

//    public function testSerialize() {
//        $serializer = new NativeSerializer();
//        $lookup = new Lookup('fake city', 'fake state', '12345');
//
//        $result = $serializer->serialize($lookup);
//
//        $this->assertStringContainsString('"city":"fake city"', $result, "Result is: $result");
//        $this->assertStringContainsString('"state":"fake state"', $result, "Result is: $result");
//        $this->assertStringContainsString('"zipcode":"12345"', $result, "Result is: $result");
//    }

    public function testDeserialize() {
        $expected_json_output = "[{\"input_index\":0,\"city_states\":[{\"city\":\"Washington\",\"state_abbreviation\":
      \"DC\",\"state\":\"District of Columbia\",\"mailable_city\":true}],\"zipcodes\":[{\"zipcode\":\"20500\",
      \"zipcode_type\":\"S\",\"default_city\":\"Washington\",\"county_fips\":\"11001\",
      \"county_name\":\"District of Columbia\",\"latitude\":38.89769,\"longitude\":-77.03869}]},{\"input_index\":1,
      \"input_id\":\"test id\",\"city_states\":[{\"city\":\"Provo\",\"state_abbreviation\":\"UT\",\"state\":\"Utah\",
      \"default_city\":true,\"mailable_city\":true}],\"zipcodes\":[{\"zipcode\":\"84606\",\"zipcode_type\":\"S\",
      \"county_fips\":\"11501\",\"county_name\":\"Utah\",\"latitude\":38.89769,\"longitude\":-77.03869}]},
            {\"input_index\":2,\"status\":\"invalid_zipcode\",\"reason\":\"Invalid ZIP Code.\"}]";
        $serializer = new NativeSerializer();

        $results = $serializer->deserialize($expected_json_output);

        $this->assertNotNull($results, 'Not supposed to be null');
        $this->assertEquals(0, $results[0]['input_index']);
        $this->assertNotNull($results[0]['city_states'], 'Not supposed to be null');
        $this->assertEquals('Washington', $results[0]['city_states'][0]['city']);
        $this->assertEquals('20500', $results[0]['zipcodes'][0]['zipcode']);

        $this->assertNotNull($results[1], 'Not supposed to be null');
        $this->assertNotContains('status', $results[1]);
        $this->assertEquals('Utah', $results[1]['city_states'][0]['state']);
        $this->assertEquals(38.89769, $results[1]['zipcodes'][0]['latitude'], 0.00001);

        $this->assertNotNull($results[2], 'Not supposed to be null');
        $this->assertNotContains('city_states', $results[2]);
        $this->assertEquals('invalid_zipcode', $results[2]['status']);
        $this->assertEquals('Invalid ZIP Code.', $results[2]['reason']);
    }


}