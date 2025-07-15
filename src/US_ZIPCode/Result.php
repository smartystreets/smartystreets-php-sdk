<?php

namespace SmartyStreets\PhpSdk\US_ZIPCode;

require_once(__DIR__ . '/../ArrayUtil.php');
require_once(__DIR__ . '/City.php');
require_once(__DIR__ . '/ZIPCode.php');
use SmartyStreets\PhpSdk\ArrayUtil;

/**
 * @see "https://smartystreets.com/docs/cloud/us-zipcode-api#root"
 */
class Result {
    private $status,
            $reason,
            $inputId,
            $inputIndex,
            $cities,
            $zipCodes;

    public function __construct($obj = null) {
        if ($obj == null)
            return;

        $this->status = ArrayUtil::setField($obj, "status");
        $this->reason = ArrayUtil::setField($obj, "reason");
        $this->inputIndex = $obj["input_index"];
        $this->inputId = ArrayUtil::setField($obj, "input_id");
        $this->cities = ArrayUtil::setField($obj, "city_states", array());
        $this->zipCodes = ArrayUtil::setField($obj, "zipcodes", array());

        $this->cities = $this->convertToCityObjects();
        $this->zipCodes = $this->convertToZIPCodeObjects();
    }

    private function convertToCityObjects() {
        $cityObjects = array();

        foreach ($this->cities as $city)
            $cityObjects[] = new City($city);

        return $cityObjects;
    }

    private function convertToZIPCodeObjects() {
        $zipCodeObjects = array();

        foreach ($this->zipCodes as $zipCode)
            $zipCodeObjects[] = new ZIPCode($zipCode);

        return $zipCodeObjects;
    }

    public function isValid() {
        return ($this->status == null && $this->reason == null);
    }

    //region [ Getters ]

    public function getCityAtIndex($index) {
        if (!is_array($this->cities) || !isset($this->cities[$index])) {
            return new City([]);
        }
        return $this->cities[$index];
    }

    public function getZIPCodeAtIndex($index) {
        if (!is_array($this->zipCodes) || !isset($this->zipCodes[$index])) {
            return new ZIPCode([]);
        }
        return $this->zipCodes[$index];
    }

    /**
     *
     * @return Returns a status if there was no match
     */
    public function getStatus() {
        return $this->status;
    }

    public function getReason() {
        return $this->reason;
    }

    public function getInputIndex() {
        return $this->inputIndex;
    }

    public function getInputId() {
        return $this->inputId;
    }

    public function getCities() {
        return is_array($this->cities) ? $this->cities : [];
    }

    public function getZIPCodes() {
        return is_array($this->zipCodes) ? $this->zipCodes : [];
    }

    //endregion

    //region [ Setters ]

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setReason($reason) {
        $this->reason = $reason;
    }

    //endregion
}