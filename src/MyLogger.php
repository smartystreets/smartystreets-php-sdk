<?php

namespace SmartyStreets\PhpSdk;

class MyLogger implements Logger {
    public function log($message) {
        error_log($message);
    }
}
