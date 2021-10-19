<?php

namespace SmartyStreets\PhpSdk\International_Autocomplete;

/**
 * In addition to holding all of the input data for this lookup, this class also<br>
 *     will contain the result of the lookup after it comes back from the API.
 *     @see "https://smartystreets.com/docs/cloud/international-address-autocomplete"
 */
class Lookup {
    //region [ Fields ]
    const MAX_RESULTS_DEFAULT = 10;

    private $result,
            $country,
            $search,
            $maxResults,
            $administrativeArea,
            $locality,
            $postalCode;

    //endregion

    /**
     * If you use this constructor, don't forget to set the <b>prefix</b>. It is required.
     *  @param $search string The beginning of an address
     */
    public function __construct($search = null) {
        $this->result = array();
        $this->search = $search;
        $this->maxResults = Lookup::MAX_RESULTS_DEFAULT;
    }

    //region [ Getters ]

    public function getResult() {
        return $this->result;
    }

    public function getResultAtIndex($index) {
        return $this->result[$index];
    }

    public function getCountry() {
        return $this->country;
    }

    public function getSearch() {
        return $this->search;
    }

    public function getMaxResults() {
        return $this->maxResults;
    }

    public function getAdministrativeArea() {
        return $this->administrativeArea;
    }

    public function getLocality() {
        return $this->locality;
    }

    public function getPostalCode() {
        return $this->postalCode;
    }

    //endregion

    //region [ Setter ]

    public function setResult($result) {
        $this->result = $result;
    }

    public function setCountry($country) {
        $this->country = $country;
    }
    public function setSearch($search) {
        $this->search = $search;
    }

    public function setMaxResults($maxResults) {
        if ($maxResults > 0 && $this->maxResults <= 10)
            $this->maxResults = $maxResults;
        else
            throw new \InvalidArgumentException("Max suggestions must be a positive integer no larger than 10.");
    }

    public function setAdministrativeArea($administrativeArea) {
        $this->administrativeArea = $administrativeArea;
    }

    public function setLocality($locality) {
        $this->locality = $locality;
    }

    public function setPostalCode($postalCode) {
        $this->postalCode = $postalCode;
    }

    //endregion
}