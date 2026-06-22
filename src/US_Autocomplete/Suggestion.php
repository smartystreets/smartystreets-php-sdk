<?php

namespace SmartyStreets\PhpSdk\US_Autocomplete;

require_once(__DIR__ . '/../ArrayUtil.php');
use SmartyStreets\PhpSdk\ArrayUtil;

/**
 * @see "https://www.smarty.com/docs/apis/us-autocomplete-v2/reference#http-response-status"
 */
class Suggestion {
    private $smartyKey,
            $entryID,
            $streetLine,
            $secondary,
            $city,
            $state,
            $zipcode,
            $entries;
            $source;

    public function __construct($obj = null) {
        if ($obj == null)
            return;

        $this->smartyKey = ArrayUtil::getField($obj, 'smarty_key');
        $this->entryID = ArrayUtil::getField($obj, 'entry_id');
        $this->streetLine = ArrayUtil::getField($obj, 'street_line');
        $this->secondary = ArrayUtil::getField($obj, 'secondary');
        $this->city = ArrayUtil::getField($obj, 'city');
        $this->state = ArrayUtil::getField($obj, 'state');
        $this->zipcode = ArrayUtil::getField($obj, 'zipcode');
        $this->entries = ArrayUtil::getField($obj, 'entries');
        $this->source = ArrayUtil::getField($obj, 'source');
    }

    public function getSmartyKey() {
        return $this->smartyKey;
    }

    public function getEntryID() {
        return $this->entryID;
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

    public function getSource() {
        return $this->source;
    }
}
