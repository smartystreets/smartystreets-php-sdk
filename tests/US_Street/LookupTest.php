<?php

namespace SmartyStreets\PhpSdk\Tests\US_Street;

require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_Street/Lookup.php');
use SmartyStreets\PhpSdk\US_Street\Lookup;
use PHPUnit\Framework\TestCase;

class LookupTest extends TestCase {
    public function testConstructorAndGetters() {
        $lookup = new Lookup('street', 'street2', 'secondary', 'city', 'state', 'zipcode', 'lastline', 'addressee', 'urbanization', 'strict', 2, 'id', 'default', 'postal');
        $this->assertEquals('street', $lookup->getStreet());
        $this->assertEquals('street2', $lookup->getStreet2());
        $this->assertEquals('secondary', $lookup->getSecondary());
        $this->assertEquals('city', $lookup->getCity());
        $this->assertEquals('state', $lookup->getState());
        $this->assertEquals('zipcode', $lookup->getZipcode());
        $this->assertEquals('lastline', $lookup->getLastline());
        $this->assertEquals('addressee', $lookup->getAddressee());
        $this->assertEquals('urbanization', $lookup->getUrbanization());
        $this->assertEquals('strict', $lookup->getMatchStrategy());
        $this->assertEquals(2, $lookup->getMaxCandidates());
        $this->assertEquals('id', $lookup->getInputId());
        $this->assertEquals('default', $lookup->getOutputFormat());
        $this->assertEquals('postal', $lookup->getCountySource());
        $this->assertIsArray($lookup->getResult());
        $this->assertIsArray($lookup->getCustomParamArray());
    }

    public function testSettersAndGetters() {
        $lookup = new Lookup();
        $lookup->setInputId('id');
        $lookup->setStreet('street');
        $lookup->setStreet2('street2');
        $lookup->setSecondary('secondary');
        $lookup->setCity('city');
        $lookup->setState('state');
        $lookup->setZipcode('zipcode');
        $lookup->setLastline('lastline');
        $lookup->setAddressee('addressee');
        $lookup->setUrbanization('urbanization');
        $lookup->setMatchStrategy('enhanced');
        $lookup->setMaxCandidates(3);
        $lookup->setOutputFormat('default');
        $lookup->setCountySource('postal');
        $lookup->setResult(['foo']);
        $this->assertEquals('id', $lookup->getInputId());
        $this->assertEquals('street', $lookup->getStreet());
        $this->assertEquals('street2', $lookup->getStreet2());
        $this->assertEquals('secondary', $lookup->getSecondary());
        $this->assertEquals('city', $lookup->getCity());
        $this->assertEquals('state', $lookup->getState());
        $this->assertEquals('zipcode', $lookup->getZipcode());
        $this->assertEquals('lastline', $lookup->getLastline());
        $this->assertEquals('addressee', $lookup->getAddressee());
        $this->assertEquals('urbanization', $lookup->getUrbanization());
        $this->assertEquals('enhanced', $lookup->getMatchStrategy());
        $this->assertEquals(3, $lookup->getMaxCandidates()); // setMaxCandidates(3) overrides the 5
        $this->assertEquals('default', $lookup->getOutputFormat());
        $this->assertEquals('postal', $lookup->getCountySource());
        $this->assertEquals(['foo'], $lookup->getResult());
    }

    public function testSetMatchStrategyEnhancedSetsMaxCandidatesTo5If1() {
        $lookup = new Lookup();
        $this->assertEquals(1, $lookup->getMaxCandidates());
        $lookup->setMatchStrategy('enhanced');
        $this->assertEquals(5, $lookup->getMaxCandidates());
    }

    public function testSetMaxCandidatesThrowsOnInvalid() {
        $this->expectException(\InvalidArgumentException::class);
        $lookup = new Lookup();
        $lookup->setMaxCandidates(0);
    }

    public function testAddCustomParameter() {
        $lookup = new Lookup();
        $lookup->addCustomParameter('foo', 'bar');
        $this->assertEquals(['foo' => 'bar'], $lookup->getCustomParamArray());
    }
} 