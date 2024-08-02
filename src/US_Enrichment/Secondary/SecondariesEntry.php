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
        $this->smartyKey = ArrayUtil::setField($obj, "smarty_key");
        $this->secondaryDesignator = ArrayUtil::setField($obj, "secondary_designator");
        $this->secondaryNumber = ArrayUtil::setField($obj, "secondary_number");
        $this->plus4Code = ArrayUtil::setField($obj, "plus4_code");
    }
}