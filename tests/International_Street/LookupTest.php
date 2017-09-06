<?php

namespace SmartyStreets\PhpSdk\Tests\International_Street;

require_once(dirname(dirname(dirname(__FILE__))) . '/src/International_Street/Lookup.php');
use SmartyStreets\PhpSdk\International_Street\Lookup;
use PHPUnit\Framework\TestCase;

class LookupTest extends TestCase {

    public function testSetsFreeformInput() {
        $freeform = '1';
        $country = '2';
        $lookup = new Lookup();

        $lookup->setFreeformInput($freeform, $country);

        $this->assertEquals($freeform, $lookup->getFreeform());
        $this->assertEquals($country, $lookup->getCountry());
    }

    public function testSetsPostalCodeInput() {
        $address1 = '1';
        $postalCode = '2';
        $country = '3';
        $lookup = new Lookup();

        $lookup->setPostalCodeInput($address1, $postalCode, $country);

        $this->assertEquals($address1, $lookup->getAddress1());
        $this->assertEquals($postalCode, $lookup->getPostalCode());
        $this->assertEquals($country, $lookup->getCountry());
    }

    public function testSetsLocalityInput() {
        $address1 = '1';
        $locality = '2';
        $administrativeArea = '3';
        $country = '4';
        $lookup = new Lookup();

        $lookup->setLocalityInput($address1, $locality, $administrativeArea, $country);

        $this->assertEquals($address1, $lookup->getAddress1());
        $this->assertEquals($locality, $lookup->getLocality());
        $this->assertEquals($administrativeArea, $lookup->getAdministrativeArea());
        $this->assertEquals($country, $lookup->getCountry());
    }
}
