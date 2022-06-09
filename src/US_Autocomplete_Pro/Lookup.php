<?php

namespace SmartyStreets\PhpSdk\US_Autocomplete_Pro;

require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_Autocomplete_Pro/GeolocateType.php');

/**
 * In addition to holding all of the input data for this lookup, this class also<br>
 *     will contain the result of the lookup after it comes back from the API.
 *     @see "https://smartystreets.com/docs/cloud/us-autocomplete-api#http-request-input-fields"
 */
class Lookup {
    //region [ Fields ]
    const MAX_RESULTS_DEFAULT = 10;
    const PREFER_RATIO_DEFAULT = 100;

    private $result,
            $search,
            $maxResults,
            $cityFilter,
            $stateFilter,
            $zipFilter,
            $excludeStates,
            $preferCities,
            $preferStates,
            $preferZIPCodes,
            $preferRatio,
            $preferGeolocation,
            $selected,
            $source;

    //endregion

    /**
     * If you use this constructor, don't forget to set the <b>prefix</b>. It is required.
     *  @param $search string The beginning of an address
     */
    public function __construct($search = null) {
        $this->search = $search;
        $this->maxResults = Lookup::MAX_RESULTS_DEFAULT;
        $this->cityFilter = array();
        $this->stateFilter = array();
        $this->zipFilter = array();
        $this->excludeStates = array();
        $this->preferCities = array();
        $this->preferStates = array();
        $this->preferZIPCodes = array();
        $this->preferRatio = Lookup::PREFER_RATIO_DEFAULT;
        $this->preferGeolocation = new GeolocateType(GEOLOCATE_TYPE_CITY);
    }

    public function addCityFilter($city) {
        $this->cityFilter[] = $city;
    }

    public function addStateFilter($stateAbbreviation) {
        $this->stateFilter[] = $stateAbbreviation;
    }

    public function addZIPFilter($zipcode) {
        $this->preferGeolocation = new GeolocateType(GEOLOCATE_TYPE_NONE);
        $this->zipFilter[] = $zipcode;
    }

    public function addStateExclusion($stateAbbreviation) {
        $this->excludeStates[] = $stateAbbreviation;
    }

    public function addPreferCity($city) {
        $this->preferCities[] = $city;
    }

    public function addPreferState($stateAbbreviation) {
        $this->preferStates[] = $stateAbbreviation;
    }

    public function addPreferZIPCode($zipcode) {
        $this->preferGeolocation = new GeolocateType(GEOLOCATE_TYPE_NONE);
        $this->preferZIPCodes[] = $zipcode;
    }

    //region [ Getters ]

    public function getResult() {
        return $this->result;
    }

    public function getResultAtIndex($index) {
        return $this->result[$index];
    }

    public function getSearch() {
        return $this->search;
    }

    public function getMaxResults() {
        return $this->maxResults;
    }

    public function getCityFilter() {
        return $this->cityFilter;
    }

    public function getStateFilter() {
        return $this->stateFilter;
    }

    public function getZIPFilter() {
        return $this->zipFilter;
    }

    public function getStateExclusions() {
        return $this->excludeStates;
    }

    public function getPreferCities() {
        return $this->preferCities;
    }

    public function getPreferStates() {
        return $this->preferStates;
    }

    public function getPreferZIPCodes() {
        return $this->preferZIPCodes;
    }

    public function getPreferRatio() {
        return $this->preferRatio;
    }

    public function getPreferGeolocation() {
        return $this->preferGeolocation;
    }

    public function getSelected() {
        return $this->selected;
    }

    public function getSource() {
        return $this->source;
    }

    function getMaxResultsStringIfSet() {
        if ($this->maxResults == Lookup::MAX_RESULTS_DEFAULT)
            return null;
        return strval($this->maxResults);
    }

    function getPreferRatioStringIfSet() {
        if ($this->preferRatio == Lookup::PREFER_RATIO_DEFAULT)
            return null;
        return strval($this->preferRatio);
    }
    //endregion

    //region [ Setter ]

    public function setResult($result) {
        $this->result = $result;
    }

    public function setSearch($search) {
        $this->search = $search;
    }

    public function setMaxResults($maxResults) {
        if ($maxResults > 0 && $maxResults <= 10)
            $this->maxResults = $maxResults;
        else
            throw new \InvalidArgumentException("Max suggestions must be a positive integer no larger than 10.");
    }

    public function setCityFilter($cityFilter) {
        $this->cityFilter = $cityFilter;
    }

    public function setStateFilter($stateFilter) {
        $this->stateFilter = $stateFilter;
    }

    public function setZIPFilter($zipFilter) {
        $this->preferGeolocation = new GeolocateType(GEOLOCATE_TYPE_NONE);
        $this->zipFilter = $zipFilter;
    }

    public function setPreferCities($cities) {
        $this->preferCities = $cities;
    }

    public function setPreferStates($stateAbbreviations) {
        $this->preferStates = $stateAbbreviations;
    }

    public function setPreferZIPCodes($zipcodes) {
        $this->preferGeolocation = new GeolocateType(GEOLOCATE_TYPE_NONE);
        $this->preferZIPCodes = $zipcodes;
    }

    public function setPreferRatio($preferRatio) {
        $this->preferRatio = $preferRatio;
    }

    public function setPreferGeolocation(GeolocateType $geolocateType) {
        $this->preferGeolocation = $geolocateType;
    }

    public function setSelected($selected) {
        $this->selected = $selected;
    }

    public function setSource($source) {
        $this->source = $source;
    }

    //endregion
}
