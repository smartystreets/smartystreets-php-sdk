<?php

namespace smartystreets\api\us_zipcode;


class City {
    //region [ Fields ]

    private $city,
            $mailableCity,
            $stateAbbreviation,
            $state;

    //endregion

    //region [ Constructors ]

    public function __construct() {
        $argv = func_get_args();
        $i = func_num_args();
        if (method_exists($this, $f='__construct'.$i)) {
            call_user_func_array(array($this, $f), $argv);
        }
    }

    public function __construct1($obj) {
        $this->city = $obj["city"];
        $this->mailableCity = ($obj["mailable_city"]) ? true : false;
        $this->stateAbbreviation = $obj["state_abbreviation"];
        $this->state = $obj["state"];
    }

    //endregion

    //region [ Getters ]

    public function getCity() {
        return $this->city;
    }

    public function getMailableCity() {
        return $this->mailableCity;
    }

    public function getStateAbbreviation() {
        return $this->stateAbbreviation;
    }

    public function getState() {
        return $this->state;
    }

    //endregion
}