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
        try {
            $result = json_decode($payload, true);
            if ($result === null && json_last_error() !== JSON_ERROR_NONE) {
                throw new \SmartyStreets\PhpSdk\Exceptions\SmartyException('Malformed JSON: ' . json_last_error_msg());
            }
            return $result;
        } catch (\Throwable $e) {
            throw new \SmartyStreets\PhpSdk\Exceptions\SmartyException('Malformed JSON in API response', 0, $e);
        }
    }
}