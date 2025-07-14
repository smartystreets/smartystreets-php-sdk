<?php

namespace SmartyStreets\PhpSdk;

class MySleeper implements Sleeper {
    public function sleep($seconds) {
        sleep($seconds);
    }
}