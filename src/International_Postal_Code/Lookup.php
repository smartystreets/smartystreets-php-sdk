<?php

namespace SmartyStreets\PhpSdk\International_Postal_Code;

/**
 * In addition to holding all of the input data for this lookup, this class also<br>
 *     will contain the result of the lookup after it comes back from the API.
 *     <p><b>Note: </b><i>Lookups must have certain required fields set with non-blank values. <br>
 *         These can be found at the URL below.</i></p>
 *     @see "https://smartystreets.com/docs/cloud/international-postal-code-api"
 */
class Lookup {
    //region [ Fields ]
    private $result,
            $inputId,
            $country,
            $locality,
            $administrativeArea,
            $postalCode,
            $customParamArray;

    //endregion

    //region [ Constructors ]

    public function __construct() {
        $this->result = array();
        $this->customParamArray = array();
    }

    //endregion

    //region [ Getters ]

    public function getResult() {
        return $this->result;
    }

    public function getInputId() {
        return $this->inputId;
    }

    public function getCountry() {
        return $this->country;
    }

    public function getLocality() {
        return $this->locality;
    }

    public function getAdministrativeArea() {
        return $this->administrativeArea;
    }

    public function getPostalCode() {
        return $this->postalCode;
    }

    public function getCustomParamArray() {
        return $this->customParamArray;
    }

    //endregion

    //region [ Setters ]

    public function setResult($result) {
        $this->result = $result;
    }

    public function setInputId($inputId) {
        $this->inputId = $inputId;
    }

    public function setCountry($country) {
        $this->country = $country;
    }

    public function setLocality($locality) {
        $this->locality = $locality;
    }

    public function setAdministrativeArea($administrativeArea) {
        $this->administrativeArea = $administrativeArea;
    }

    public function setPostalCode($postalCode) {
        $this->postalCode = $postalCode;
    }

    //endregion

    public function addCustomParameter($parameter, $value) {
        $this->customParamArray[$parameter] = $value;
    }
}

