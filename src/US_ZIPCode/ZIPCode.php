<?php

namespace SmartyStreets\PhpSdk\US_ZIPCode;

require_once(dirname(dirname(__FILE__)) . '/ArrayUtil.php');
require_once('AlternateCounties.php');
use SmartyStreets\PhpSdk\ArrayUtil;

/**
 * @see "https://smartystreets.com/docs/cloud/us-zipcode-api#zipcodes"
 */
class ZIPCode {
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

    public function __construct($obj = null) {
        if ($obj == null)
            return;

        $this->zipCode = ArrayUtil::setField($obj, "zipcode");
        $this->zipCodeType = ArrayUtil::setField($obj, "zipcode_type");
        $this->defaultCity = ArrayUtil::setField($obj, "default_city");
        $this->countyFips = ArrayUtil::setField($obj, "county_fips");
        $this->countyName = ArrayUtil::setField($obj, "county_name");
        $this->stateAbbreviation = ArrayUtil::setField($obj, "state_abbreviation");
        $this->state = ArrayUtil::setField($obj, "state");
        $this->latitude = ArrayUtil::setField($obj, "latitude");
        $this->longitude = ArrayUtil::setField($obj, "longitude");
        $this->precision = ArrayUtil::setField($obj, "precision");
        $this->alternateCounties = ArrayUtil::setField($obj, "alternate_counties", array());

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

    public function getZIPCode() {
        return $this->zipCode;
    }

    public function getZIPCodeType() {
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