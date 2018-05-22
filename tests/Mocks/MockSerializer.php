<?php

namespace SmartyStreets\PhpSdk\Tests\Mocks;

require_once(dirname(dirname(dirname(__FILE__))) . '/src/Serializer.php');
use SmartyStreets\PhpSdk\Serializer;

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