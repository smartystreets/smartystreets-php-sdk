<?php

namespace SmartyStreets\PhpSdk\International_Autocomplete;

require_once(__DIR__ . '/../Exceptions/UnprocessableEntityException.php');
use SmartyStreets\PhpSdk\Exceptions\UnprocessableEntityException;

/**
 * When not set, the output language will match the default for the country. When set to <b>Native</b> the<br>
 *     results will always be in the language of the output country whenever possible. When set to<br>
 *     <b>Latin</b> the results will always be provided using the Latin character set with accents and<br>
 *     other diacritics removed.
 *     <p><b>Note: </b><i>For French diacritics in Canada, you must specify <b>Native</b>.</i></p>
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
