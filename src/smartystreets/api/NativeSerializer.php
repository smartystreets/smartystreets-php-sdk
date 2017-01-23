<?php

namespace smartystreets;

use smartystreets\api\Serializer;

include_once('Serializer.php');

class NativeSerializer implements Serializer {
    public function __construct(){

    }

    public function serialize($obj) {
        return json_encode($obj);
    }

    public function deserialize($payload) {
        return json_decode($payload, true);
    }

    public function __toString() {
        return "";
    }
}