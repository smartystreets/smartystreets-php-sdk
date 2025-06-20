<?php

namespace SmartyStreets\PhpSdk;

interface Sender {
    function send(Request $request);
}