<?php

namespace SmartyStreets\PhpSdk\US_Enrichment\Business\Detail;

require_once(__DIR__ . '/../../../ArrayUtil.php');
require_once(__DIR__ . '/Attributes.php');

use SmartyStreets\PhpSdk\ArrayUtil;

class Result {
    public ?string $smartyKey = null;
    public ?string $dataSetName = null;
    public ?string $businessId = null;
    public ?Attributes $attributes = null;

    public function __construct(?array $obj = null) {
        if ($obj === null) {
            return;
        }
        $this->smartyKey = ArrayUtil::getField($obj, 'smarty_key');
        $this->dataSetName = ArrayUtil::getField($obj, 'data_set_name');
        $this->businessId = ArrayUtil::getField($obj, 'business_id');
        $attrs = ArrayUtil::getField($obj, 'attributes');
        if (is_array($attrs)) {
            $this->attributes = new Attributes($attrs);
        }
    }
}
