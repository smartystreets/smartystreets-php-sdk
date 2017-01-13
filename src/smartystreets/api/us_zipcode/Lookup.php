<?php

namespace smartystreets\api\us_zipcode;

class Lookup {
    //region [ Fields ]

    private $result,
            $inputId,
            $city,
            $state,
            $zipcode;

    //endregion

    //region [ Constructors ]

    public function __construct() {
        $argv = func_get_args();
        switch (func_num_args()) {
            case 1:
                self::__construct1();
                break;
            case 2:
                self::__construct2($argv[0]);
                break;
            case 3:
                self::__construct3($argv[0], $argv[1]);
                break;
            case 4:
                self::__construct4($argv[0], $argv[1], $argv[2]);
                break;
        }
    }

    public function __construct1() {
        $this->result = new Result();
    }

    public function __construct2($argv1) {
        $this->__construct1();
        $this->zipcode = $argv1;
    }

    public function __construct3($argv1, $argv2) {
        $this->__construct1();
        $this->city = $argv1;
        $this->state = $argv2;
    }

    public function __construct4($argv1, $argv2, $argv3) {
        $this->__construct1();
        $this->city = $argv1;
        $this->state = $argv2;
        $this->zipcode = $argv3;
    }

    //endregion

    //region [ Getters ]

    public function getResult() {
        return $this->result;
    }

    public function getInputId() {
        return $this->inputId;
    }

    public function getCity() {
        return $this->city;
    }

    public function getState() {
        return $this->state;
    }

    public function getZipcode() {
        return $this->zipcode;
    }

    //endregion

    //region [ Setters ]

    public function setResult($result) {
        $this->result = $result;
    }

    public function setCity($city) {
        $this->city = $city;
    }

    public function setState($state) {
        $this->state = $state;
    }

    public function setZipcode($zipcode) {
        $this->zipcode = $zipcode;
    }

    public function setInputId($inputId) {
        $this->inputId = $inputId;
        return $this;
    }
    //endregion
}