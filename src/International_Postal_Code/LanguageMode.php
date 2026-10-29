<?php

namespace SmartyStreets\PhpSdk\International_Postal_Code;

require_once(__DIR__ . '/../Exceptions/UnprocessableEntityException.php');
use SmartyStreets\PhpSdk\Exceptions\UnprocessableEntityException;

/**
 * When not set, results are returned using the Latin character set. When set to <b>Native</b> (JPN only) the<br>
 *     results are returned in the native character set for that country. When set to <b>Latin</b> the results<br>
 *     will always be provided using the Latin character set with accents and other diacritics removed.
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
