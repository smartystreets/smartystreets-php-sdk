<?php

class Lookup {

    //region [ Fields ]

    private $smartyKey,
        $dataSetName,
        $dataSubsetName,
        $response;

    //endregion

    public function __construct($smartyKey, $dataSetName, $dataSubsetName) {
        $this->smartyKey = $smartyKey
        $this->dataSetName = $dataSetName;
        $this->dataSubsetName = $dataSubsetName;
        $this->response = null;

    }

    public function getSmartyKey(){
        return $this->smartyKey;
    }

    public function getDataSetName(){
        return $this->dataSetName;
    }

    public function getDataSubsetName(){
        return $this->dataSubsetName;
    }

    public function getResponse() {
        return $this->response;
    }

    public function setResponse($response){
        $this->response = $response
    }
}