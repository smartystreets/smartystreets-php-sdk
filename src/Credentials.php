<?php

namespace SmartyStreets\PhpSdk;

interface Credentials {
    function sign(Request $request);
}