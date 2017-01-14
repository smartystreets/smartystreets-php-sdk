<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/src/smartystreets/api/us_zipcode/Lookup.php');
use smartystreets\api\us_zipcode\Lookup as Lookup;

class LookupTest extends \PHPUnit_Framework_TestCase {
    function testConstructorCreatesResult() {
        //TODO: create Result class, then implement this test
    }

    function testLookupConstructorSetsZipcode() {
        $lookup = new Lookup("12345");

        $this->assertEquals("12345", $lookup->getZipcode());
    }

    function testLookupConstructorSetsCityAndState() {
        $lookup = new Lookup("city", "state");

        $this->assertEquals("city", $lookup->getCity());
        $this->assertEquals("state", $lookup->getState());
    }

    function testLookupConstructorSetsCityStateAndZipcode() {
        $lookup = new Lookup("city", "state", "12345");

        $this->assertEquals("city", $lookup->getCity());
        $this->assertEquals("state", $lookup->getState());
        $this->assertEquals("12345", $lookup->getZipcode());
    }
}