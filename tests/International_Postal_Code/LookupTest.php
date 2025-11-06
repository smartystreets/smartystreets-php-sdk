<?php

namespace SmartyStreets\PhpSdk\Tests\International_Postal_Code;

require_once(dirname(dirname(dirname(__FILE__))) . '/src/International_Postal_Code/Lookup.php');
use SmartyStreets\PhpSdk\International_Postal_Code\Lookup;
use PHPUnit\Framework\TestCase;

class LookupTest extends TestCase {
    public function testNothingToSerialize() {
        $lookup = new Lookup();
        $query = array();
        $lookup->populateQuery($query);
        $this->assertEmpty($query);
    }

    public function testFullLookup() {
        $lookup = new Lookup();
        $lookup->setInputId('Hello, World!');
        $lookup->setCountry('CAN');
        $lookup->setLocality('Toronto');
        $lookup->setAdministrativeArea('ON');
        $lookup->setPostalCode('ABC DEF');
        $query = array();
        $lookup->populateQuery($query);

        $this->assertCount(5, $query);
        $this->assertEquals('Hello, World!', $query['input_id']);
        $this->assertEquals('CAN', $query['country']);
        $this->assertEquals('Toronto', $query['locality']);
        $this->assertEquals('ON', $query['administrative_area']);
        $this->assertEquals('ABC DEF', $query['postal_code']);
    }

    public function testConstructorAndGetters() {
        $lookup = new Lookup();
        $this->assertIsArray($lookup->getResults());
        $this->assertIsArray($lookup->getCustomParamArray());
    }

    public function testSettersAndGetters() {
        $lookup = new Lookup();
        $lookup->setInputId('ID-123');
        $lookup->setCountry('US');
        $lookup->setLocality('New York');
        $lookup->setAdministrativeArea('NY');
        $lookup->setPostalCode('10001');
        $this->assertEquals('ID-123', $lookup->getInputId());
        $this->assertEquals('US', $lookup->getCountry());
        $this->assertEquals('New York', $lookup->getLocality());
        $this->assertEquals('NY', $lookup->getAdministrativeArea());
        $this->assertEquals('10001', $lookup->getPostalCode());
    }

    public function testAddCustomParameter() {
        $lookup = new Lookup();
        $lookup->addCustomParameter('foo', 'bar');
        $this->assertEquals(['foo' => 'bar'], $lookup->getCustomParamArray());
    }

    public function testPopulateQuerySkipsEmptyValues() {
        $lookup = new Lookup();
        $lookup->setInputId('ID-123');
        $lookup->setCountry(''); // Empty value
        $lookup->setLocality('   '); // Whitespace only
        $lookup->setAdministrativeArea('ON');
        $query = array();
        $lookup->populateQuery($query);

        $this->assertCount(2, $query);
        $this->assertEquals('ID-123', $query['input_id']);
        $this->assertEquals('ON', $query['administrative_area']);
        $this->assertArrayNotHasKey('country', $query);
        $this->assertArrayNotHasKey('locality', $query);
    }
}

