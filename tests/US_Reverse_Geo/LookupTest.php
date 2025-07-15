<?php

namespace SmartyStreets\PhpSdk\Tests\US_Reverse_Geo;

require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_Reverse_Geo/Lookup.php');
use SmartyStreets\PhpSdk\US_Reverse_Geo\Lookup;
use PHPUnit\Framework\TestCase;

class LookupTest extends TestCase {
    public function testConstructorStoresCoordinatesAsIs() {
        $lookup = new Lookup(12.345678912, -98.765432198);
        $this->assertSame(12.345678912, $lookup->getLatitude());
        $this->assertSame(-98.765432198, $lookup->getLongitude());
        $lookup2 = new Lookup('foo', 'bar');
        $this->assertSame('foo', $lookup2->getLatitude());
        $this->assertSame('bar', $lookup2->getLongitude());
    }

    public function testSettersAndGetters() {
        $lookup = new Lookup(1, 2);
        $lookup->setSource('foo');
        $lookup->setResponse('bar');
        $this->assertEquals('foo', $lookup->getSource());
        $this->assertEquals('bar', $lookup->getResponse());
    }

    public function testAddCustomParameter() {
        $lookup = new Lookup(1, 2);
        $lookup->addCustomParameter('foo', 'bar');
        $this->assertEquals(['foo' => 'bar'], $lookup->getCustomParamArray());
    }
} 