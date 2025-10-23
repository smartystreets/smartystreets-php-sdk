<?php

namespace SmartyStreets\PhpSdk\US_ZIPCode;

require_once(__DIR__ . '/../ArrayUtil.php');
use SmartyStreets\PhpSdk\ArrayUtil;

/**
 * @see "https://smartystreets.com/docs/cloud/us-zipcode-api#zipcodes"
 */
class AlternateCounties {
    private $countyFips,
            $countyName,
            $stateAbbreviation,
            $state;

    public function __construct($obj = null) {
        if ($obj == null)
            return;

        $this->countyFips = ArrayUtil::getField($obj, 'county_fips');
        $this->countyName = ArrayUtil::getField($obj, 'county_name');
        $this->stateAbbreviation = ArrayUtil::getField($obj, 'state_abbreviation');
        $this->state = ArrayUtil::getField($obj, 'state');
    }

    public function getCountyFips() {
        return $this->countyFips;
    }

    public function getCountyName() {
        return $this->countyName;
    }

    public function getStateAbbreviation() {
        return $this->stateAbbreviation;
    }

    public function getState() {
        return $this->state;
    }

}