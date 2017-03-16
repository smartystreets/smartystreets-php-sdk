<?php

namespace SmartyStreets\PhpSdk\Tests\Mocks;

require_once(dirname(dirname(dirname(__FILE__))) . '/src/Logger.php');
use SmartyStreets\PhpSdk\Logger;

class MockLogger implements Logger {
    private $log;

    public function log($message) {
        $this->log[] = $message;
    }

    public function getLog() {
        return $this->log;
    }
}