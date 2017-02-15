<?php

namespace SmartyStreets;

interface Credentials {
    function sign(Request $request);
}