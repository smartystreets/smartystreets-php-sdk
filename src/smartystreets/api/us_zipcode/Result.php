<?php

namespace smartystreets\api\us_zipcode;

class Result {
    private $status,
            $reason,
            $inputIndex,
            $cities,
            $zipCodes;


    public function __construct() {
        $argv = func_get_args();
        $i = func_num_args();
        if (method_exists($this, $f = '__construct' . $i)) {
            call_user_func_array(array($this, $f), $argv);
        }
    }

    public function __construct1($dictionary) {
        $this->status = $dictionary["status"];
        $this->reason = $dictionary["reason"];
        $this->inputIndex = $dictionary["input_index"];
        $this->cities = (isset($dictionary["city_states"]) ? $dictionary["city_states"] : array());
        $this->zipCodes = (isset($dictionary["zipcodes"]) ? $dictionary["zipcodes"] : array());

        $this->cities = $this->convertToCityObjects();
        $this->zipCodes = $this->convertToZipCodeObjects();
    }

    private function convertToCityObjects() {
        $cityObjects = array();

        foreach ($this->cities as $city)
            $cityObjects[] = $city;

        return $cityObjects;
    }

    private function convertToZipCodeObjects() {
        $zipCodeObjects = array();

        foreach ($this->zipCodes as $zipCode)
            $zipCodeObjects[] = $zipCode;

        return $zipCodeObjects;
    }

    public function isValid() {
        return ($this->status == null && $this->reason == null);
    }

    //region [ Getters ]

    public function getCityAtIndex($index) {
        return $this->cities[$index];
    }

    public function getZipCodeAtIndex($index) {
        return $this->zipCodes[$index];
    }

    public function getStatus() {
        return $this->status;
    }

    public function getReason() {
        return $this->reason;
    }

    public function getInputIndex() {
        return $this->inputIndex;
    }

    public function getCities() {
        return $this->cities;
    }

    public function getZipCodes() {
        return $this->zipCodes;
    }

    //endregion

    //region [ Setters ]

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setReason($reason) {
        $this->reason = $reason;
    }

    //endregion
}