<?php

namespace SmartyStreets\PhpSdk\Tests\US_Autocomplete_Pro;

require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_Autocomplete_Pro/Lookup.php');
use PHPUnit\Framework\TestCase;
use SmartyStreets\PhpSdk\US_Autocomplete_Pro\Lookup;

class LookupTest extends TestCase
{
    public function testSettingMaxResultsLargerThanTenThrowsAnException()
    {
        $lookup = new Lookup();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Max suggestions must be a positive integer no larger than 10.');

        $lookup->setMaxResults(11);
    }

    public function testMutatorsAndGetters() {
        $lookup = new Lookup('search');
        $lookup->addCityFilter('City1');
        $lookup->addCityFilter('City2');
        $lookup->addStateFilter('ST');
        $lookup->addZIPFilter('12345');
        $lookup->addStateExclusion('XX');
        $lookup->addPreferCity('PrefCity');
        $lookup->addPreferState('PrefST');
        $lookup->addPreferZIPCode('54321');
        $lookup->addCustomParameter('foo', 'bar');
        $lookup->addCustomParameter('foo', 'baz'); // Overwrite
        $lookup->setPreferRatio(80);
        $lookup->setMaxResults(5);
        $lookup->setPreferGeolocation(new \SmartyStreets\PhpSdk\US_Autocomplete_Pro\GeolocateType('city'));
        $lookup->setSelected('selected');
        $lookup->setSource('source');
        $this->assertEquals('search', $lookup->getSearch());
        $this->assertEquals(['City1','City2'], $lookup->getCityFilter());
        $this->assertEquals(['ST'], $lookup->getStateFilter());
        $this->assertEquals(['12345'], $lookup->getZIPFilter());
        $this->assertEquals(['XX'], $lookup->getStateExclusions());
        $this->assertEquals(['PrefCity'], $lookup->getPreferCities());
        $this->assertEquals(['PrefST'], $lookup->getPreferStates());
        $this->assertEquals(['54321'], $lookup->getPreferZIPCodes());
        $this->assertEquals(['foo'=>'baz'], $lookup->getCustomParamArray());
        $this->assertEquals(80, $lookup->getPreferRatio());
        $this->assertEquals(5, $lookup->getMaxResults());
        $this->assertEquals('city', $lookup->getPreferGeolocation()->getName());
        $this->assertEquals('selected', $lookup->getSelected());
        $this->assertEquals('source', $lookup->getSource());
    }

    public function testDefaultValues() {
        $lookup = new Lookup();
        $this->assertEquals([], $lookup->getCityFilter());
        $this->assertEquals([], $lookup->getStateFilter());
        $this->assertEquals([], $lookup->getZIPFilter());
        $this->assertEquals([], $lookup->getStateExclusions());
        $this->assertEquals([], $lookup->getPreferCities());
        $this->assertEquals([], $lookup->getPreferStates());
        $this->assertEquals([], $lookup->getPreferZIPCodes());
        $this->assertEquals([], $lookup->getCustomParamArray());
        $this->assertEquals(10, $lookup->getMaxResults());
        $this->assertEquals(100, $lookup->getPreferRatio());
        $this->assertInstanceOf(\SmartyStreets\PhpSdk\US_Autocomplete_Pro\GeolocateType::class, $lookup->getPreferGeolocation());
        $this->assertNull($lookup->getSelected());
        $this->assertNull($lookup->getSource());
    }

    public function testSettersOverwriteValues() {
        $lookup = new Lookup();
        $lookup->setCityFilter(['A','B']);
        $lookup->setStateFilter(['C']);
        $lookup->setZIPFilter(['D']);
        $lookup->setPreferCities(['E']);
        $lookup->setPreferStates(['F']);
        $lookup->setPreferZIPCodes(['G']);
        $this->assertEquals(['A','B'], $lookup->getCityFilter());
        $this->assertEquals(['C'], $lookup->getStateFilter());
        $this->assertEquals(['D'], $lookup->getZIPFilter());
        $this->assertEquals(['E'], $lookup->getPreferCities());
        $this->assertEquals(['F'], $lookup->getPreferStates());
        $this->assertEquals(['G'], $lookup->getPreferZIPCodes());
    }

    public function testGetMaxResultsStringIfSet() {
        $lookup = new Lookup();
        $this->assertNull($lookup->getMaxResultsStringIfSet());
        $lookup->setMaxResults(7);
        $this->assertEquals('7', $lookup->getMaxResultsStringIfSet());
    }

    public function testGetPreferRatioStringIfSet() {
        $lookup = new Lookup();
        $this->assertNull($lookup->getPreferRatioStringIfSet());
        $lookup->setPreferRatio(77);
        $this->assertEquals('77', $lookup->getPreferRatioStringIfSet());
    }
}