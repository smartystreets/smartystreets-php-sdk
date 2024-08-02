<?php
namespace SmartyStreets\PhpSdk\US_Enrichment;

use SmartyStreets\PhpSdk\ArrayUtil;

class SecondaryCountAttributes {

    //region [ Fields ]

    public $count;

    //endregion

    public function __construct($obj = null) {
        if ($obj == null)
            return;
            $this->count = ArrayUtil::setField($obj, "count");
    }
}