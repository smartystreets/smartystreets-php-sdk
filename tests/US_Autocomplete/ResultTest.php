<?php

namespace SmartyStreets\PhpSdk\Tests\US_Autocomplete;

require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_Autocomplete/Result.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_Autocomplete/Suggestion.php');
use SmartyStreets\PhpSdk\US_Autocomplete\Result;
use SmartyStreets\PhpSdk\US_Autocomplete\Suggestion;use PHPUnit\Framework\TestCase;

class ResultTest extends TestCase {
    private $obj;

    public function setUp() : void {
        $this->obj = array(
            'suggestions' => array( array(
                'text' => '1',
                'street_line' => '2',
                'city' => '3',
                'state' => '4')
            )
        );
    }

    public function testAllFieldsGetFilledInCorrectly() {
        $result = new Result($this->obj);

        $suggestion = $result->getSuggestion(0);

        $this->assertEquals('1', $suggestion->getText());
        $this->assertEquals('2', $suggestion->getStreetLine());
        $this->assertEquals('3', $suggestion->getCity());
        $this->assertEquals('4', $suggestion->getState());
    }
}
