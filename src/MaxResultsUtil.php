<?php

namespace SmartyStreets\PhpSdk;

require_once(__DIR__ . '/Exceptions/UnprocessableEntityException.php');
use SmartyStreets\PhpSdk\Exceptions\UnprocessableEntityException;

class MaxResultsUtil {

    /**
     * Shared handling for the max_results input: accepts a whole number (or a string holding one),
     * and returns it as a string only when it is above 0. Returns null when it shouldn't be sent
     * (unset, blank, or 0 and below).
     * @throws UnprocessableEntityException when the value isn't a whole number.
     */
    public static function normalize($value): ?string {
        if ($value === null || (is_string($value) && trim($value) === '')) {
            return null;
        }

        $number = null;
        if (is_int($value)) {
            $number = $value;
        } elseif (is_float($value) && is_finite($value) && $value == floor($value)) {
            $number = (int)$value;
        } elseif (is_string($value) && preg_match('/^\s*[+-]?\d+\s*$/', $value)) {
            $number = (int)trim($value);
        }

        if ($number === null) {
            throw new UnprocessableEntityException("invalid max_results value; must be a whole number");
        }

        return $number > 0 ? strval($number) : null;
    }
}
