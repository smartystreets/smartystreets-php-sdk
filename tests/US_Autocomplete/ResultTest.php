<?php

namespace SmartyStreets\PhpSdk\Tests\US_Autocomplete;

require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_Autocomplete/Result.php');
use SmartyStreets\PhpSdk\US_Autocomplete\Result;
use PHPUnit\Framework\TestCase;

class ResultTest extends TestCase {
    private $obj;

    public function setUp() : void {
        $this->obj = array(
            "suggestions" => array(
                array(
                    "smarty_key" => "0",
                    "entry_id" => "1",
                    "urbanization" => "urb",
                    "street_line" => "2",
                    "secondary" => "3",
                    "city" => "4",
                    "state" => "5",
                    "zipcode" => "6",
                    "entries" => 7,
                    "source" => "8",
                ),
                array(
                    "smarty_key" => "9",
                    "entry_id" => "10",
                    "street_line" => "11",
                )
            )
        );
    }

    public function testAllFieldsFilledCorrectly() {
        $result = new Result($this->obj);

        $this->assertEquals("0", $result->getSuggestion(0)->getSmartyKey());
        $this->assertEquals("1", $result->getSuggestion(0)->getEntryID());
        $this->assertEquals("urb", $result->getSuggestion(0)->getUrbanization());
        $this->assertEquals("2", $result->getSuggestion(0)->getStreetLine());
        $this->assertEquals("3", $result->getSuggestion(0)->getSecondary());
        $this->assertEquals("4", $result->getSuggestion(0)->getCity());
        $this->assertEquals("5", $result->getSuggestion(0)->getState());
        $this->assertEquals("6", $result->getSuggestion(0)->getZIPCode());
        $this->assertEquals(7, $result->getSuggestion(0)->getEntries());
        $this->assertEquals("8", $result->getSuggestion(0)->getSource());
    }

    public function testUrbanizationDefaultsToNullWhenAbsent() {
        $result = new Result($this->obj);

        $this->assertNull($result->getSuggestion(1)->getUrbanization());
    }
}
