<?php

namespace SmartyStreets\PhpSdk\Tests\US_Enrichment;

use PHPUnit\Framework\TestCase;
use SmartyStreets\PhpSdk\US_Enrichment\Result;

class ResultTest extends TestCase
{
    public function testPropertyFinancialAttributesMapping() {
        $obj = [
            'smarty_key' => 'key',
            'data_set_name' => 'property',
            'data_subset_name' => 'financial',
            'attributes' => ['assessed_value' => 12345],
            'matched_address' => ['street' => '123 Main St']
        ];
        $result = new Result($obj);
        $this->assertEquals('key', $result->smartyKey);
        $this->assertEquals('property', $result->dataSetName);
        $this->assertEquals('financial', $result->dataSubsetName);
        $this->assertEquals(12345, $result->getAttributes()->assessedValue);
        $this->assertEquals('123 Main St', $result->getMatchedAddress()->street);
    }

    public function testPropertyPrincipalAttributesMapping() {
        $obj = [
            'smarty_key' => 'key',
            'data_set_name' => 'property',
            'data_subset_name' => 'principal',
            'attributes' => ['first_name' => 'John'],
            'matched_address' => ['street' => '456 Main St']
        ];
        $result = new Result($obj);
        $this->assertEquals('principal', $result->dataSubsetName);
        $this->assertEquals('John', $result->getAttributes()->firstName);
        $this->assertEquals('456 Main St', $result->getMatchedAddress()->street);
    }

    public function testGeoReferenceAttributesMapping() {
        $obj = [
            'smarty_key' => 'key',
            'data_set_name' => 'geo-reference',
            'attributes' => [
                'census_block' => [
                    'geoid' => '1234567890',
                    'accuracy' => 'high'
                ],
                'census_county_division' => [],
                'census_tract' => [],
                'core_based_stat_area' => [],
                'place' => []
            ],
            'matched_address' => ['street' => '789 Main St']
        ];
        $result = new Result($obj);
        $this->assertEquals('geo-reference', $result->dataSetName);
        $this->assertEquals('1234567890', $result->getAttributes()->censusBlock->geoid);
        $this->assertEquals('high', $result->getAttributes()->censusBlock->accuracy);
        $this->assertEquals('789 Main St', $result->getMatchedAddress()->street);
    }

    public function testSecondaryAttributesMapping() {
        $obj = [
            'secondaries' => [['foo' => 'bar']],
        ];
        $result = new Result($obj);
        $this->assertEquals('secondary', $result->dataSetName);
        $this->assertNull($result->dataSubsetName);
        $this->assertIsArray($result->getSecondaries());
    }

    public function testSecondaryCountAttributesMapping() {
        $obj = [
            'count' => 42,
        ];
        $result = new Result($obj);
        $this->assertEquals('secondary', $result->dataSetName);
        $this->assertEquals('count', $result->dataSubsetName);
        $this->assertEquals(42, $result->getCount());
    }

    public function testGettersReturnDefaultsIfNull() {
        $result = new Result();
        $this->assertInstanceOf(\SmartyStreets\PhpSdk\US_Enrichment\MatchedAddress::class, $result->getMatchedAddress());
        $this->assertIsObject($result->getAttributes());
        $this->assertIsObject($result->getRootAddress());
        $this->assertIsArray($result->getAliases());
        $this->assertIsArray($result->getSecondaries());
        $this->assertEquals(0, $result->getCount());
    }
} 