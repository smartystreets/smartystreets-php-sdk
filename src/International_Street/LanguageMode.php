<?php

namespace SmartyStreets\PhpSdk\International_Street;

define('LANGUAGE_MODE_NATIVE', 'native', false);
define('LANGUAGE_MODE_LATIN', 'latin', false);

/**
 * When not set, the output language will match the language of the input values. When set to <b>NATIVE</b> the<br>
 *     results will always be in the language of the output country. When set to <b>LATIN</b> the results<br>
 *     will always be provided using a Latin character set.
 */
class LanguageMode {
    private $name;

    public function __construct($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }
}