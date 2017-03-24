<?php

namespace SmartyStreets\PhpSdk\US_ZIPCode;

require_once('Result.php');

/**
 * In addition to holding all of the input data for this lookup, this class also<br>
 *     will contain the result of the lookup after it comes back from the API.
 *     @see "https://smartystreets.com/docs/cloud/us-zipcode-api#http-request-input-fields"
 */
class Lookup implements \JsonSerializable {
    //region [ Fields ]

    private $result,
            $inputId,
            $city,
            $state,
            $zipcode;

    //endregion

    //region [ Constructors ]

    public function __construct($city = null, $state = null, $zipcode = null) {
        $this->result = new Result();
        $this->city = $city;
        $this->state = $state;
        $this->zipcode = $zipcode;
    }

    public function jsonSerialize()
    {
        return array(
            'input_id' => $this->inputId,
            'city' => $this->city,
            'state' => $this->state,
            'zipcode' => $this->zipcode
        );
    }

    //endregion

    //region [ Getters ]

    public function getResult() {
        return $this->result;
    }

    public function getInputId() {
        return $this->inputId;
    }

    public function getCity() {
        return $this->city;
    }

    public function getState() {
        return $this->state;
    }

    public function getZIPCode() {
        return $this->zipcode;
    }

    //endregion

    //region [ Setters ]

    public function setResult(Result $result) {
        $this->result = $result;
    }

    public function setCity($city) {
        $this->city = $city;
    }

    public function setState($state) {
        $this->state = $state;
    }

    public function setZIPCode($zipcode) {
        $this->zipcode = $zipcode;
    }

    public function setInputId($inputId) {
        $this->inputId = $inputId;
        return $this;
    }
    //endregion
}