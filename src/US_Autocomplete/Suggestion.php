<?php

namespace SmartyStreets\PhpSdk\US_Autocomplete;

require_once(dirname(dirname(__FILE__)) . '/ArrayUtil.php');
use SmartyStreets\PhpSdk\ArrayUtil;

/**
 * @see "https://smartystreets.com/docs/cloud/us-autocomplete-api#http-response"
 */
class Suggestion {
    private $text,
            $streetLine,
            $city,
            $state;

    public function __construct($obj = null) {
        if ($obj == null)
            return;

        $this->text = ArrayUtil::setField($obj,'text');
        $this->streetLine = ArrayUtil::setField($obj,'street_line');
        $this->city = ArrayUtil::setField($obj,'city');
        $this->state = ArrayUtil::setField($obj,'state');
    }

    public function getText() {
        return $this->text;
    }

    public function getStreetLine() {
        return $this->streetLine;
    }

    public function getCity() {
        return $this->city;
    }

    public function getState() {
        return $this->state;
    }
}