<?php

namespace SmartyStreets\PhpSdk\Tests\Mocks;

require_once(dirname(dirname(dirname(__FILE__))) . '/src/Serializer.php');
use SmartyStreets\PhpSdk\Serializer;

class MockDeserializer implements Serializer {
    private $deserialized,
            $payload;

    public function __construct($deserialized) {
        $this->deserialized = $deserialized;
    }

    public function serialize($obj) {
        return "[]";
    }

    public function deserialize($payload) {
        $this->payload = $payload;
        return $this->deserialized;
    }

    public function getPayload() {
        return $this->payload;
    }
}