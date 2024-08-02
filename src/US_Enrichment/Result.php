<?php

namespace SmartyStreets\PhpSdk\US_Enrichment;

require_once(dirname(dirname(__FILE__)) . '/ArrayUtil.php');
require_once('FinancialAttributes.php');
require_once('PrincipalAttributes.php');
require_once('GeoReferenceAttributes.php');
require_once('SecondaryAttributes.php');
require_once('SecondaryCountAttributes.php');
use SmartyStreets\PhpSdk\ArrayUtil;


class Result  {

    //region [ Fields ]

    public $smartyKey,
        $dataSetName,
        $dataSubsetName,
        $attributes,
        $rootAddress,
        $aliases,
        $secondaries,
        $count;

    //endregion

    public function __construct($obj = null) {
        if ($obj == null)
            return;
        $this->smartyKey = ArrayUtil::setField($obj, 'smarty_key');
        if (array_key_exists('data_set_name', $obj)) {
            $this->dataSetName = ArrayUtil::setField($obj, 'data_set_name');
            $this->dataSubsetName = ArrayUtil::setField($obj, 'data_subset_name');
            $this->attributes = $this->createAttributes($this->dataSetName, $this->dataSubsetName, ArrayUtil::setField($obj, 'attributes'));
        }
        else {
            if (array_key_exists('secondaries', $obj)) {
                $this->dataSetName = 'secondary';
                $this->dataSubsetName = null;
                $this->createSecondaryData($obj, $this->dataSubsetName);
            }
            else if (array_key_exists('count', $obj)) {
                $this->dataSetName = 'secondary';
                $this->dataSubsetName = 'count';
                $this->createSecondaryData($obj, $this->dataSubsetName);
            }
        }
    }

    private function createAttributes($dataSetName, $dataSubsetName, $attributesObj){
        if ($dataSetName == 'property'){
            if ($dataSubsetName == 'financial'){
                return new FinancialAttributes($attributesObj);
            }
            if ($dataSubsetName == 'principal'){
                return new PrincipalAttributes($attributesObj);
            }
        }
        if ($dataSetName == 'geo-reference'){
            return new GeoReferenceAttributes($attributesObj);
        }
    }

    private function createSecondaryData($responseObj, $dataSubsetName) {
        if ($dataSubsetName = 'count'){
            $attributes = new SecondaryCountAttributes($responseObj);
            $this->count = $attributes->count;
        }
        $attributes = new SecondaryAttributes($responseObj);
        $this->rootAddress = $attributes->rootAddress;
        $this->aliases[] = $attributes->aliases;
        $this->secondaries[] = $attributes->secondaries;
    }
}