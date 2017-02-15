<?php

namespace SmartyStreets\Tests\US_Street;

require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_Zipcode/Lookup.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_Zipcode/Result.php');
use SmartyStreets\US_ZipCode\Lookup;
use SmartyStreets\US_ZipCode\Result;

class LookupTest extends \PHPUnit_Framework_TestCase {
    function testConstructorCreatesResult() {
        $lookup = new Lookup();

        $this->assertEquals($lookup->getResult(), new Result());
    }

    function testLookupConstructorSetsZipcode() {
        $lookup = new Lookup(null, null, "12345");

        $this->assertEquals("12345", $lookup->getZipCode());
    }

    function testLookupConstructorSetsCityAndState() {
        $lookup = new Lookup("city", "state", null);

        $this->assertEquals("city", $lookup->getCity());
        $this->assertEquals("state", $lookup->getState());
    }

    function testLookupConstructorSetsCityStateAndZipcode() {
        $lookup = new Lookup("city", "state", "12345");

        $this->assertEquals("city", $lookup->getCity());
        $this->assertEquals("state", $lookup->getState());
        $this->assertEquals("12345", $lookup->getZipCode());
    }
}