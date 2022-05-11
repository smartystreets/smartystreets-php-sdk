<?php

namespace SmartyStreets\PhpSdk;

include_once('Logger.php');

class MyLogger implements Logger {
    public function log($message) {
        error_log($message);
    }
}
