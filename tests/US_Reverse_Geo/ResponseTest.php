<?php

namespace SmartyStreets\PhpSdk\Tests\US_Reverse_Geo;

require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_Reverse_Geo/Response.php');

use SmartyStreets\PhpSdk\US_Reverse_Geo\Response;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    private $obj;

    public function setUp(): void
    {
        $this->obj = array(
            'results' => array(
                array(
                    'coordinate' => array(
                        'latitude' => 1.1,
                        'longitude' => 2.2,
                        'accuracy' => '3',
                        'license' => 4
                    ),
                    'distance' => 5.5,
                    'address' => array(
                        'street' => '6',
                        'city' => '7',
                        'state_abbreviation' => '8',
                        'zipcode' => '9'
                    )
                )
            )
        );
    }

    public function testAllFieldsFilledCorrectly()
    {
        $response = new Response($this->obj);
        $results = $response->getResults();
        $this->assertIsArray($results);
        $result = $results[0];

        $coordinate = $result->getCoordinate();
        $this->assertNotNull($coordinate);
        $this->assertEquals(1.1, $coordinate->getLatitude());
        $this->assertEquals(2.2, $coordinate->getLongitude());
        $this->assertEquals('3', $coordinate->getAccuracy());
        $this->assertEquals('SmartyStreets', $coordinate->getLicense());

        $this->assertEquals(5.5, $result->getDistance());

        $address = $result->getAddress();
        $this->assertNotNull($address);
        $this->assertEquals('6', $address->getStreet());
        $this->assertEquals('7', $address->getCity());
        $this->assertEquals('8', $address->getStateAbbreviation());
        $this->assertEquals('9', $address->getZIPCode());
    }

    public function testConstructionWithMissingFields() {
        $response = new Response([]);
        $results = $response->getResults();
        if ($results === null) {
            $this->assertNull($results);
        } else {
            $this->assertIsArray($results);
        }
    }

    public function testConstructionWithAllNulls() {
        $response = new Response(null);
        $results = $response->getResults();
        if ($results === null) {
            $this->assertNull($results);
        } else {
            $this->assertIsArray($results);
        }
    }
}