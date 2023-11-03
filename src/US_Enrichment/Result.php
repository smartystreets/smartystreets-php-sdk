<?php

namespace SmartyStreets\PhpSdk\US_Enrichment;

require_once(dirname(dirname(__FILE__)) . '/ArrayUtil.php');
require_once('FinancialAttributes.php');
use SmartyStreets\PhpSdk\ArrayUtil;

/**
 * docs here
 */
class Result  {

    //region [ Fields ]

    public $smartykey,
        $dataSetName,
        $dataSubsetName,
        $attributes;

    //endregion

    public function __construct($obj = null) {
        if ($obj == null)
            return;
        $this->smartyKey = ArrayUtil::setField($obj, 'smarty_key');
        $this->dataSetName = ArrayUtil::setField($obj, 'data_set_name');
        $this->dataSubsetName = ArrayUtil::setField($obj, 'data_subset_name');
        $this->attributes = createAttributes($dataSetName, $dataSubsetName, ArrayUtil::setField($obj, 'attributes'));
    }

    private function createAttributes($dataSetName, $dataSubsetName, $attributesObj){
        if ($datasetName == 'property'){
            if ($dataSubsetName == 'financial'){
                return new FinancialAttributes($attributesObj);
            }
            if ($dataSubsetName == 'principal'){
                return new PrincipalAttributes($attributesObj);
            }
        }
    }
}