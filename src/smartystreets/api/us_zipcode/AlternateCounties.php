<?php

namespace smartystreets\api\us_zipcode;

class AlternateCounties {
    private $countyFips,
            $countyName,
            $stateAbbreviation,
            $state;

    public function __construct() {
        $argv = func_get_args();
        $i = func_num_args();
        if (method_exists($this, $f = '__construct' . $i)) {
            call_user_func_array(array($this, $f), $argv);
        }
    }

    public function __construct1($obj) {
        $this->countyFips = $obj['county_fips'];
        $this->countyName = $obj['county_name'];
        $this->stateAbbreviation = $obj['state_abbreviation'];
        $this->state = $obj['state'];
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