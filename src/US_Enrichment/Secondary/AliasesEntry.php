<?php

namespace SmartyStreets\PhpSdk\US_Enrichment\Secondary;
use SmartyStreets\PhpSdk\ArrayUtil;

class AliasesEntry {
    //region [ Fields ]

    public $smartyKey,
    $primaryNumber,
    $streetPredirection,
    $streetName,
    $streetSuffix,
    $streetPostdirection,
    $cityName,
    $stateAbbreviation,
    $zipcode,
    $plus4Code;

    //endregion

    public function __construct($obj = null){
        if ($obj == null)
            return;
        $this->smartyKey = ArrayUtil::getField($obj, "smarty_key");
        $this->primaryNumber = ArrayUtil::getField($obj, "primary_number");
        $this->streetPredirection = ArrayUtil::getField($obj, "street_predirection");
        $this->streetName = ArrayUtil::getField($obj, "street_name");
        $this->streetSuffix = ArrayUtil::getField($obj, "street_suffix");
        $this->streetPostdirection = ArrayUtil::getField($obj, "street_postdirection");
        $this->cityName = ArrayUtil::getField($obj, "city_name");
        $this->stateAbbreviation = ArrayUtil::getField($obj, "state_abbreviation");
        $this->zipcode = ArrayUtil::getField($obj, "zipcode");
        $this->plus4Code = ArrayUtil::getField($obj, "plus4_code");
    }
}