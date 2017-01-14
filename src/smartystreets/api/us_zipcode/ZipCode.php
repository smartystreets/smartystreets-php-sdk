<?php

namespace smartystreets\api\us_zipcode;

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

    public function __construct1($argv) {
        $this->zipCode = $argv["zipcode"];
        $this->zipCodeType = $argv["zipcode_type"];
        $this->defaultCity = $argv["default_city"];
        $this->countyFips = $argv["county_fips"];
        $this->countyName = $argv["county_name"];
        $this->stateAbbreviation = $argv["state_abbreviation"];
        $this->state = $argv["state"];
        $this->latitude = ["latitude"];
        $this->longitude = $argv["longitude"];
        $this->precision = $argv["precision"];
        $this->alternateCounties = $argv["alternate_counties"];

        if ($this->alternateCounties == null)
            $this->alternateCounties = array();

        $this->alternateCounties = $this->convertToAlternateCountyObjects();
    }

    private function convertToAlternateCountyObjects() {
        return array(); //TODO: implement function
    }

    //region [ Getters ]

    public function getAlternateCountiesAtIndex($index) {
        return $this->alternateCounties[$index];
    }

    public function getZipCode()
    {
        return $this->zipCode;
    }

    public function getZipCodeType()
    {
        return $this->zipCodeType;
    }

    public function getDefaultCity()
    {
        return $this->defaultCity;
    }

    public function getCountyFips()
    {
        return $this->countyFips;
    }

    public function getCountyName()
    {
        return $this->countyName;
    }

    public function getStateAbbreviation()
    {
        return $this->stateAbbreviation;
    }

    public function getState()
    {
        return $this->state;
    }

    public function getLatitude()
    {
        return $this->latitude;
    }

    public function getLongitude()
    {
        return $this->longitude;
    }

    public function getPrecision()
    {
        return $this->precision;
    }

    public function getAlternateCounties()
    {
        return $this->alternateCounties;
    }

    //endregion
}