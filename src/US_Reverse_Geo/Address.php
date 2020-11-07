<?php

namespace SmartyStreets\PhpSdk\US_Reverse_Geo;

require_once(dirname(dirname(__FILE__)) . '/ArrayUtil.php');
use SmartyStreets\PhpSdk\ArrayUtil;

/**
 * @see "https://smartystreets.com/docs/cloud/us-reverse-geo-api#address"
 */
class Address {
    //region [ Fields ]

    private $street,
            $city,
            $state_abbreviation,
            $zipcode;

    //endregion

    //region [ Constructor ]

    public function __construct($obj = null) {
        if ($obj == null)
            return;

        $this->street = ArrayUtil::setField($obj, 'street');
        $this->city = ArrayUtil::setField($obj, 'city');
        $this->state_abbreviation = ArrayUtil::setField($obj, 'state_abbreviation');
        $this->zipcode = ArrayUtil::setField($obj, 'zipcode');
    }

    //endregion

    //region [ Getters ]

    public function getStreet() {
        return $this->street;
    }

    public function getCity() {
        return $this->city;
    }

    public function getStateAbbreviation() {
        return $this->state_abbreviation;
    }

    public function getZIPCode() {
        return $this->zipcode;
    }

    //endregion
}