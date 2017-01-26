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
}