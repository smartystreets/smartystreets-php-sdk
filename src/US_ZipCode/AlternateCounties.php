<?php

namespace SmartyStreets\US_ZipCode;

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
        $this->countyFips = $this->setField($obj, 'county_fips');
        $this->countyName = $this->setField($obj, 'county_name');
        $this->stateAbbreviation = $this->setField($obj, 'state_abbreviation');
        $this->state = $this->setField($obj, 'state');
    }

    private function setField($obj, $key, $typeIfKeyNotFound = null) {
        if (isset($obj[$key]))
            return $obj[$key];
        else
            return $typeIfKeyNotFound;
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