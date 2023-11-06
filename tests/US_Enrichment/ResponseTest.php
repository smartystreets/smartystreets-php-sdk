<?php

namespace SmartyStreets\PhpSdk\Tests\US_Enrichment;

require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_Enrichment/Response.php');

use PHPUnit\Framework\TestCase;
use SmartyStreets\PhpSdk\US_Enrichment\Response;

class ResponseTest extends TestCase
{
    private $obj;

    public function setUp() : void
    {
        $this->obj = array(
            'results' => array(
                array(
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
                )
            )
        );
    }

    public function testAllFieldsFilledCorrectly()
    {
        $response = new Response($this->obj);
        $result = $response->getResults()[0];

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
}
