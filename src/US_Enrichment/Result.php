<?php

namespace SmartyStreets\PhpSdk\US_Enrichment;

require_once(__DIR__ . '/../ArrayUtil.php');
require_once(__DIR__ . '/PrincipalAttributes.php');
require_once(__DIR__ . '/GeoReferenceAttributes.php');
require_once(__DIR__ . '/RiskAttributes.php');
require_once(__DIR__ . '/SecondaryAttributes.php');
require_once(__DIR__ . '/SecondaryCountAttributes.php');
require_once(__DIR__ . '/MatchedAddress.php');
use SmartyStreets\PhpSdk\ArrayUtil;


class Result  {

    //region [ Fields ]

    public $smartyKey,
        $dataSetName,
        $dataSubsetName,
        $matchedAddress,
        $attributes,
        $rootAddress,
        $aliases,
        $secondaries,
        $count,
        $etag;

    //endregion

    public function __construct($obj = null) {
        if ($obj == null)
            return;
        $this->smartyKey = ArrayUtil::getField($obj, 'smarty_key');
        if (array_key_exists('matched_address', $obj)) {
            $this->matchedAddress = new MatchedAddress(ArrayUtil::getField($obj, 'matched_address'));
        }
        if (array_key_exists('data_set_name', $obj)) {
            $this->dataSetName = ArrayUtil::getField($obj, 'data_set_name');
            $this->dataSubsetName = ArrayUtil::getField($obj, 'data_subset_name');
            $this->attributes = $this->createAttributes($this->dataSetName, $this->dataSubsetName, ArrayUtil::getField($obj, 'attributes'));
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

    public function setETag($etag) {
        $this->etag = $etag;
    }

    private function createAttributes($dataSetName, $dataSubsetName, $attributesObj){
        if ($dataSetName == 'property') {
            if ($dataSubsetName == 'principal') {
                return new PrincipalAttributes($attributesObj);
            }
        } else if ($dataSetName == 'geo-reference') {
            return new GeoReferenceAttributes($attributesObj);
        } else if ($dataSetName == 'risk') {
            return new RiskAttributes($attributesObj);
        }
    }

    private function createSecondaryData($responseObj, $dataSubsetName) {
        if ($dataSubsetName == 'count'){
            $attributes = new SecondaryCountAttributes($responseObj);
            $this->count = $attributes->count;
        }
        else {
            $attributes = new SecondaryAttributes($responseObj);
            $this->rootAddress = $attributes->rootAddress;
            $this->aliases[] = $attributes->aliases;
            $this->secondaries[] = $attributes->secondaries;
        }
    }
}