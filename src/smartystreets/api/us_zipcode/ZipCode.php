<?php

namespace smartystreets\api\us_zipcode;

require_once('AlternateCounties.php');

class ZipCode {
    private $zipCode,
            $zipCodeType,
            $defaultCity,
            $countyFips,
            $countyName,
            $stateAbbreviation,
            $state,
            $latitude,
            $longitude,
            $precision,
            $alternateCounties;

    public function __construct() {
        $argv = func_get_args();
        $i = func_num_args();
        if (method_exists($this, $f = '__construct' . $i)) {
            call_user_func_array(array($this, $f), $argv);
        }
    }

    public function __construct1($obj) {
        $this->zipCode = $obj["zipcode"];
        $this->zipCodeType = $obj["zipcode_type"];
        $this->defaultCity = $obj["default_city"];
        $this->countyFips = $obj["county_fips"];
        $this->countyName = $obj["county_name"];
        $this->stateAbbreviation = $obj["state_abbreviation"];
        $this->state = $obj["state"];
        $this->latitude = $obj["latitude"];
        $this->longitude = $obj["longitude"];
        $this->precision = $obj["precision"];
        $this->alternateCounties = (isset($obj["alternate_counties"]) ? $obj["alternate_counties"] : array());

        $this->alternateCounties = $this->convertToAlternateCountyObjects();
    }

    private function convertToAlternateCountyObjects() {
        $altCountyObjects = array();

        foreach ($this->alternateCounties as $county)
            $altCountyObjects[] = new AlternateCounties($county);

        return $altCountyObjects;
    }

    //region [ Getters ]

    public function getAlternateCountiesAtIndex($index) {
        return $this->alternateCounties[$index];
    }

    public function getZipCode() {
        return $this->zipCode;
    }

    public function getZipCodeType() {
        return $this->zipCodeType;
    }

    public function getDefaultCity() {
        return $this->defaultCity;
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

    public function getLatitude() {
        return $this->latitude;
    }

    public function getLongitude() {
        return $this->longitude;
    }

    public function getPrecision() {
        return $this->precision;
    }

    public function getAlternateCounties() {
        return $this->alternateCounties;
    }

    //endregion
}