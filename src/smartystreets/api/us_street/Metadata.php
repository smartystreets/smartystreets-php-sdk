<?php


namespace smartystreets\api\us_street;


class Metadata {
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
            $obeysDst;

    public function __construct($obj) {
        $this->recordType = $obj['record_type'];
        $this->zipType = $obj['zip_type'];
        $this->countyFips = $obj['county_fips'];
        $this->countyName = $obj['county_name'];
        $this->carrierRoute = $obj['carrier_route'];
        $this->congressionalDistrict = $obj['congressional_district'];
        $this->buildingDefaultIndicator = $obj['building_default_indicator'];
        $this->rdi = $obj['rdi'];
        $this->elotSequence = $obj['elot_sequence'];
        $this->elotSort = $obj['elot_sort'];
        $this->latitude = $obj['latitude'];
        $this->longitude = $obj['longitude'];
        $this->precision = $obj['precision'];
        $this->timeZone = $obj['time_zone'];
        $this->utcOffset = $obj['utc_offset'];
        $this->obeysDst = $obj['dst'];
    }

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

    //endregion
}