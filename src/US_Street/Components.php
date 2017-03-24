<?php

namespace SmartyStreets\PhpSdk\US_Street;

require_once(dirname(dirname(__FILE__)) . '/ArrayUtil.php');
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
        $this->urbanization = ArrayUtil::setField($obj, 'urbanization');
        $this->primaryNumber = ArrayUtil::setField($obj, 'primary_number');
        $this->streetName = ArrayUtil::setField($obj, 'street_name');
        $this->streetPreDirection = ArrayUtil::setField($obj, 'street_predirection');
        $this->streetPostDirection = ArrayUtil::setField($obj, 'street_postdirection');
        $this->streetSuffix = ArrayUtil::setField($obj, 'street_suffix');
        $this->secondaryNumber = ArrayUtil::setField($obj, 'secondary_number');
        $this->secondaryDesignator = ArrayUtil::setField($obj, 'secondary_designator');
        $this->extraSecondaryNumber = ArrayUtil::setField($obj, 'extra_secondary_number');
        $this->extraSecondaryDesignator = ArrayUtil::setField($obj, 'extra_secondary_designator');
        $this->pmbDesignator = ArrayUtil::setField($obj, 'pmb_designator');
        $this->pmbNumber = ArrayUtil::setField($obj, 'pmb_number');
        $this->cityName = ArrayUtil::setField($obj, 'city_name');
        $this->defaultCityName = ArrayUtil::setField($obj, 'default_city_name');
        $this->stateAbbreviation = ArrayUtil::setField($obj, 'state_abbreviation');
        $this->zipcode = ArrayUtil::setField($obj, 'zipcode');
        $this->plus4Code = ArrayUtil::setField($obj, 'plus4_code');
        $this->deliveryPoint = ArrayUtil::setField($obj, 'delivery_point');
        $this->deliveryPointCheckDigit = ArrayUtil::setField($obj, 'delivery_point_check_digit');
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