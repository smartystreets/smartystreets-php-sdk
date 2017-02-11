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
        $this->recordType = $this->setField($obj, 'record_type');
        $this->zipType = $this->setField($obj, 'zip_type');
        $this->countyFips = $this->setField($obj, 'county_fips');
        $this->countyName = $this->setField($obj, 'county_name');
        $this->carrierRoute = $this->setField($obj, 'carrier_route');
        $this->congressionalDistrict = $this->setField($obj, 'congressional_district');
        $this->buildingDefaultIndicator = $this->setField($obj, 'building_default_indicator');
        $this->rdi = $this->setField($obj, 'rdi');
        $this->elotSequence = $this->setField($obj, 'elot_sequence');
        $this->elotSort = $this->setField($obj, 'elot_sort');
        $this->latitude = $this->setField($obj, 'latitude');
        $this->longitude = $this->setField($obj, 'longitude');
        $this->precision = $this->setField($obj, 'precision');
        $this->timeZone = $this->setField($obj, 'time_zone');
        $this->utcOffset = $this->setField($obj, 'utc_offset');
        $this->obeysDst = $this->setField($obj, 'dst');
    }

    private function setField($obj, $key, $typeIfKeyNotFound = null) {
        if (isset($obj[$key]))
            return $obj[$key];
        else
            return $typeIfKeyNotFound;
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