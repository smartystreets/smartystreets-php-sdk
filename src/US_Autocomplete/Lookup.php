<?php

namespace SmartyStreets\PhpSdk\US_Autocomplete;

/**
 * In addition to holding all of the input data for this lookup, this class also<br>
 *     will contain the result of the lookup after it comes back from the API.
 *     @see "https://smartystreets.com/docs/cloud/us-autocomplete-api#http-request-input-fields"
 */
class Lookup {
    //region [ Fields ]

    private $result,
            $prefix,
            $maxSuggestions,
            $cityFilter,
            $stateFilter,
            $prefer,
            $geolocateType;

    //endregion

    public function __construct($prefix = null) {
        $this->result = array();
        $this->prefix = $prefix;
        $this->maxSuggestions = 10;
        $this->cityFilter = array();
        $this->stateFilter = array();
        $this->prefer = array();
        $this->geolocateType = new GeolocateType(GEOLOCATE_TYPE_CITY);
    }

    public function addCityFilter($city) {
        $this->cityFilter[] = $city;
    }

    public function addStateFilter($stateAbbreviation) {
        $this->stateFilter[] = $stateAbbreviation;
    }

    public function addPrefer($cityOrState) {
        $this->prefer[] = $cityOrState;
    }

    //region [ Getters ]

    public function getResult() {
        return $this->result;
    }

    public function getPrefix() {
        return $this->prefix;
    }

    public function getMaxSuggestions() {
        return $this->maxSuggestions;
    }

    public function getCityFilter() {
        return $this->cityFilter;
    }

    public function getStateFilter() {
        return $this->stateFilter;
    }

    public function getPrefer() {
        return $this->prefer;
    }

    public function getGeolocateType() {
        return $this->geolocateType;
    }

    //endregion

    //region [ Setter ]

    public function setResult($result) {
        $this->result = $result;
    }

    public function setPrefix($prefix) {
        $this->prefix = $prefix;
    }

    public function setMaxSuggestions($maxSuggestions) {
        if ($maxSuggestions > 0 && $this->maxSuggestions <= 10)
            $this->maxSuggestions = $maxSuggestions;
        else
            throw new \InvalidArgumentException("Max suggestions must be a positive integer no larger than 10.");
    }

    public function setCityFilter($cityFilter) {
        $this->cityFilter = $cityFilter;
    }

    public function setStateFilter($stateFilter) {
        $this->stateFilter = $stateFilter;
    }

    public function setPrefer($prefer) {
        $this->prefer = $prefer;
    }

    public function setGeolocateType(GeolocateType $geolocateType) {
        $this->geolocateType = $geolocateType;
    }

    //endregion
}