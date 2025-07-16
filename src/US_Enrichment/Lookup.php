<?php

namespace SmartyStreets\PhpSdk\US_Enrichment;

class Lookup {

    //region [ Fields ]

    private $smartyKey,
        $freeform,
        $street,
        $city,
        $state,
        $zipcode,
        $dataSetName,
        $dataSubsetName,
        $include,
        $exclude,
        $etag,
        $response,
        $customParamArray;

    //endregion

    public function __construct($smartyKey = null, $dataSetName = null, $dataSubsetName = null, $freeform = null, $street = null, $city = null, $state = null,
    $zipcode = null, $include = null, $exclude = null, $etag = null) {
        $this->smartyKey = $smartyKey;
        $this->dataSetName = $dataSetName;
        $this->dataSubsetName = $dataSubsetName;
        $this->freeform = $freeform;
        $this->street = $street;
        $this->city = $city;
        $this->state = $state;
        $this->zipcode = $zipcode;
        $this->include = array();
        $this->exclude = array();
        $this->etag = $etag;
        $this->response = null;
        $this->customParamArray = array();
    }

    public function getSmartyKey(){
        return $this->smartyKey;
    }

    public function getFreeform(){
        return $this->freeform;
    }
    
    public function getStreet(){
        return $this->street;
    }

    public function getCity(){
        return $this->city;
    }

    public function getState(){
        return $this->state;
    }

    public function getZipcode(){
        return $this->zipcode;
    }

    public function getDataSetName(){
        return $this->dataSetName;
    }

    public function getDataSubsetName(){
        return $this->dataSubsetName;
    }
    
    public function getIncludeArray() {
        return $this->include;
    }

    public function getExcludeArray() {
        return $this->exclude;
    }

    public function getETag() {
        return $this->etag;
    }

    public function getResponse() {
        return $this->response;
    }

    public function getCustomParamArray() {
        return $this->customParamArray;
    }

    public function setSmartyKey($smartyKey) {
        $this->smartyKey = $smartyKey;
    }

    public function setDataSetName($dataSetName) {
        $this->dataSetName = $dataSetName;
    }

    public function setDataSubsetName($dataSubsetName) {
        $this->dataSubsetName = $dataSubsetName;
    }

    public function setFreeform($freeform) {
        $this->freeform = $freeform;
    }

    public function setStreet($street){
        $this->street = $street;
    }

    public function setCity($city){
        $this->city = $city;
    }

    public function setState($state){
        $this->state = $state;
    }

    public function setZipcode($zipcode){
        $this->zipcode = $zipcode;
    }

    public function setIncludeArray($include) {
        $this->include = $include;
    }

    public function setExcludeArray($exclude) {
        $this->exclude = $exclude;
    }

    public function setETag($etag) {
        $this->etag = $etag;
    }

    public function setResponse($response){
        $this->response = $response;
    }

    public function addIncludeAttribute($attribute) {
        array_push($this->include, $attribute);
    }

    public function addExcludeAttribute($attribute) {
        array_push($this->exclude, $attribute);
    }

    public function addCustomParameter($parameter, $value) {
        $this->customParamArray[$parameter] = $value;
    }
}