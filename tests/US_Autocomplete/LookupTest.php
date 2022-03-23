<?php

namespace SmartyStreets\PhpSdk\Tests\US_Autocomplete;

use PHPUnit\Framework\TestCase;
use SmartyStreets\PhpSdk\US_Autocomplete\Lookup;

class LookupTest extends TestCase
{
    public function testSettingMaxSuggestionsLargerThanTenThrowsAnException()
    {
        $lookup = new Lookup();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Max suggestions must be a positive integer no larger than 10.');

        $lookup->setMaxSuggestions(11);
    }
}