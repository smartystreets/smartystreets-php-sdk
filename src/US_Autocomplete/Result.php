<?php

namespace SmartyStreets\PhpSdk\US_Autocomplete;

class Result {
    private $suggestions;

    public function __construct() {
        $this->suggestions = array();
    }

    public function getSuggestions() {
        return $this->suggestions;
    }

    public function getSuggestion($index) {
        return $this->suggestions[$index];
    }
}