<?php

namespace SmartyStreets\PhpSdk\US_Enrichment;
use SmartyStreets\PhpSdk\ArrayUtil;

class MatchedAddress {

    //region [ Fields ]

    public $street,
    $city,
    $state,
    $zipcode;

    //endregion

    public function __construct($obj = null) {
        $this->street = ArrayUtil::getField($obj, "street");
        $this->city = ArrayUtil::getField($obj, "city");
        $this->state = ArrayUtil::getField($obj, "state");
        $this->zipcode = ArrayUtil::getField($obj, "zipcode");
    }
}