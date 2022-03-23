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
}