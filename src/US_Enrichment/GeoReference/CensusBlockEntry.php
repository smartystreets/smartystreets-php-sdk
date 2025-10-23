<?php

namespace SmartyStreets\PhpSdk\US_Enrichment\GeoReference;
use SmartyStreets\PhpSdk\ArrayUtil;

class CensusBlockEntry {
    //region [ Fields ]

    public $accuracy,
    $geoid;

    //endregion

    public function __construct($obj = null){
        if ($obj == null)
            return;
        $this->accuracy = ArrayUtil::getField($obj, "accuracy");
        $this->geoid = ArrayUtil::getField($obj, "geoid");
    }
}