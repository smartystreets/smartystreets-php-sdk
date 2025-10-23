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
        $this->primaryNumber = new MatchInfo(ArrayUtil::getField($obj, 'primary_number', array()));
        $this->streetPredirection = new MatchInfo(ArrayUtil::getField($obj, 'street_predirection', array()));
        $this->streetName = new MatchInfo(ArrayUtil::getField($obj, 'street_name', array()));
        $this->streetPostdirection = new MatchInfo(ArrayUtil::getField($obj, 'street_postdirection', array()));
        $this->streetSuffix = new MatchInfo(ArrayUtil::getField($obj, 'street_suffix', array()));
        $this->secondaryNumber = new MatchInfo(ArrayUtil::getField($obj, 'secondary_number', array()));
        $this->secondaryDesignator = new MatchInfo(ArrayUtil::getField($obj, 'secondary_designator', array()));
        $this->extraSecondaryNumber = new MatchInfo(ArrayUtil::getField($obj, 'extra_secondary_number', array()));
        $this->extraSecondaryDesignator = new MatchInfo(ArrayUtil::getField($obj, 'extra_secondary_designator', array()));
        $this->cityName = new MatchInfo(ArrayUtil::getField($obj, 'city_name', array()));
        $this->state_abbreviation = new MatchInfo(ArrayUtil::getField($obj, 'state_abbreviation', array()));
        $this->zipcode = new MatchInfo(ArrayUtil::getField($obj, 'zipcode', array()));
        $this->plus4Code = new MatchInfo(ArrayUtil::getField($obj, 'plus4_code', array()));
        $this->urbanization = new MatchInfo(ArrayUtil::getField($obj, 'urbanization', array()));
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