<?php

namespace SmartyStreets\PhpSdk\Tests\US_Autocomplete_Pro;

use PHPUnit\Framework\TestCase;
use SmartyStreets\PhpSdk\US_Autocomplete_Pro\Result;
use SmartyStreets\PhpSdk\US_Autocomplete_Pro\Suggestion;

class ResultTest extends TestCase
{
    public function testSuggestionsMapping() {
        $obj = [
            'suggestions' => [
                [
                    'street_line' => '123 Main St',
                    'secondary' => 'Apt 1',
                    'city' => 'Testville',
                    'state' => 'TS',
                    'zipcode' => '12345',
                    'entries' => 2
                ],
                [
                    'street_line' => '456 Elm St',
                    'city' => 'Othertown',
                    'state' => 'OT',
                    'zipcode' => '67890',
                    'entries' => 1
                ]
            ]
        ];
        $result = new Result($obj);
        $suggestions = $result->getSuggestions();
        $this->assertCount(2, $suggestions);
        $this->assertInstanceOf(Suggestion::class, $suggestions[0]);
        $this->assertEquals('123 Main St', $suggestions[0]->getStreetLine());
        $this->assertEquals('Apt 1', $suggestions[0]->getSecondary());
        $this->assertEquals('Testville', $suggestions[0]->getCity());
        $this->assertEquals('TS', $suggestions[0]->getState());
        $this->assertEquals('12345', $suggestions[0]->getZIPCode());
        $this->assertEquals(2, $suggestions[0]->getEntries());
        $this->assertEquals('456 Elm St', $suggestions[1]->getStreetLine());
        $this->assertEquals('Othertown', $suggestions[1]->getCity());
        $this->assertEquals('OT', $suggestions[1]->getState());
        $this->assertEquals('67890', $suggestions[1]->getZIPCode());
        $this->assertEquals(1, $suggestions[1]->getEntries());
    }

    public function testGetSuggestionByIndex() {
        $obj = [
            'suggestions' => [
                ['street_line' => 'A'],
                ['street_line' => 'B']
            ]
        ];
        $result = new Result($obj);
        $this->assertEquals('A', $result->getSuggestion(0)->getStreetLine());
        $this->assertEquals('B', $result->getSuggestion(1)->getStreetLine());
    }

    public function testEmptyAndNullInput() {
        $result = new Result();
        $this->assertIsArray($result->getSuggestions());
        $this->assertCount(0, $result->getSuggestions());
        $result2 = new Result(['suggestions' => []]);
        $this->assertIsArray($result2->getSuggestions());
        $this->assertCount(0, $result2->getSuggestions());
    }

    public function testPartialAndExtraFields() {
        $obj = [
            'suggestions' => [
                [
                    'street_line' => 'Partial',
                    'extra_field' => 'ignoreme'
                ]
            ]
        ];
        $result = new Result($obj);
        $suggestion = $result->getSuggestion(0);
        $this->assertEquals('Partial', $suggestion->getStreetLine());
        $this->assertNull($suggestion->getCity());
        $this->assertNull($suggestion->getState());
        $this->assertFalse(property_exists($suggestion, 'extra_field'));
    }
} 