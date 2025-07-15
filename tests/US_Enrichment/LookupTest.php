<?php

namespace SmartyStreets\PhpSdk\Tests\US_Enrichment;

use PHPUnit\Framework\TestCase;
use SmartyStreets\PhpSdk\US_Enrichment\Lookup;

class LookupTest extends TestCase
{
    public function testSettersAndGetters() {
        $lookup = new Lookup();
        $lookup->setSmartyKey('key');
        $lookup->setDataSetName('ds');
        $lookup->setDataSubsetName('dss');
        $lookup->setFreeform('free');
        $lookup->setStreet('street');
        $lookup->setCity('city');
        $lookup->setState('state');
        $lookup->setZipcode('zip');
        $lookup->setIncludeArray(['a','b']);
        $lookup->setExcludeArray(['x','y']);
        $lookup->setResponse(['resp']);
        $lookup->addCustomParameter('foo', 'bar');
        $this->assertEquals('key', $lookup->getSmartyKey());
        $this->assertEquals('ds', $lookup->getDataSetName());
        $this->assertEquals('dss', $lookup->getDataSubsetName());
        $this->assertEquals('free', $lookup->getFreeform());
        $this->assertEquals('street', $lookup->getStreet());
        $this->assertEquals('city', $lookup->getCity());
        $this->assertEquals('state', $lookup->getState());
        $this->assertEquals('zip', $lookup->getZipcode());
        $this->assertEquals(['a','b'], $lookup->getIncludeArray());
        $this->assertEquals(['x','y'], $lookup->getExcludeArray());
        $this->assertEquals(['resp'], $lookup->getResponse());
        $this->assertEquals(['foo'=>'bar'], $lookup->getCustomParamArray());
    }

    public function testAddIncludeAndExcludeAttribute() {
        $lookup = new Lookup();
        $lookup->addIncludeAttribute('inc1');
        $lookup->addIncludeAttribute('inc2');
        $lookup->addExcludeAttribute('exc1');
        $lookup->addExcludeAttribute('exc2');
        $this->assertEquals(['inc1','inc2'], $lookup->getIncludeArray());
        $this->assertEquals(['exc1','exc2'], $lookup->getExcludeArray());
    }

    public function testAddCustomParameterOverwrites() {
        $lookup = new Lookup();
        $lookup->addCustomParameter('foo', 'bar');
        $lookup->addCustomParameter('foo', 'baz');
        $this->assertEquals(['foo'=>'baz'], $lookup->getCustomParamArray());
    }

    public function testDefaultValues() {
        $lookup = new Lookup();
        $this->assertEquals([], $lookup->getIncludeArray());
        $this->assertEquals([], $lookup->getExcludeArray());
        $this->assertEquals([], $lookup->getCustomParamArray());
        $this->assertNull($lookup->getResponse());
    }
} 