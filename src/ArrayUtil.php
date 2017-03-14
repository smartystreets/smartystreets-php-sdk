<?php

namespace SmartyStreets\PhpSdk;

class ArrayUtil {

    /**
     * Sets field with value from the key in an array
     */
    public static function setField($obj, $key, $typeIfKeyNotFound = null) {
        if (isset($obj[$key]))
            return $obj[$key];
        else
            return $typeIfKeyNotFound;
    }

    /**
     * Returns true is a string ends with a certain character, else returns false
     */
    public static function endsWith($haystack, $needle) {
        // search forward starting from end minus needle length characters
        return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
    }
}