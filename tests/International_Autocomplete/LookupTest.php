<?php

namespace SmartyStreets\PhpSdk\Tests\International_Autocomplete;

require_once(dirname(dirname(dirname(__FILE__))) . '/src/International_Autocomplete/Lookup.php');
use SmartyStreets\PhpSdk\International_Autocomplete\Lookup;
use PHPUnit\Framework\TestCase;

class LookupTest extends TestCase {
    public function testConstructorAndGetters() {
        $lookup = new Lookup('search');
        $this->assertEquals('search', $lookup->getSearch());
        $this->assertEquals(10, $lookup->getMaxResults());
        $this->assertIsArray($lookup->getResult());
        $this->assertIsArray($lookup->getCustomParamArray());
    }

    public function testSettersAndGetters() {
        $lookup = new Lookup();
        $lookup->setCountry('US');
        $lookup->setSearch('foo');
        $lookup->setAddressID('bar');
        $lookup->setMaxResults(5);
        $lookup->setLocality('local');
        $lookup->setPostalCode('90210');
        $this->assertEquals('US', $lookup->getCountry());
        $this->assertEquals('foo', $lookup->getSearch());
        $this->assertEquals('bar', $lookup->getAddressID());
        $this->assertEquals(5, $lookup->getMaxResults());
        $this->assertEquals('local', $lookup->getLocality());
        $this->assertEquals('90210', $lookup->getPostalCode());
    }

    public function testSetMaxResultsThrowsOnInvalid() {
        $this->expectException(\InvalidArgumentException::class);
        $lookup = new Lookup();
        $lookup->setMaxResults(0);
    }

    public function testGetResultAtIndexThrowsOnInvalid() {
        $lookup = new Lookup();
        try {
            $lookup->getResultAtIndex(1);
            $this->fail('Expected exception was not thrown');
        } catch (\OutOfBoundsException | \Error $e) {
            $this->assertTrue($e instanceof \OutOfBoundsException || $e instanceof \Error);
        }
    }

    public function testAddCustomParameter() {
        $lookup = new Lookup();
        $lookup->addCustomParameter('foo', 'bar');
        $this->assertEquals(['foo' => 'bar'], $lookup->getCustomParamArray());
    }
} 