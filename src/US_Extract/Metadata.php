<?php

namespace SmartyStreets\PhpSdk\US_Extract;

require_once(__DIR__ . '/../ArrayUtil.php');
use SmartyStreets\PhpSdk\ArrayUtil;

/**
 * @see <a href="https://smartystreets.com/docs/cloud/us-extract-api#http-response-status">SmartyStreets US Extract API docs</a>
 */
class Metadata {
    private $lines,
            $unicode,
            $addressCount,
            $verifiedCount,
            $bytes,
            $characterCount;

    public function __construct($obj = null) {
        if ($obj == null)
            return;

        $this->lines = ArrayUtil::getField($obj, 'lines');
        $this->unicode = ArrayUtil::getField($obj, 'unicode');
        $this->addressCount = ArrayUtil::getField($obj, 'address_count');
        $this->verifiedCount = ArrayUtil::getField($obj, 'verified_count');
        $this->bytes = ArrayUtil::getField($obj, 'bytes');
        $this->characterCount = ArrayUtil::getField($obj, 'character_count');

    }

    //region [ Getters ]

    public function getLines() {
        return $this->lines;
    }

    public function isUnicode() {
        return $this->unicode;
    }

    public function getAddressCount() {
        return $this->addressCount;
    }

    public function getVerifiedCount() {
        return $this->verifiedCount;
    }

    public function getBytes() {
        return $this->bytes;
    }

    public function getCharacterCount() {
        return $this->characterCount;
    }

    //endregion
}