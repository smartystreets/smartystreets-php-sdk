<?php

namespace SmartyStreets\PhpSdk\Tests\US_Enrichment;

use PHPUnit\Framework\TestCase;
use SmartyStreets\PhpSdk\US_Enrichment\FinancialAttributes;
use SmartyStreets\PhpSdk\US_Enrichment\PrincipalAttributes;
use SmartyStreets\PhpSdk\US_Enrichment\GeoReferenceAttributes;
use SmartyStreets\PhpSdk\US_Enrichment\SecondaryAttributes;

class AttributesTest extends TestCase
{
    public function testFinancialAttributesMapping() {
        $obj = [
            'assessed_value' => 12345,
            'first_name' => 'John',
        ];
        $fa = new FinancialAttributes($obj);
        $this->assertEquals(12345, $fa->assessedValue);
        $this->assertEquals('John', $fa->firstName);
    }

    public function testPrincipalAttributesMapping() {
        $obj = [
            'first_name' => 'Jane',
            'acres' => 2.5,
        ];
        $pa = new PrincipalAttributes($obj);
        $this->assertEquals('Jane', $pa->firstName);
        $this->assertEquals(2.5, $pa->acres);
    }

    public function testGeoReferenceAttributesMapping() {
        $obj = [
            'census_block' => ['geoid' => '123', 'accuracy' => 'high'],
            'census_county_division' => ['code' => 'ccd'],
            'census_tract' => ['code' => 'ct'],
            'core_based_stat_area' => ['code' => 'cbsa'],
            'place' => ['code' => 'pl']
        ];
        $ga = new GeoReferenceAttributes($obj);
        $this->assertEquals('123', $ga->censusBlock->geoid);
        $this->assertEquals('high', $ga->censusBlock->accuracy);
        $this->assertTrue(property_exists($ga->censusCountyDivision, 'code'));
        $this->assertTrue(property_exists($ga->censusTract, 'code'));
        $this->assertTrue(property_exists($ga->coreBasedStatArea, 'code'));
        $this->assertTrue(property_exists($ga->place, 'code'));
    }

    public function testSecondaryAttributesMapping() {
        $obj = [
            'root_address' => ['smarty_key' => 'root'],
            'aliases' => [ ['smarty_key' => 'alias1'], ['smarty_key' => 'alias2'] ],
            'secondaries' => [ ['smarty_key' => 'sec1'], ['smarty_key' => 'sec2'] ]
        ];
        $sa = new SecondaryAttributes($obj);
        $this->assertEquals('root', $sa->rootAddress->smartyKey);
        $this->assertCount(2, $sa->aliases);
        $this->assertEquals('alias1', $sa->aliases[0]->smartyKey);
        $this->assertCount(2, $sa->secondaries);
        $this->assertEquals('sec1', $sa->secondaries[0]->smartyKey);
    }

    public function testNullAndEmptyInput() {
        $fa = new FinancialAttributes();
        $this->assertNull($fa->assessedValue);
        $pa = new PrincipalAttributes();
        $this->assertNull($pa->firstName);
        $ga = new GeoReferenceAttributes();
        $this->assertNull($ga->censusBlock);
        $sa = new SecondaryAttributes();
        $this->assertNull($sa->rootAddress);
    }
} 