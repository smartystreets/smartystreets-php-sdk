<?php

namespace SmartyStreets\PhpSdk\US_Enrichment\GeoReference;
use SmartyStreets\PhpSdk\ArrayUtil;

class CoreBasedStatAreaEntry {
    //region [ Fields ]

    public $code,
    $name;

    //endregion

    public function __construct($obj = null){
        if ($obj == null)
            return;
        $this->code = ArrayUtil::getField($obj, "code");
        $this->name = ArrayUtil::getField($obj, "name");
    }
}