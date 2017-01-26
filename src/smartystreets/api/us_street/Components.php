<?php


namespace smartystreets\api\us_street;


class Components {
    private $streetPostDirection,
            $deliveryPointCheckDigit,
            $secondaryDesignator,
            $secondaryNumber,
            $zipcode,
            $pmbNumber,
            $stateAbbreviation,
            $extraSecondaryDesignator,
            $urbanization,
            $streetName,
            $cityName,
            $defaultCityName,
            $streetSuffix,
            $primaryNumber,
            $plus4Code,
            $streetPreDirection,
            $pmbDesignator,
            $extraSecondaryNumber,
            $deliveryPoint;

    public function __construct($obj) {
        $this->urbanization = $obj['urbanization'];
        $this->primaryNumber = $obj['primary_number'];
        $this->streetName = $obj['street_name'];
        $this->streetPreDirection = $obj['street_predirection'];
        $this->streetPostDirection = $obj['street_postdirection'];
        $this->streetSuffix = $obj['street_suffix'];
        $this->secondaryNumber = $obj['secondary_number'];
        $this->secondaryDesignator = $obj['secondary_designator'];
        $this->extraSecondaryNumber = $obj['extra_secondary_number'];
        $this->extraSecondaryDesignator = $obj['extra_secondary_designator'];
        $this->pmbDesignator = $obj['pmb_designator'];
        $this->pmbNumber = $obj['pmb_number'];
        $this->cityName = $obj['city_name'];
        $this->defaultCityName = $obj['default_city_name'];
        $this->stateAbbreviation = $obj['state_abbreviation'];
        $this->zipcode = $obj['zipcode'];
        $this->plus4Code = $obj['plus4_code'];
        $this->deliveryPoint = $obj['delivery_point'];
        $this->deliveryPointCheckDigit = $obj['delivery_point_check_digit'];
    }

    //region [ Getters ]

    public function getStreetPostDirection() {
        return $this->streetPostDirection;
    }

    public function getDeliveryPointCheckDigit() {
        return $this->deliveryPointCheckDigit;
    }

    public function getSecondaryDesignator() {
        return $this->secondaryDesignator;
    }

    public function getSecondaryNumber() {
        return $this->secondaryNumber;
    }

    public function getZipcode() {
        return $this->zipcode;
    }

    public function getPmbNumber() {
        return $this->pmbNumber;
    }

    public function getStateAbbreviation() {
        return $this->stateAbbreviation;
    }

    public function getExtraSecondaryDesignator() {
        return $this->extraSecondaryDesignator;
    }

    public function getUrbanization() {
        return $this->urbanization;
    }

    public function getStreetName() {
        return $this->streetName;
    }

    public function getCityName() {
        return $this->cityName;
    }

    public function getDefaultCityName() {
        return $this->defaultCityName;
    }

    public function getStreetSuffix() {
        return $this->streetSuffix;
    }

    public function getPrimaryNumber() {
        return $this->primaryNumber;
    }

    public function getPlus4Code() {
        return $this->plus4Code;
    }

    public function getStreetPreDirection() {
        return $this->streetPreDirection;
    }

    public function getPmbDesignator() {
        return $this->pmbDesignator;
    }

    public function getExtraSecondaryNumber() {
        return $this->extraSecondaryNumber;
    }

    public function getDeliveryPoint() {
        return $this->deliveryPoint;
    }

    //endregion
}