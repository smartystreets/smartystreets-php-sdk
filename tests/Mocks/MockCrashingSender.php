<?php

namespace SmartyStreets\PhpSdk\Tests\Mocks;

require_once(dirname(dirname(dirname(__FILE__))) . '/src/Sender.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/Response.php');

use SmartyStreets\PhpSdk\Exceptions\TooManyRequestsException;
use SmartyStreets\PhpSdk\Response;
use SmartyStreets\PhpSdk\Request;
use SmartyStreets\PhpSdk\Sender;

class MockCrashingSender implements Sender {
    const STATUS_CODE = 200;
    private $sendCount = 0;

    public function __construct() { }

    function send(Request $request) {
        $this->sendCount++;

        if (strpos($request->getUrl(), "RetryThreeTimes") !== false) {
            if ($this->sendCount <= 3) {
                throw new \Exception("You need to retry");
            }
        }

        if (strpos($request->getUrl(), "RetryMaxTimes") !== false)
            throw new \Exception("Retrying won't help");

        if (strpos($request->getUrl(), "RetryFifteenTimes") !== false)
            if ($this->sendCount <= 14)
                throw new \Exception("You need to retry");

        if (strpos($request->getUrl(), "HitRateLimit") !== false)
            if ($this->sendCount <= 1)
                throw new TooManyRequestsException("Slow down");

        return new Response(self::STATUS_CODE, "", "");
    }

    public function getSendCount() {
        return $this->sendCount;
    }
}