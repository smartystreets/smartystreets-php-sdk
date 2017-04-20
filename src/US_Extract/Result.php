<?php

namespace SmartyStreets\PhpSdk\US_Extract;

require_once(dirname(dirname(__FILE__)) . '/ArrayUtil.php');
require_once('Metadata.php');
require_once('Address.php');
use SmartyStreets\PhpSdk\ArrayUtil;

/**
 * @see <a href="https://smartystreets.com/docs/cloud/us-extract-api#http-response-status">SmartyStreets US Extract API docs</a>
 */
class Result {
    private $metadata,
            $addresses;

    public function __construct($obj = null) {
        if ($obj == null)
            return;

        $this->metadata = new Metadata(ArrayUtil::setField($obj, 'meta'));
        $this->addresses = ArrayUtil::setField($obj, 'addresses', array());
        $this->addresses = $this->convertToAddressObjects();
    }

    private function convertToAddressObjects() {
        $addressObjects = array();

        foreach($this->addresses as $address)
            $addressObjects[] = new Address($address);

        return $addressObjects;
    }

    public function getMetadata() {
        return $this->metadata;
    }

    public function getAddresses() {
        return $this->addresses;
    }

    public function getAddress($index) {
        return $this->addresses[$index];
    }
}