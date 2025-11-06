<?php

namespace SmartyStreets\PhpSdk\Tests\International_Postal_Code;

require_once(dirname(dirname(dirname(__FILE__))) . '/src/International_Postal_Code/Candidate.php');
use SmartyStreets\PhpSdk\International_Postal_Code\Candidate;
use PHPUnit\Framework\TestCase;

class CandidateTest extends TestCase {
    public function testConstructorWithNull() {
        $candidate = new Candidate(null);
        $this->assertNull($candidate->getInputId());
        $this->assertNull($candidate->getAdministrativeArea());
        $this->assertNull($candidate->getLocality());
    }

    public function testConstructorWithFullData() {
        $data = array(
            'input_id' => 'ID-123',
            'country_iso_3' => 'USA',
            'locality' => 'New York',
            'administrative_area' => 'NY',
            'sub_administrative_area' => 'SubArea',
            'super_administrative_area' => 'SuperArea',
            'dependent_locality' => 'DepLoc',
            'dependent_locality_name' => 'DepLocName',
            'double_dependent_locality' => 'DoubleDep',
            'postal_code' => '10001',
            'postal_code_extra' => '1234'
        );
        $candidate = new Candidate($data);

        $this->assertEquals('ID-123', $candidate->getInputId());
        $this->assertEquals('USA', $candidate->getCountryIso3());
        $this->assertEquals('New York', $candidate->getLocality());
        $this->assertEquals('NY', $candidate->getAdministrativeArea());
        $this->assertEquals('SubArea', $candidate->getSubAdministrativeArea());
        $this->assertEquals('SuperArea', $candidate->getSuperAdministrativeArea());
        $this->assertEquals('DepLoc', $candidate->getDependentLocality());
        $this->assertEquals('DepLocName', $candidate->getDependentLocalityName());
        $this->assertEquals('DoubleDep', $candidate->getDoubleDependentLocality());
        $this->assertEquals('10001', $candidate->getPostalCodeShort());
        $this->assertEquals('1234', $candidate->getPostalCodeExtra());
    }

    public function testConstructorWithPartialData() {
        $data = array(
            'input_id' => 'ID-123',
            'locality' => 'New York'
        );
        $candidate = new Candidate($data);

        $this->assertEquals('ID-123', $candidate->getInputId());
        $this->assertEquals('New York', $candidate->getLocality());
        $this->assertNull($candidate->getCountryIso3());
        $this->assertNull($candidate->getAdministrativeArea());
    }

    public function testConstructorWithMissingFields() {
        $data = array();
        $candidate = new Candidate($data);

        $this->assertNull($candidate->getInputId());
        $this->assertNull($candidate->getCountryIso3());
        $this->assertNull($candidate->getLocality());
    }
}

