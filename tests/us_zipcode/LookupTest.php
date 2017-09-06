<?php

namespace SmartyStreets\PhpSdk\Tests\US_Street;

require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_ZIPCode/Lookup.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_ZIPCode/Result.php');
use SmartyStreets\PhpSdk\US_ZIPCode\Lookup;
use SmartyStreets\PhpSdk\US_ZIPCode\Result;
use PHPUnit\Framework\TestCase;

class LookupTest extends TestCase {
    function testConstructorCreatesResult() {
        $lookup = new Lookup();

        $this->assertEquals($lookup->getResult(), new Result());
    }

    function testLookupConstructorSetsZipcode() {
        $lookup = new Lookup(null, null, "12345");

        $this->assertEquals("12345", $lookup->getZIPCode());
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
        $this->assertEquals("12345", $lookup->getZIPCode());
    }
}