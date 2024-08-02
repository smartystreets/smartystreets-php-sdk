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
        $this->smartyKey = ArrayUtil::setField($obj, "smarty_key");
        $this->primaryNumber = ArrayUtil::setField($obj, "primary_number");
        $this->streetPredirection = ArrayUtil::setField($obj, "street_predirection");
        $this->streetName = ArrayUtil::setField($obj, "street_name");
        $this->streetSuffix = ArrayUtil::setField($obj, "street_suffix");
        $this->streetPostdirection = ArrayUtil::setField($obj, "street_postdirection");
        $this->cityName = ArrayUtil::setField($obj, "city_name");
        $this->stateAbbreviation = ArrayUtil::setField($obj, "state_abbreviation");
        $this->zipcode = ArrayUtil::setField($obj, "zipcode");
        $this->plus4Code = ArrayUtil::setField($obj, "plus4_code");
    }
}