<?php

namespace SmartyStreets\PhpSdk\Tests\US_Extract;

require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_Extract/Result.php');
use SmartyStreets\PhpSdk\US_Extract\Result;
use PHPUnit\Framework\TestCase;

class ResultTest extends TestCase {
    private $obj;

    public function setUp() : void {
        $this->obj = array(
            "meta" => array(
                'lines' => 1,
                'unicode' => true,
                'address_count' => 2,
                'verified_count' => 3,
                'bytes' => 4,
                'character_count' => 5
            ),
            'addresses' => array(
                array(
                    'text' => '6',
                    'verified' => true,
                    'line' => 7,
                    'start' => 8,
                    'end' => 9,
                    'api_output' => array()
                ),
                array(
                    'text' => '10'
                )
            )
        );
    }

    public function testAllFieldsFilledCorrectly() {
        $result = new Result($this->obj);

        $metadata = $result->getMetadata();
        $this->assertNotNull($metadata);
        $this->assertEquals(1, $metadata->getLines());
        $this->assertTrue($metadata->isUnicode());
        $this->assertEquals(2, $metadata->getAddressCount());
        $this->assertEquals(3, $metadata->getVerifiedCount());
        $this->assertEquals(4, $metadata->getBytes());
        $this->assertEquals(5, $metadata->getCharacterCount());

        $address = $result->getAddress(0);
        $this->assertNotNull($address);
        $this->assertEquals('6', $address->getText());
        $this->assertTrue($address->isVerified());
        $this->assertEquals(7, $address->getLine());
        $this->assertEquals(8, $address->getStart());
        $this->assertEquals(9, $address->getEnd());
        $this->assertEquals('10', $result->getAddresses()[1]->getText());

        $candidates = $address->getCandidates();
        $this->assertNotNull($candidates);
    }
}
