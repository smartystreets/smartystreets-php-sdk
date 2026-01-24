<?php

namespace SmartyStreets\PhpSdk\Tests\US_Street_Lookup;

require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_Street/Lookup.php');
use SmartyStreets\PhpSdk\US_Street\Lookup;
use PHPUnit\Framework\TestCase;

class LookupTest extends TestCase {

    private function encode(Lookup $lookup) {
        $serialized = $lookup->jsonSerialize();
        $result = array();
        foreach ($serialized as $key => $value) {
            if ($value !== null) {
                $result[$key] = $value;
            }
        }
        return $result;
    }

    public function testQueryStringEncoding_OnlySerializeNonDefaultFields() {
        $lookup = new Lookup();
        $lookup->setStreet("A");
        $this->assertEquals(array('street' => 'A', 'match' => 'enhanced', 'candidates' => 5), $this->encode($lookup));

        $lookup = new Lookup();
        $lookup->setStreet2("A");
        $this->assertEquals(array('street2' => 'A', 'match' => 'enhanced', 'candidates' => 5), $this->encode($lookup));

        $lookup = new Lookup();
        $lookup->setSecondary("A");
        $this->assertEquals(array('secondary' => 'A', 'match' => 'enhanced', 'candidates' => 5), $this->encode($lookup));

        $lookup = new Lookup();
        $lookup->setCity("A");
        $this->assertEquals(array('city' => 'A', 'match' => 'enhanced', 'candidates' => 5), $this->encode($lookup));

        $lookup = new Lookup();
        $lookup->setState("A");
        $this->assertEquals(array('state' => 'A', 'match' => 'enhanced', 'candidates' => 5), $this->encode($lookup));

        $lookup = new Lookup();
        $lookup->setZipcode("A");
        $this->assertEquals(array('zipcode' => 'A', 'match' => 'enhanced', 'candidates' => 5), $this->encode($lookup));

        $lookup = new Lookup();
        $lookup->setLastline("A");
        $this->assertEquals(array('lastline' => 'A', 'match' => 'enhanced', 'candidates' => 5), $this->encode($lookup));

        $lookup = new Lookup();
        $lookup->setAddressee("A");
        $this->assertEquals(array('addressee' => 'A', 'match' => 'enhanced', 'candidates' => 5), $this->encode($lookup));

        $lookup = new Lookup();
        $lookup->setUrbanization("A");
        $this->assertEquals(array('urbanization' => 'A', 'match' => 'enhanced', 'candidates' => 5), $this->encode($lookup));

        $lookup = new Lookup();
        $lookup->setInputId("A");
        $this->assertEquals(array('input_id' => 'A', 'match' => 'enhanced', 'candidates' => 5), $this->encode($lookup));

        $lookup = new Lookup();
        $lookup->setMaxCandidates(2);
        $this->assertEquals(array('candidates' => 2, 'match' => 'enhanced'), $this->encode($lookup));

        $lookup = new Lookup();
        $lookup->setMatchStrategy(Lookup::INVALID);
        $this->assertEquals(array('match' => 'invalid'), $this->encode($lookup));
    }

    public function testQueryStringEncoding_WithOutputFormat() {
        $lookup = new Lookup();
        $lookup->setOutputFormat(Lookup::FORMAT_DEFAULT);
        $this->assertEquals(array('format' => 'default', 'match' => 'enhanced', 'candidates' => 5), $this->encode($lookup));

        $lookup = new Lookup();
        $lookup->setOutputFormat(Lookup::PROJECT_USA);
        $this->assertEquals(array('format' => 'project-usa', 'match' => 'enhanced', 'candidates' => 5), $this->encode($lookup));
    }

    public function testQueryStringEncoding_CountySourceSerialized() {
        $lookup = new Lookup();
        $lookup->setCountySource(Lookup::GEOGRAPHIC);
        $this->assertEquals(array('county_source' => 'geographic', 'match' => 'enhanced', 'candidates' => 5), $this->encode($lookup));
    }

    public function testQueryStringEncoding_CustomParameters() {
        $lookup = new Lookup();
        $lookup->addCustomParameter("test_parameter", "hello");
        $this->assertEquals(array('test_parameter' => 'hello', 'match' => 'enhanced', 'candidates' => 5), $this->encode($lookup));
    }

    public function testQueryStringEncoding_DefaultMatchStrategyIsEnhanced() {
        $lookup = new Lookup();
        $this->assertEquals(array('match' => 'enhanced', 'candidates' => 5), $this->encode($lookup));
    }

    public function testQueryStringEncoding_ExplicitMatchStrict() {
        $lookup = new Lookup();
        $lookup->setMatchStrategy(Lookup::STRICT);
        $this->assertEquals(array(), $this->encode($lookup));
    }

    public function testQueryStringEncoding_ExplicitMatchStrictWithCandidates() {
        $lookup = new Lookup();
        $lookup->setMatchStrategy(Lookup::STRICT);
        $lookup->setMaxCandidates(3);
        $this->assertEquals(array('candidates' => 3), $this->encode($lookup));
    }
}
