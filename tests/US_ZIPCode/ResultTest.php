<?php

namespace SmartyStreets\PhpSdk\Tests\US_Street;

require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_ZIPCode/Result.php');
use SmartyStreets\PhpSdk\US_ZIPCode\Result;
use PHPUnit\Framework\TestCase;

class ResultTest extends TestCase {
    private $obj;

    public function setUp() : void {
        $this->obj = array(
            'status' => '0',
            'reason' => '1',
            'input_id' => '1234',
            'input_index' => 2,
            'city_states' => array( array(
                'city' => '3',
                'mailable_city' => true,
                'state_abbreviation' => '4',
                'state' => '5')
            ),
            'zipcodes' => array( array(
                'zipcode' => '6',
                'zipcode_type' => '7',
                'default_city' => '8',
                'county_fips' => '9',
                'county_name' => '10',
                'state_abbreviation' => '11',
                'state' => '12',
                'latitude' => 13,
                'longitude' => 14,
                'precision' => '15',
                'alternate_counties' => array( array(
                    'county_fips' => '16',
                    'county_name' =>'17',
                    'state_abbreviation' =>'18',
                    'state' =>'19')
                ))
            )
        );
    }

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

    public function testAllFieldsFilledCorrectly() {
        $result = new Result($this->obj);

        $this->assertEquals("0", $result->getStatus());
        $this->assertEquals("1", $result->getReason());
        $this->assertEquals("1234", $result->getInputId());
        $this->assertEquals(2, $result->getInputIndex());

        $city = $result->getCities()[0];
        $this->assertEquals('3', $city->getCity());
        $this->assertTrue($city->getMailableCity());
        $this->assertEquals('4', $city->getStateAbbreviation());
        $this->assertEquals('5', $city->getState());

        $zip = $result->getZIPCodes()[0];
        $this->assertEquals('6', $zip->getZIPCode());
        $this->assertEquals('7', $zip->getZIPCodeType());
        $this->assertEquals('8', $zip->getDefaultCity());
        $this->assertEquals('9', $zip->getCountyFips());
        $this->assertEquals('10', $zip->getCountyName());
        $this->assertEquals('11', $zip->getStateAbbreviation());
        $this->assertEquals('12', $zip->getState());
        $this->assertEquals(13, $zip->getLatitude());
        $this->assertEquals(14, $zip->getLongitude());
        $this->assertEquals('15', $zip->getPrecision());

        $altCounties = $zip->getAlternateCounties()[0];
        $this->assertEquals('16', $altCounties->getCountyFips());
        $this->assertEquals('17', $altCounties->getCountyName());
        $this->assertEquals('18', $altCounties->getStateAbbreviation());
        $this->assertEquals('19', $altCounties->getState());
    }
}
