<?php

namespace SmartyStreets\PhpSdk;

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
}