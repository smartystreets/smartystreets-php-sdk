<?php

namespace SmartyStreets\PhpSdk\International_Street;

/**
 * In addition to holding all of the input data for this lookup, this class also<br>
 *     will contain the result of the lookup after it comes back from the API.
 *     <p><b>Note: </b><i>Lookups must have certain required fields set with non-blank values. <br>
 *         These can be found at the URL below.</i></p>
 *     @see "https://smartystreets.com/docs/cloud/international-street-api#http-input-fields"
 */
class Lookup {
    //region [ Fields ]
    private $result,
            $inputId,
            $country,
            $geocode,
            $language,
            $freeform,
            $address1,
            $address2,
            $address3,
            $address4,
            $organization,
            $locality,
            $administrativeArea,
            $postalCode;

    //endregion

    //region [ Constructors ]

    public function __construct() {
        $this->result = array();
    }

    public function setFreeformInput($freeform, $country) {
        $this->freeform = $freeform;
        $this->country = $country;
    }

    public function setPostalCodeInput($address1, $postalCode, $country) {
        $this->address1 = $address1;
        $this->postalCode = $postalCode;
        $this->country = $country;
    }

    public function setLocalityInput($address1, $locality, $administrativeArea, $country) {
        $this->address1 = $address1;
        $this->locality = $locality;
        $this->administrativeArea = $administrativeArea;
        $this->country = $country;
    }

    //endregion

    //region [ Query Methods ]

    public function missingCountry() {
        return $this->fieldIsMissing($this->getCountry());
    }

    public function hasFreeform() {
        return $this->fieldIsSet($this->getFreeform());
    }

    public function missingAddress1() {
        return $this->fieldIsMissing($this->getAddress1());
    }

    public function hasPostalCode() {
        return $this->fieldIsSet($this->getPostalCode());
    }

    public function missingLocalityOrAdministrativeArea() {
        return $this->fieldIsMissing($this->getLocality()) || $this->fieldIsMissing($this->getAdministrativeArea());
    }

    private function fieldIsSet($field) {
        return !$this->fieldIsMissing($field);
    }

    private function fieldIsMissing($field) {
        return $field == null || strlen(trim($field)) == 0;
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

    public function getGeocode() {
        return $this->geocode;
    }

    public function getLanguage() {
        return $this->language;
    }

    public function getFreeform() {
        return $this->freeform;
    }

    public function getAddress1() {
        return $this->address1;
    }

    public function getAddress2() {
        return $this->address2;
    }

    public function getAddress3() {
        return $this->address3;
    }

    public function getAddress4() {
        return $this->address4;
    }

    public function getOrganization() {
        return $this->organization;
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

    /**
     * @param $geocode bool Disabled by default. Set to <b>true</b> to enable.
     */
    public function setGeocode($geocode) {
        $this->geocode = $geocode;
    }

    /**
     * When not set, the output language will match the language of the input values. When set to <b>NATIVE</b> the<br>
     *     results will always be in the language of the output country. When set to <b>LATIN</b> the results<br>
     *     will always be provided using a Latin character set.
     *
     * @param $language LanguageMode
     */
    public function setLanguage(LanguageMode $language) {
        $this->language = $language;
    }

    /**
     * @param $freeform String The entire address except the country, which should be input using setCountry().
     */
    public function setFreeform($freeform) {
        $this->freeform = $freeform;
    }

    public function setAddress1($address1) {
        $this->address1 = $address1;
    }

    public function setAddress2($address2) {
        $this->address2 = $address2;
    }

    public function setAddress3($address3) {
        $this->address3 = $address3;
    }

    public function setAddress4($address4) {
        $this->address4 = $address4;
    }

    public function setOrganization($organization) {
        $this->organization = $organization;
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
}