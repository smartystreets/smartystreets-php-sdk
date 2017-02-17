<?php

namespace SmartyStreets\US_ZipCode;

require_once(dirname(dirname(__FILE__)) . '/ArrayUtil.php');
use SmartyStreets\ArrayUtil;

class AlternateCounties {
    private $countyFips,
            $countyName,
            $stateAbbreviation,
            $state;

    public function __construct($obj = null) {
        if ($obj == null)
            return;

        $this->countyFips = ArrayUtil::setField($obj, 'county_fips');
        $this->countyName = ArrayUtil::setField($obj, 'county_name');
        $this->stateAbbreviation = ArrayUtil::setField($obj, 'state_abbreviation');
        $this->state = ArrayUtil::setField($obj, 'state');
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