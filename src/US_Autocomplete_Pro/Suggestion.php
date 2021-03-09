<?php

namespace SmartyStreets\PhpSdk\US_Autocomplete_Pro;

require_once(dirname(dirname(__FILE__)) . '/ArrayUtil.php');
use SmartyStreets\PhpSdk\ArrayUtil;

/**
 * @see "https://smartystreets.com/docs/cloud/us-autocomplete-api#http-response"
 */
class Suggestion {
    private $streetLine,
            $secondary,
            $city,
            $state,
            $zipcode,
            $entries;

    public function __construct($obj = null) {
        if ($obj == null)
            return;

        $this->streetLine = ArrayUtil::setField($obj, 'street_line');
        $this->secondary = ArrayUtil::setField($obj, 'secondary');
        $this->city = ArrayUtil::setField($obj, 'city');
        $this->state = ArrayUtil::setField($obj, 'state');
        $this->zipcode = ArrayUtil::setField($obj, 'zipcode');
        $this->entries = ArrayUtil::setField($obj, 'entries');
    }

    public function getStreetLine() {
        return $this->streetLine;
    }

    public function getSecondary() {
        return $this->secondary;
    }

    public function getCity() {
        return $this->city;
    }

    public function getState() {
        return $this->state;
    }

    public function getZIPCode() {
        return $this->zipcode;
    }

    public function getEntries() {
        return $this->entries;
    }
}