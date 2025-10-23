<?php

namespace SmartyStreets\PhpSdk\US_Street;

require_once(__DIR__ . '/../ArrayUtil.php');
use SmartyStreets\PhpSdk\ArrayUtil;

/**
 * This class contains the matched address broken down into its<br>
 *     fundamental pieces.
 * @see "https://smartystreets.com/docs/cloud/us-street-api#components"
 */
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
        $this->urbanization = ArrayUtil::getField($obj, 'urbanization');
        $this->primaryNumber = ArrayUtil::getField($obj, 'primary_number');
        $this->streetName = ArrayUtil::getField($obj, 'street_name');
        $this->streetPreDirection = ArrayUtil::getField($obj, 'street_predirection');
        $this->streetPostDirection = ArrayUtil::getField($obj, 'street_postdirection');
        $this->streetSuffix = ArrayUtil::getField($obj, 'street_suffix');
        $this->secondaryNumber = ArrayUtil::getField($obj, 'secondary_number');
        $this->secondaryDesignator = ArrayUtil::getField($obj, 'secondary_designator');
        $this->extraSecondaryNumber = ArrayUtil::getField($obj, 'extra_secondary_number');
        $this->extraSecondaryDesignator = ArrayUtil::getField($obj, 'extra_secondary_designator');
        $this->pmbDesignator = ArrayUtil::getField($obj, 'pmb_designator');
        $this->pmbNumber = ArrayUtil::getField($obj, 'pmb_number');
        $this->cityName = ArrayUtil::getField($obj, 'city_name');
        $this->defaultCityName = ArrayUtil::getField($obj, 'default_city_name');
        $this->stateAbbreviation = ArrayUtil::getField($obj, 'state_abbreviation');
        $this->zipcode = ArrayUtil::getField($obj, 'zipcode');
        $this->plus4Code = ArrayUtil::getField($obj, 'plus4_code');
        $this->deliveryPoint = ArrayUtil::getField($obj, 'delivery_point');
        $this->deliveryPointCheckDigit = ArrayUtil::getField($obj, 'delivery_point_check_digit');
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