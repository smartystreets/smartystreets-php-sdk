<?php

namespace SmartyStreets\PhpSdk\Tests\US_Extract;

require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_Extract/Lookup.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_Extract/Result.php');
use SmartyStreets\PhpSdk\US_Extract\Lookup;
use SmartyStreets\PhpSdk\US_Extract\Result;
use PHPUnit\Framework\TestCase;

class LookupTest extends TestCase {
    public function testConstructorDefaults() {
        $lookup = new Lookup('text');
        $this->assertInstanceOf(Result::class, $lookup->getResult());
        $this->assertFalse($lookup->isAggressive());
        $this->assertTrue($lookup->addressesHaveLineBreaks());
        $this->assertEquals(0, $lookup->getAddressesPerLine());
        $this->assertEquals('', $lookup->getMatchStrategy());
        $this->assertEquals('text', $lookup->getText());
        $this->assertIsArray($lookup->getCustomParamArray());
    }

    public function testSettersAndGetters() {
        $lookup = new Lookup();
        $result = new Result();
        $lookup->setResult($result);
        $lookup->specifyHtmlInput(true);
        $lookup->setAggressive(true);
        $lookup->setAddressesHaveLineBreaks(false);
        $lookup->setAddressesPerLine(2);
        $lookup->setMatchStrategy('strict');
        $lookup->setText('foo');
        $this->assertSame($result, $lookup->getResult());
        $this->assertTrue($lookup->isHtml());
        $this->assertTrue($lookup->isAggressive());
        $this->assertFalse($lookup->addressesHaveLineBreaks());
        $this->assertEquals(2, $lookup->getAddressesPerLine());
        $this->assertEquals('strict', $lookup->getMatchStrategy());
        $this->assertEquals('foo', $lookup->getText());
    }

    public function testAddCustomParameter() {
        $lookup = new Lookup();
        $lookup->addCustomParameter('foo', 'bar');
        $this->assertEquals(['foo' => 'bar'], $lookup->getCustomParamArray());
    }
} 