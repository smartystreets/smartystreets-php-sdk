<?php

namespace SmartyStreets\PhpSdk\US_Extract;

require_once(__DIR__ . '/../ArrayUtil.php');
require_once(__DIR__ . '/Result.php');

/**
 * In addition to holding all of the input data for this lookup, this class also<br>
 *     will contain the result of the lookup after it comes back from the API.
 *     @see "https://smartystreets.com/docs/cloud/us-extract-api#http-request-input-fields"
 */
class Lookup {
    const STRICT = "strict";
    const INVALID = "invalid";
    const ENHANCED = "enhanced";

    private $result,
            $html,
            $aggressive,
            $addressesHaveLineBreaks,
            $addressPerLine,
            $matchStrategy,
            $text,
            $customParamArray;

    /**
     * @param $text string The text that is to have addresses extracted out of it for verification
     */
    public function __construct($text = null) {
        $this->result = new Result();
        $this->aggressive = false;
        $this->addressesHaveLineBreaks = true;
        $this->addressPerLine = 0;
        $this->matchStrategy = "";
        $this->text = $text;
        $this->customParamArray = array();
    }

    //region [ Getters ]

    public function getResult() {
        return $this->result;
    }

    public function isHtml() {
        return $this->html;
    }

    public function isAggressive() {
        return $this->aggressive;
    }

    public function addressesHaveLineBreaks() {
        return $this->addressesHaveLineBreaks;
    }

    public function getAddressesPerLine() {
        return $this->addressPerLine;
    }

    public function getMatchStrategy() {
        return $this->matchStrategy;
    }

    public function getText() {
        return $this->text;
    }

    public function getCustomParamArray() {
        return $this->customParamArray;
    }

    //endregion

    //region [ Setters ]

    public function setResult(Result $result) {
        $this->result = $result;
    }

    public function specifyHtmlInput($html) {
        $this->html = $html;
    }

    public function setAggressive($aggressive) {
        $this->aggressive = $aggressive;
    }

    public function setAddressesHaveLineBreaks($addressesHaveLineBreaks) {
        $this->addressesHaveLineBreaks = $addressesHaveLineBreaks;
    }

    public function setAddressesPerLine($addressPerLine) {
        $this->addressPerLine = $addressPerLine;
    }

    public function setMatchStrategy($matchStrategy) {
        $this->matchStrategy = $matchStrategy;
    }

    public function setText($text) {
        $this->text = $text;
    }

    //endregion

    public function addCustomParameter($parameter, $value) {
        $this->customParamArray[$parameter] = $value;
    }
}