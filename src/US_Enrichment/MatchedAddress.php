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
        $this->street = ArrayUtil::setField($obj, "street");
        $this->city = ArrayUtil::setField($obj, "city");
        $this->state = ArrayUtil::setField($obj, "state");
        $this->zipcode = ArrayUtil::setField($obj, "zipcode");
    }
}