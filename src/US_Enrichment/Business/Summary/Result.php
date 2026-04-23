<?php

namespace SmartyStreets\PhpSdk\US_Enrichment\Business\Summary;

require_once(__DIR__ . '/../../../ArrayUtil.php');
require_once(__DIR__ . '/BusinessEntry.php');

use SmartyStreets\PhpSdk\ArrayUtil;

class Result {
    public ?string $smartyKey = null;
    public ?string $dataSetName = null;
    /** @var BusinessEntry[] */
    public array $businesses = [];

    public function __construct(?array $obj = null) {
        if ($obj === null) {
            return;
        }
        $this->smartyKey = ArrayUtil::getField($obj, 'smarty_key');
        $this->dataSetName = ArrayUtil::getField($obj, 'data_set_name');
        $businesses = ArrayUtil::getField($obj, 'businesses');
        if (is_array($businesses)) {
            foreach ($businesses as $entry) {
                $this->businesses[] = new BusinessEntry($entry);
            }
        }
    }
}
