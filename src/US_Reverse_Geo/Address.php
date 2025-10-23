<?php

namespace SmartyStreets\PhpSdk\US_Reverse_Geo;

require_once(__DIR__ . '/../ArrayUtil.php');
use SmartyStreets\PhpSdk\ArrayUtil;

/**
 * @see "https://smartystreets.com/docs/cloud/us-reverse-geo-api#address"
 */
class Address {
    //region [ Fields ]

    private $street,
            $city,
            $state_abbreviation,
            $zipcode,
            $source,
            $smarty_key;

    //endregion

    //region [ Constructor ]

    public function __construct($obj = null) {
        if ($obj == null)
            return;

        $this->street = ArrayUtil::getField($obj, 'street');
        $this->city = ArrayUtil::getField($obj, 'city');
        $this->state_abbreviation = ArrayUtil::getField($obj, 'state_abbreviation');
        $this->zipcode = ArrayUtil::getField($obj, 'zipcode');
        $this->source = ArrayUtil::getField($obj, 'source');
        $this->smarty_key = ArrayUtil::getField($obj, 'smarty_key');
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

    public function getSource() {
        return $this->source;
    }

    public function getSmartykey() {
        return $this->smarty_key;
    }

    //endregion
}