<?php

namespace SmartyStreets\PhpSdk;

class HeaderUtil {

    /**
     * Case-insensitively looks up the Etag header in a headers array and returns
     * its value, or null if not present. Handles scalar or array-valued headers.
     */
    public static function extractEtag($headers): ?string {
        if (!is_array($headers)) {
            return null;
        }
        foreach ($headers as $key => $value) {
            if (is_string($key) && strcasecmp($key, 'etag') === 0) {
                return is_array($value) ? ($value[0] ?? null) : $value;
            }
        }
        return null;
    }
}
