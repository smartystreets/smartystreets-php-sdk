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
        $result = json_decode($payload, true);
        if ($result === null && json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException('Malformed JSON: ' . json_last_error_msg());
        }
        return $result;
    }
}