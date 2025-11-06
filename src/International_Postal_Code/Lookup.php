<?php

namespace SmartyStreets\PhpSdk\International_Postal_Code;

/**
 * In addition to holding all of the input data for this lookup, this class also<br>
 *     will contain the result of the lookup after it comes back from the API.
 *     @see "https://smartystreets.com/docs/cloud/international-postal-code-api"
 */
class Lookup {
    //region [ Fields ]
    private $results,
            $inputId,
            $country,
            $locality,
            $administrativeArea,
            $postalCode,
            $customParamArray;

    //endregion

    //region [ Constructors ]

    public function __construct() {
        $this->results = array();
        $this->customParamArray = array();
    }

    //endregion

    //region [ Getters ]

    public function getResults() {
        return $this->results;
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

    public function setResults($results) {
        $this->results = $results;
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

    /**
     * Populates query parameters from lookup fields.
     * @param array $query Array to populate with query parameters
     */
    public function populateQuery(&$query) {
        $this->populate($query, 'input_id', $this->inputId);
        $this->populate($query, 'country', $this->country);
        $this->populate($query, 'locality', $this->locality);
        $this->populate($query, 'administrative_area', $this->administrativeArea);
        $this->populate($query, 'postal_code', $this->postalCode);
    }

    private function populate(&$query, $key, $value) {
        if ($value != null && strlen(trim($value)) > 0) {
            $query[$key] = $value;
        }
    }

    public function addCustomParameter($parameter, $value) {
        $this->customParamArray[$parameter] = $value;
    }
}

