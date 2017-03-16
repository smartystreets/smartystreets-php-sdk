<?php

namespace SmartyStreets\PhpSdk;

include_once('Sleeper.php');

class MySleeper implements Sleeper {
    public function sleep($seconds) {
        sleep($seconds);
    }
}