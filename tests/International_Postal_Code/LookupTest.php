<?php

namespace SmartyStreets\PhpSdk\Tests\InternationalPostalCode;

require_once(dirname(dirname(dirname(__FILE__))) . '/src/International_Postal_Code/Lookup.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/International_Postal_Code/LanguageMode.php');
use SmartyStreets\PhpSdk\International_Postal_Code\Lookup;
use SmartyStreets\PhpSdk\International_Postal_Code\LanguageMode;
use PHPUnit\Framework\TestCase;

class LookupTest extends TestCase {

    public function testNothingToSerialize() {
        $lookup = new Lookup();
        $this->assertEquals(0, count($lookup->getResult()));
        $this->assertNull($lookup->getInputId());
        $this->assertNull($lookup->getCountry());
        $this->assertNull($lookup->getLocality());
        $this->assertNull($lookup->getAdministrativeArea());
        $this->assertNull($lookup->getPostalCode());
        $this->assertNull($lookup->getLanguage());
        $this->assertNull($lookup->getMaxResults());
    }

    public function testFullLookup() {
        $lookup = new Lookup();
        $lookup->setInputId("Hello, World!");
        $lookup->setCountry("CAN");
        $lookup->setLocality("Toronto");
        $lookup->setAdministrativeArea("ON");
        $lookup->setPostalCode("ABC DEF");
        $lookup->setLanguage(LanguageMode::Native);
        $lookup->setMaxResults(25);

        $this->assertEquals("Hello, World!", $lookup->getInputId());
        $this->assertEquals("CAN", $lookup->getCountry());
        $this->assertEquals("Toronto", $lookup->getLocality());
        $this->assertEquals("ON", $lookup->getAdministrativeArea());
        $this->assertEquals("ABC DEF", $lookup->getPostalCode());
        $this->assertEquals(LanguageMode::Native, $lookup->getLanguage());
        $this->assertEquals(25, $lookup->getMaxResults());
    }
}

