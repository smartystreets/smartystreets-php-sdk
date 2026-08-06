<?php

namespace SmartyStreets\PhpSdk\Tests\International_Street;

require_once(dirname(dirname(dirname(__FILE__))) . '/src/International_Street/LanguageMode.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/Exceptions/UnprocessableEntityException.php');
use SmartyStreets\PhpSdk\International_Street\LanguageMode;
use SmartyStreets\PhpSdk\Exceptions\UnprocessableEntityException;
use PHPUnit\Framework\TestCase;

class LanguageModeTest extends TestCase {

    public function testFromValueResolvesMixedCase() {
        $this->assertEquals(LanguageMode::Latin, LanguageMode::fromValue("Latin"));
        $this->assertEquals(LanguageMode::Native, LanguageMode::fromValue("NATIVE"));
        $this->assertEquals(LanguageMode::Latin, LanguageMode::fromValue("latin"));
    }

    public function testFromValueRejectsInvalidValue() {
        $this->expectException(UnprocessableEntityException::class);

        LanguageMode::fromValue("Klingon");
    }

    public function testEnumValuesAreLowercase() {
        $this->assertEquals("native", LanguageMode::Native->value);
        $this->assertEquals("latin", LanguageMode::Latin->value);
    }
}
