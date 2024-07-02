<?php

namespace SmartyStreets\PhpSdk\Tests\International_Autocomplete;

require_once(dirname(dirname(dirname(__FILE__))) . '/src/International_Autocomplete/Result.php');
use SmartyStreets\PhpSdk\International_Autocomplete\Result;
use PHPUnit\Framework\TestCase;

class ResultTest extends TestCase {
    private $obj;

    public function setUp() : void {
        $this->obj = array(
            "candidates" => array(
                array(
                    "street" => "0",
                    "locality" => "1",
                    "administrative_area" => "2",
                    "administrative_area_short" => "2.0",
                    "administrative_area_long" => "2.1",
                    "postal_code" => "3",
                    "country_iso3" => "4"
                ),
                array(
                    "entries" => "5",
                    "address_id" => "6",
                    "address_text" => "7",
                )
            )
        );
    }

    public function testAllFieldsFilledCorrectly() {
        $result = new Result($this->obj);


        // region [ Candidates 1 ]
        $this->assertEquals("0", $result->getCandidate(0)->getStreet());
        $this->assertEquals("1", $result->getCandidate(0)->getLocality());
        $this->assertEquals("2", $result->getCandidate(0)->getAdministrativeArea());
        $this->assertEquals("2.0", $result->getCandidate(0)->getAdministrativeAreaShort());
        $this->assertEquals("2.1", $result->getCandidate(0)->getAdministrativeAreaLong());
        $this->assertEquals("3", $result->getCandidate(0)->getPostalCode());
        $this->assertEquals("4", $result->getCandidate(0)->getCountryISO3());
        // endregion

        // region [ Candidates 2 ]
        $this->assertEquals("5", $result->getCandidate(1)->getEntries());
        $this->assertEquals("6", $result->getCandidate(1)->getAddressID());
        $this->assertEquals("7", $result->getCandidate(1)->getAddressText());
        // endregion
    }
}
