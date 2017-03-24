<?php

namespace SmartyStreets\PhpSdk;

/**
 * Credentials are classes that 'sign' requests by adding SmartyStreets authentication keys.
 */
interface Credentials {
    function sign(Request $request);
}