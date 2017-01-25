<?php

namespace mocks;

require_once(dirname(dirname(dirname(__FILE__))) . '/src/smartystreets/api/Serializer.php');
use smartystreets\api\Serializer;

class MockSerializer implements Serializer {
    private $bytes;

    public function __construct($bytes) {
        $this->bytes = $bytes;
    }

    public function serialize($obj) {
        return $this->bytes;
    }

    public function deserialize($payload) {
        return null;
    }

}