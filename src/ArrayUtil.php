<?php

namespace SmartyStreets\PhpSdk;

class ArrayUtil {

    public static function setField($obj, $key, $typeIfKeyNotFound = null) {
        if (isset($obj[$key]))
            return $obj[$key];
        else
            return $typeIfKeyNotFound;
    }

}