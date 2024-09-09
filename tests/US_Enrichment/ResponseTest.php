<?php

namespace SmartyStreets\PhpSdk\Tests\US_Enrichment;

require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_Enrichment/Result.php');

use PHPUnit\Framework\TestCase;
use SmartyStreets\PhpSdk\US_Enrichment\Result;

class ResponseTest extends TestCase
{
    private $financialObj,
    $principalObj,
    $geoReferenceObj,
    $secondaryObj,
    $secondaryCountObj;

    public function setUp() : void
    {
        $this->financialObj = array(
            'smarty_key' => '123',
            'data_set_name' => 'property',
            'data_subset_name' => 'financial',
            'attributes' => array(
                'deed_transaction_id' => 'test_id',
                'financial_history' => array(
                    array(
                        'code_title_company' => 'test_company1'
                    ),
                    array(
                        'code_title_company' => 'test_company2'
                    )
                ),
            ),
        );

        $this->principalObj = array(
            'smarty_key' => '123',
            'data_set_name' => 'property',
            'data_subset_name' => 'principal',
            'attributes' => array(
                'bedrooms' => '2',
                'assessor_taxroll_update' => 'test_update'
            ),
        );

        $this->geoReferenceObj = array(
            'smarty_key' => '123',
            'data_set_name' => 'geo-reference',
            'data_subset_name' => null,
            'attributes' => array(
                'census_block' => array(
                    'accuracy' => 'test_accuracy',
                    'geoid' => 'test_id',
                )
            ),
        );

        $this->secondaryObj = array(
            'smarty_key' => '123',
            'root_address' => array(
                'secondary_count' => 2,
                'smarty_key' => '123',
            ),
            'aliases' => array(
                array(
                    'smarty_key' => '123',
                    'primary_number' => '1234',
                ),
                array(
                    'smarty_key' => '123',
                    'primary_number' => '2345',
                )
            ),
            'secondaries' => array(
                array(
                    'smarty_key' => '234',
                    'secondary_designator' => 'apt',
                ),
                array(
                    'smarty_key' => '345',
                    'secondary_designator' => 'apt',
                )
            ),
        );

        $this->secondaryCountObj = array(
            'smarty_key' => '123',
            'count' => 2,
        );


    }

    public function testAllFinancialFieldsFilledCorrectly()
    {
        $result = new Result($this->financialObj);

        $this->assertEquals("123", $result->smartyKey);
        $this->assertEquals('property', $result->dataSetName);
        $this->assertEquals('financial', $result->dataSubsetName);

        $attributes = $result->attributes;

        $this->assertEquals('test_id', $attributes->deedTransactionId);

        $financialHistory = $attributes->financialHistory;

        $this->assertEquals(2, count($financialHistory));
        $this->assertEquals('test_company1', $financialHistory[0]->codeTitleCompany);
        $this->assertEquals('test_company2', $financialHistory[1]->codeTitleCompany);
    }

    public function testAllPrincipalFieldsFilledCorrectly()
    {
        $result = new Result($this->principalObj);

        $this->assertEquals("123", $result->smartyKey);
        $this->assertEquals('property', $result->dataSetName);
        $this->assertEquals('principal', $result->dataSubsetName);

        $attributes = $result->attributes;

        $this->assertEquals('2', $attributes->bedrooms);
        $this->assertEquals('test_update', $attributes->assessorTaxrollUpdate);
    }

    public function testAllGeoReferenceFieldsFilledCorrectly()
    {
        $result = new Result($this->geoReferenceObj);

        $this->assertEquals('123', $result->smartyKey);
        $this->assertEquals('geo-reference', $result->dataSetName);
        $this->assertNull($result->dataSubsetName);

        $attributes = $result->attributes;
        $censusBlock = $attributes->censusBlock;

        $this->assertEquals('test_accuracy', $censusBlock->accuracy);
        $this->assertEquals('test_id', $censusBlock->geoid);
    }

    public function testAllSecondaryFieldsFilledCorrectly()
    {
        $result = new Result($this->secondaryObj);

        $this->assertEquals('123', $result->smartyKey);
        
        $rootAddress = $result->rootAddress;

        $this->assertEquals(2, $rootAddress->secondaryCount);
        $this->assertEquals('123', $rootAddress->smartyKey);

        $aliases = $result->aliases;

        $this->assertEquals('123', $aliases[0][0]->smartyKey);
        $this->assertEquals('1234', $aliases[0][0]->primaryNumber);

        $this->assertEquals('123', $aliases[0][1]->smartyKey);
        $this->assertEquals('2345', $aliases[0][1]->primaryNumber);

        $secondaries = $result->secondaries;

        $this->assertEquals('234', $secondaries[0][0]->smartyKey);
        $this->assertEquals('apt', $secondaries[0][0]->secondaryDesignator);

        $this->assertEquals('345', $secondaries[0][1]->smartyKey);
        $this->assertEquals('apt', $secondaries[0][1]->secondaryDesignator);
    }

    public function testAllSecondaryCountFieldsFilledCorrectly()
    {
        $result = new Result($this->secondaryCountObj);

        $this->assertEquals('123', $result->smartyKey);
        $this->assertEquals(2, $result->count);
    }
}
