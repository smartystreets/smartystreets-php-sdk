<?php

namespace SmartyStreets\PhpSdk\US_Enrichment\Business\Summary;

require_once(__DIR__ . '/../../../ArrayUtil.php');

use SmartyStreets\PhpSdk\ArrayUtil;

class BusinessEntry {
    public ?string $companyName;
    public ?string $businessId;

    public function __construct(?array $obj = null) {
        if ($obj === null) {
            return;
        }
        $this->companyName = ArrayUtil::getField($obj, 'company_name');
        $this->businessId = ArrayUtil::getField($obj, 'business_id');
    }
}
