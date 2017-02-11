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
        $this->city = $this->setField($obj, "city");
        $this->mailableCity = ($this->setField($obj, "mailable_city", false));
        $this->stateAbbreviation = $this->setField($obj, "state_abbreviation");
        $this->state = $this->setField($obj, "state");
    }

    private function setField($obj, $key, $typeIfKeyNotFound = null) {
        if (isset($obj[$key]))
            return $obj[$key];
        else
            return $typeIfKeyNotFound;
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