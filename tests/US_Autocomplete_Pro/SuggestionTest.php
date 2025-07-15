<?php

namespace SmartyStreets\PhpSdk\Tests\US_Autocomplete_Pro;

use PHPUnit\Framework\TestCase;
use SmartyStreets\PhpSdk\US_Autocomplete_Pro\Suggestion;

class SuggestionTest extends TestCase
{
    public function testFieldMapping() {
        $obj = [
            'street_line' => '123 Main St',
            'secondary' => 'Apt 1',
            'city' => 'Testville',
            'state' => 'TS',
            'zipcode' => '12345',
            'entries' => 2
        ];
        $s = new Suggestion($obj);
        $this->assertEquals('123 Main St', $s->getStreetLine());
        $this->assertEquals('Apt 1', $s->getSecondary());
        $this->assertEquals('Testville', $s->getCity());
        $this->assertEquals('TS', $s->getState());
        $this->assertEquals('12345', $s->getZIPCode());
        $this->assertEquals(2, $s->getEntries());
    }

    public function testNullAndEmptyInput() {
        $s = new Suggestion();
        $this->assertNull($s->getStreetLine());
        $this->assertNull($s->getSecondary());
        $this->assertNull($s->getCity());
        $this->assertNull($s->getState());
        $this->assertNull($s->getZIPCode());
        $this->assertNull($s->getEntries());
    }

    public function testMissingFields() {
        $obj = [ 'street_line' => 'Only Street' ];
        $s = new Suggestion($obj);
        $this->assertEquals('Only Street', $s->getStreetLine());
        $this->assertNull($s->getSecondary());
        $this->assertNull($s->getCity());
        $this->assertNull($s->getState());
        $this->assertNull($s->getZIPCode());
        $this->assertNull($s->getEntries());
    }

    public function testExtraFieldsAreIgnored() {
        $obj = [
            'street_line' => 'Extra',
            'city' => 'City',
            'extra_field' => 'ignoreme'
        ];
        $s = new Suggestion($obj);
        $this->assertEquals('Extra', $s->getStreetLine());
        $this->assertEquals('City', $s->getCity());
        $this->assertFalse(property_exists($s, 'extra_field'));
    }
} 