<?php

namespace SmartyStreets\PhpSdk\US_Street;

require_once('MatchInfo.php');
require_once(dirname(dirname(__FILE__)) . '/ArrayUtil.php');
use SmartyStreets\PhpSdk\ArrayUtil;

class ComponentAnalysis {
    private $primaryNumber,
            $streetPredirection,
            $streetName,
            $streetPostdirection,
            $streetSuffix,
            $secondaryNumber,
            $secondaryDesignator,
            $extraSecondaryNumber,
            $extraSecondaryDesignator,
            $cityName,
            $state_abbreviation,
            $zipcode,
            $plus4Code,
            $urbanization;

    public function __construct($obj) {
        $this->primaryNumber = $this->initComponent($obj, 'primary_number');
        $this->streetPredirection = $this->initComponent($obj, 'street_predirection');
        $this->streetName = $this->initComponent($obj, 'street_name');
        $this->streetPostdirection = $this->initComponent($obj, 'street_postdirection');
        $this->streetSuffix = $this->initComponent($obj, 'street_suffix');
        $this->secondaryNumber = $this->initComponent($obj, 'secondary_number');
        $this->secondaryDesignator = $this->initComponent($obj, 'secondary_designator');
        $this->extraSecondaryNumber = $this->initComponent($obj, 'extra_secondary_number');
        $this->extraSecondaryDesignator = $this->initComponent($obj, 'extra_secondary_designator');
        $this->cityName = $this->initComponent($obj, 'city_name');
        $this->state_abbreviation = $this->initComponent($obj, 'state_abbreviation');
        $this->zipcode = $this->initComponent($obj, 'zipcode');
        $this->plus4Code = $this->initComponent($obj, 'plus4_code');
        $this->urbanization = $this->initComponent($obj, 'urbanization');
    }

    private function initComponent($obj, $key) {
        if (isset($obj[$key]) && is_array($obj[$key])) {
            return new MatchInfo($obj[$key]);
        }
        return null;
    }

    //region [ Getters ]

    public function getPrimaryNumber() {
        return $this->primaryNumber;
    }

    public function getStreetPredirection() {
        return $this->streetPredirection;
    }

    public function getStreetName() {
        return $this->streetName;
    }

    public function getStreetPostdirection() {
        return $this->streetPostdirection;
    }

    public function getStreetSuffix() {
        return $this->streetSuffix;
    }

    public function getSecondaryNumber() {
        return $this->secondaryNumber;
    }

    public function getSecondaryDesignator() {
        return $this->secondaryDesignator;
    }

    public function getExtraSecondaryNumber() {
        return $this->extraSecondaryNumber;
    }

    public function getExtraSecondaryDesignator() {
        return $this->extraSecondaryDesignator;
    }

    public function getCityName() {
        return $this->cityName;
    }

    public function getStateAbbreviation() {
        return $this->state_abbreviation;
    }

    public function getZipcode() {
        return $this->zipcode;
    }

    public function getPlus4Code() {
        return $this->plus4Code;
    }

    public function getUrbanization() {
        return $this->urbanization;
    }

    //endregion
}