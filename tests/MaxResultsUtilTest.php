<?php

namespace SmartyStreets\PhpSdk\Tests;

require_once(dirname(dirname(__FILE__)) . '/src/MaxResultsUtil.php');
require_once(dirname(dirname(__FILE__)) . '/src/Exceptions/UnprocessableEntityException.php');
use SmartyStreets\PhpSdk\MaxResultsUtil;
use SmartyStreets\PhpSdk\Exceptions\UnprocessableEntityException;
use PHPUnit\Framework\TestCase;

class MaxResultsUtilTest extends TestCase {

    public function testWholeNumbersAreConvertedAndSent() {
        $this->assertEquals("5", MaxResultsUtil::normalize(5));
        $this->assertEquals("5", MaxResultsUtil::normalize("5"));
        $this->assertEquals("7", MaxResultsUtil::normalize(" 7 "));
        $this->assertEquals("5", MaxResultsUtil::normalize(5.0));
        $this->assertEquals("3", MaxResultsUtil::normalize("+3"));
        $this->assertEquals("1000", MaxResultsUtil::normalize(1000));
    }

    public function testUnsetAndValuesNotAboveZeroAreNotSent() {
        foreach ([null, "", "  ", 0, "0", -1, "-2"] as $value) {
            $this->assertNull(MaxResultsUtil::normalize($value), "expected " . var_export($value, true) . " to not be sent");
        }
    }

    public function testValuesThatAreNotWholeNumbersThrow() {
        foreach (["abc", "1.5", 1.5, true] as $value) {
            try {
                MaxResultsUtil::normalize($value);
                $this->fail("expected " . var_export($value, true) . " to throw");
            } catch (UnprocessableEntityException $e) {
                $this->assertEquals("invalid max_results value; must be a whole number", $e->getMessage());
            }
        }
    }
}
