<?php

namespace SmartyStreets\PhpSdk\Tests\US_Autocomplete;

require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_Autocomplete/Suggestion.php');
use SmartyStreets\PhpSdk\US_Autocomplete\Suggestion;

class SuggestionTest extends \PHPUnit_Framework_TestCase {
    private $obj;

    public function setUp() {
        $this->obj = array(
                'text' => '1',
                'street_line' => '2',
                'city' => '3',
                'state' => '4'
            );
    }

    public function testAllFieldGetFilledInCorrectly() {
        $suggestion = new Suggestion($this->obj);

        $this->assertEquals('1', $suggestion->getText());
        $this->assertEquals('2', $suggestion->getStreetLine());
        $this->assertEquals('3', $suggestion->getCity());
        $this->assertEquals('4', $suggestion->getState());
    }
}
