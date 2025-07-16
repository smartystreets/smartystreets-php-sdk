<?php

namespace SmartyStreets\PhpSdk\US_Enrichment\Secondary;
use SmartyStreets\PhpSdk\ArrayUtil;

class SecondariesEntry {
    //region [ Fields ]

    public $smartyKey,
    $secondaryDesignator,
    $secondaryNumber,
    $plus4Code;

    //endregion

    public function __construct($obj = null){
        if ($obj == null)
            return;
        $this->smartyKey = ArrayUtil::getField($obj, "smarty_key");
        $this->secondaryDesignator = ArrayUtil::getField($obj, "secondary_designator");
        $this->secondaryNumber = ArrayUtil::getField($obj, "secondary_number");
        $this->plus4Code = ArrayUtil::getField($obj, "plus4_code");
    }
}