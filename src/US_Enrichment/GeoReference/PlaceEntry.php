<?php

namespace SmartyStreets\PhpSdk\US_Enrichment\GeoReference;
use SmartyStreets\PhpSdk\ArrayUtil;

class PlaceEntry {
    //region [ Fields ]

    public $accuracy,
    $code,
    $name,
    $type;

    //endregion

    public function __construct($obj = null){
        if ($obj == null)
            return;
        $this->accuracy = ArrayUtil::getField($obj, "accuracy");
        $this->code = ArrayUtil::getField($obj, "code");
        $this->name = ArrayUtil::getField($obj, "name");
        $this->type = ArrayUtil::getField($obj, "type");
    }
}