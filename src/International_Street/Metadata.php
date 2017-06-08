<?php

namespace SmartyStreets\PhpSdk\International_Street;

require_once(dirname(dirname(__FILE__)) . '/ArrayUtil.php');
use SmartyStreets\PhpSdk\ArrayUtil;

/**
 * @see "https://smartystreets.com/docs/cloud/international-street-api#metadata"
 */
class Metadata {
    private $latitude,
            $longitude,
            $geocodePrecision,
            $maxGeocodePrecision,
            $addressFormat;

    public function __construct($obj = null) {
        if ($obj == null)
            return;

        $this->latitude = ArrayUtil::setField($obj,'latitude');
        $this->longitude = ArrayUtil::setField($obj,'longitude');
        $this->geocodePrecision = ArrayUtil::setField($obj,'geocode_precision');
        $this->maxGeocodePrecision = ArrayUtil::setField($obj,'max_geocode_precision');
        $this->addressFormat = ArrayUtil::setField($obj,'address_format');
    }

    //region [ Getters ]

    public function getLatitude() {
        return $this->latitude;
    }

    public function getLongitude() {
        return $this->longitude;
    }

    public function getGeocodePrecision() {
        return $this->geocodePrecision;
    }

    public function getMaxGeocodePrecision() {
        return $this->maxGeocodePrecision;
    }

    public function getAddressFormat() {
        return $this->addressFormat;
    }

    //endregion
}