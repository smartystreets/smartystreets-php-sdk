<?php

namespace SmartyStreets\US_ZipCode;

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
        $this->zipCode = $this->setField($obj, "zipcode");
        $this->zipCodeType = $this->setField($obj, "zipcode_type");
        $this->defaultCity = $this->setField($obj, "default_city");
        $this->countyFips = $this->setField($obj, "county_fips");
        $this->countyName = $this->setField($obj, "county_name");
        $this->stateAbbreviation = $this->setField($obj, "state_abbreviation");
        $this->state = $this->setField($obj, "state");
        $this->latitude = $this->setField($obj, "latitude");
        $this->longitude = $this->setField($obj, "longitude");
        $this->precision = $this->setField($obj, "precision");
        $this->alternateCounties = $this->setField($obj, "alternate_counties", array());

        $this->alternateCounties = $this->convertToAlternateCountyObjects();
    }

    private function setField($obj, $key, $typeIfKeyNotFound = null) {
        if (isset($obj[$key]))
            return $obj[$key];
        else
            return $typeIfKeyNotFound;
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