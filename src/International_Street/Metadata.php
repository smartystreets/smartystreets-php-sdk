<?php

namespace SmartyStreets\PhpSdk\International_Street;

require_once(__DIR__ . '/../ArrayUtil.php');
use SmartyStreets\PhpSdk\ArrayUtil;

/**
 * @see "https://smartystreets.com/docs/cloud/international-street-api#metadata"
 */
class Metadata {
    private $latitude,
            $longitude,
            $geocodePrecision,
            $maxGeocodePrecision,
            $addressFormat,
            $occupantUse;

    public function __construct($obj = null) {
        if ($obj == null)
            return;

        $this->latitude = ArrayUtil::getField($obj,'latitude');
        $this->longitude = ArrayUtil::getField($obj,'longitude');
        $this->geocodePrecision = ArrayUtil::getField($obj,'geocode_precision');
        $this->maxGeocodePrecision = ArrayUtil::getField($obj,'max_geocode_precision');
        $this->addressFormat = ArrayUtil::getField($obj,'address_format');
        $this->occupantUse = ArrayUtil::getField($obj,'occupant_use');
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

    public function getOccupantUse() {
        return $this->occupantUse;
    }

    //endregion
}
