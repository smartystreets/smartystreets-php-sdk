<?php

namespace SmartyStreets\PhpSdk\International_Street;

require_once(__DIR__ . '/../Exceptions/UnprocessableEntityException.php');
use SmartyStreets\PhpSdk\Exceptions\UnprocessableEntityException;

/**
 * When not set, the output language will match the language of the input values. When set to <b>Native</b> the<br>
 *     results will always be in the language of the output country. When set to <b>Latin</b> the results<br>
 *     will always be provided using a Latin character set.
 */
enum LanguageMode: string {
    case Native = 'native';
    case Latin = 'latin';

    /**
     * Resolves a value (eg. from user input or config) into a LanguageMode, matching 'native'/'latin' regardless of case.
     * @throws UnprocessableEntityException when the value doesn't match 'native' or 'latin', case-insensitively.
     */
    public static function fromValue(string $value): self {
        foreach (self::cases() as $case) {
            if (strcasecmp($case->value, $value) === 0) {
                return $case;
            }
        }
        throw new UnprocessableEntityException(
            "invalid Language value; must be unset, 'native', or 'latin' (case-insensitive)");
    }
}
