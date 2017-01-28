<?php

require_once(dirname(dirname(dirname(__FILE__))) . '/src/smartystreets/api/NativeSerializer.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/smartystreets/api/us_zipcode/Result.php');
use smartystreets\api\us_zipcode\Result as Result;


class ResultTest extends \PHPUnit_Framework_TestCase {
    private $obj;

//    public function setUp() { //TODO: finish the result test setup
//        $this->obj = array(
//            'status' => '0',
//            'reason' => '1',
//            'input_index' => 2,
//            'city_states' => array (
//                'city' => '3',
//                'mailable_city' => true,
//                'state_abbreviation' => '4',
//                'state' => '5'
//            ),
//            'zipcodes' => array (
//                'zipcode' => '6',
//                'zipcode_type' => '7',
//                'default_city' => '8',
//                'county_fips' => '9',
//                'county_name' => '10',
//                'state_abbreviation' => '11',
//                'state' => '12',
//                'latitude' => 13,
//                'longitude' => 14,
//                'precision' => '15',
//                'alternate_counties' => array (
//
//                )
//            );
//
//        )
//    }


    function testIsValidReturnsTrueWhenInputIsValid() {
        $result = new Result();

        $this->assertTrue($result->isValid());
    }

    function testIsValidReturnsFalseWhenInputIsNotValid() {
        $result = new Result();
        $result->setStatus("invalid_zipcode");
        $result->setReason("invalid_reason");

        $this->assertFalse($result->isValid());
    }

//    public function testAllFieldsFilledCorrectly() {
//        $serializer = new NativeSerializer();
//        $results = $serializer->deserialize($this->expectedJsonOutput);
//
//        //TODO:
//    }
}
