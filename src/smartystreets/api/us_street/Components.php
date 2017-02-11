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
        $this->urbanization = $this->setField($obj, 'urbanization');
        $this->primaryNumber = $this->setField($obj, 'primary_number');
        $this->streetName = $this->setField($obj, 'street_name');
        $this->streetPreDirection = $this->setField($obj, 'street_predirection');
        $this->streetPostDirection = $this->setField($obj, 'street_postdirection');
        $this->streetSuffix = $this->setField($obj, 'street_suffix');
        $this->secondaryNumber = $this->setField($obj, 'secondary_number');
        $this->secondaryDesignator = $this->setField($obj, 'secondary_designator');
        $this->extraSecondaryNumber = $this->setField($obj, 'extra_secondary_number');
        $this->extraSecondaryDesignator = $this->setField($obj, 'extra_secondary_designator');
        $this->pmbDesignator = $this->setField($obj, 'pmb_designator');
        $this->pmbNumber = $this->setField($obj, 'pmb_number');
        $this->cityName = $this->setField($obj, 'city_name');
        $this->defaultCityName = $this->setField($obj, 'default_city_name');
        $this->stateAbbreviation = $this->setField($obj, 'state_abbreviation');
        $this->zipcode = $this->setField($obj, 'zipcode');
        $this->plus4Code = $this->setField($obj, 'plus4_code');
        $this->deliveryPoint = $this->setField($obj, 'delivery_point');
        $this->deliveryPointCheckDigit = $this->setField($obj, 'delivery_point_check_digit');
    }

    private function setField($obj, $key, $typeIfKeyNotFound = null) {
        if (isset($obj[$key]))
            return $obj[$key];
        else
            return $typeIfKeyNotFound;
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