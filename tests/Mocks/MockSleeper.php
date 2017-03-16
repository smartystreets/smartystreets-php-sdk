<?php

namespace SmartyStreets\PhpSdk\Tests\Mocks;

require_once(dirname(dirname(dirname(__FILE__))) . '/src/Sleeper.php');
use SmartyStreets\PhpSdk\Sleeper;

class MockSleeper implements Sleeper {
    private $sleepDurations;

    public function sleep($seconds) {
        $this->sleepDurations[] = $seconds;
    }

    public function getSleepDurations() {
        return $this->sleepDurations;
    }
}