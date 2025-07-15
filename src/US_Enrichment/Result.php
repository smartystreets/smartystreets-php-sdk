<?php

namespace SmartyStreets\PhpSdk\US_Enrichment;

require_once(__DIR__ . '/../ArrayUtil.php');
require_once(__DIR__ . '/FinancialAttributes.php');
require_once(__DIR__ . '/PrincipalAttributes.php');
require_once(__DIR__ . '/GeoReferenceAttributes.php');
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
        $count;

    //endregion

    public function __construct($obj = null) {
        if ($obj == null)
            return;
        if (!is_array($obj)) {
            $obj = [];
        }
        $this->smartyKey = ArrayUtil::setField($obj, 'smarty_key');
        if (array_key_exists('matched_address', $obj)) {
            $this->matchedAddress = new MatchedAddress(ArrayUtil::setField($obj, 'matched_address'));
        }
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

    public function getMatchedAddress() {
        if ($this->matchedAddress === null) {
            $this->matchedAddress = new MatchedAddress([]);
        }
        return $this->matchedAddress;
    }

    public function getAttributes() {
        if ($this->attributes === null) {
            $this->attributes = new \stdClass();
        }
        return $this->attributes;
    }

    public function getRootAddress() {
        if ($this->rootAddress === null) {
            $this->rootAddress = new \stdClass();
        }
        return $this->rootAddress;
    }

    public function getAliases() {
        return is_array($this->aliases) ? $this->aliases : [];
    }

    public function getSecondaries() {
        return is_array($this->secondaries) ? $this->secondaries : [];
    }

    public function getCount() {
        return $this->count !== null ? $this->count : 0;
    }
}