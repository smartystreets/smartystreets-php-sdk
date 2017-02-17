<?php

namespace SmartyStreets\US_ZipCode;

require_once(dirname(dirname(__FILE__)) . '/ArrayUtil.php');
use SmartyStreets\ArrayUtil;

class City {
    //region [ Fields ]

    private $city,
            $mailableCity,
            $stateAbbreviation,
            $state;

    //endregion

    //region [ Constructors ]

    public function __construct($obj = null) {
        if ($obj == null)
            return;

        $this->city = ArrayUtil::setField($obj, "city");
        $this->mailableCity = (ArrayUtil::setField($obj, "mailable_city", false));
        $this->stateAbbreviation = ArrayUtil::setField($obj, "state_abbreviation");
        $this->state = ArrayUtil::setField($obj, "state");
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