<?php

namespace SmartyStreets\PhpSdk\US_Street;

require_once(dirname(dirname(__FILE__)) . '/ArrayUtil.php');
use SmartyStreets\PhpSdk\ArrayUtil;

/**
 * @see "https://smartystreets.com/docs/cloud/us-street-api#metadata"
 */
class Metadata {
    public function __construct($obj) {
        $this->recordType = ArrayUtil::setField($obj, 'record_type');
        $this->zipType = ArrayUtil::setField($obj, 'zip_type');
        $this->countyFips = ArrayUtil::setField($obj, 'county_fips');
        $this->countyName = ArrayUtil::setField($obj, 'county_name');
        $this->carrierRoute = ArrayUtil::setField($obj, 'carrier_route');
        $this->congressionalDistrict = ArrayUtil::setField($obj, 'congressional_district');
        $this->buildingDefaultIndicator = ArrayUtil::setField($obj, 'building_default_indicator');
        $this->rdi = ArrayUtil::setField($obj, 'rdi');
        $this->elotSequence = ArrayUtil::setField($obj, 'elot_sequence');
        $this->elotSort = ArrayUtil::setField($obj, 'elot_sort');
        $this->latitude = ArrayUtil::setField($obj, 'latitude');
        $this->longitude = ArrayUtil::setField($obj, 'longitude');
        $this->precision = ArrayUtil::setField($obj, 'precision');
        $this->timeZone = ArrayUtil::setField($obj, 'time_zone');
        $this->utcOffset = ArrayUtil::setField($obj, 'utc_offset');
        $this->obeysDst = ArrayUtil::setField($obj, 'dst');
        $this->isEwsMatch = ArrayUtil::setField($obj, 'ews_match');
    }

    private $recordType,
        $zipType,
        $countyFips,
        $countyName,
        $carrierRoute,
        $congressionalDistrict,
        $buildingDefaultIndicator,
        $rdi,
        $elotSequence,
        $elotSort,
        $latitude,
        $longitude,
        $precision,
        $timeZone,
        $utcOffset,
        $obeysDst,
        $isEwsMatch;

    //region [ Getters ]

    public function getRecordType() {
        return $this->recordType;
    }

    public function getZipType() {
        return $this->zipType;
    }

    public function getCountyFips() {
        return $this->countyFips;
    }

    public function getCountyName() {
        return $this->countyName;
    }

    public function getCarrierRoute() {
        return $this->carrierRoute;
    }

    public function getCongressionalDistrict() {
        return $this->congressionalDistrict;
    }

    public function getBuildingDefaultIndicator() {
        return $this->buildingDefaultIndicator;
    }

    public function getRdi() {
        return $this->rdi;
    }

    public function getElotSequence() {
        return $this->elotSequence;
    }

    public function getElotSort() {
        return $this->elotSort;
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

    public function getTimeZone() {
        return $this->timeZone;
    }

    public function getUtcOffset() {
        return $this->utcOffset;
    }

    public function obeysDst() {
        return $this->obeysDst;
    }

    public function isEwsMatch() {
        return $this->isEwsMatch;
    }

    //endregion
}