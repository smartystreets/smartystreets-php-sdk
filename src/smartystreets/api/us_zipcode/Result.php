<?php

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

    public function __construct1($argv) {
        $this->status = $argv["status"];
        $this->reason = $argv["reason"];
        $this->inputIndex = $argv["input_index"];
        $this->cities = $argv["city_states"];
        $this->zipCodes = $argv["zipcodes"];

        if ($this->cities == null)
            $this->cities = array();

        if ($this->zipCodes == null)
            $this->zipCodes = array();

        $this->cities = $this->convertToCityObjects();
        $this->zipCodes = $this->convertToZipCodeObjects();
    }

    public function convertToCityObjects() {
        return array(); //TODO: implement function
    }

    public function convertToZipCodeObjects() {
        return array(); //TODO: implement function
    }

    public function isValid() {
        return ($this->status == null && $this->reason == null);
    }

    public function getCityAtIndex($index) {
        return $this->cities[$index];
    }

    public function getZipCodeAtIndex($index) {
        return $this->zipCodes[$index];
    }

}