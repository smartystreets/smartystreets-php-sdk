<?php

namespace SmartyStreets\PhpSdk\US_Enrichment\GeoReference;
use SmartyStreets\PhpSdk\ArrayUtil;

class CensusCountyDivisionEntry {
    //region [ Fields ]

    public $accuracy,
    $code,
    $name;

    //endregion

    public function __construct($obj = null){
        if ($obj == null)
            return;
        $this->accuracy = ArrayUtil::setField($obj, "accuracy");
        $this->code = ArrayUtil::setField($obj, "code");
        $this->name = ArrayUtil::setField($obj, "name");
    }
}