<?php

namespace SmartyStreets;

interface Sender {
    function send(Request $request);
}