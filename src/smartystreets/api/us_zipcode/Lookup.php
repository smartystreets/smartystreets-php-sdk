<?php
namespace smartystreets\api\us_zipcode;

require_once(dirname(dirname(__FILE__)) . '/us_zipcode/Result.php');

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
        $this->result = new Result();

        $argv = func_get_args();
        $i = func_num_args();
        if (method_exists($this, $f='__construct'.$i)) {
            call_user_func_array(array($this, $f), $argv);
        }
    }

    public function __construct1($argv1) {
        $this->zipcode = $argv1;
    }

    public function __construct2($argv1, $argv2) {
        $this->city = $argv1;
        $this->state = $argv2;
    }

    public function __construct3($argv1, $argv2, $argv3) {
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