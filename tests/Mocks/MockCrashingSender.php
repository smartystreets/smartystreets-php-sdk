<?php

namespace SmartyStreets\PhpSdk\Tests\Mocks;

require_once(dirname(dirname(dirname(__FILE__))) . '/src/Sender.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/Response.php');

use SmartyStreets\PhpSdk\Exceptions\MustRetryException;
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
        $url = $request->getUrl();

        if (strpos($url, "RetryThreeTimes") !== false) {
            if ($this->sendCount <= 3) {
                throw new MustRetryException("You need to retry");
            }
            // After 3 retries, return successfully
            return new Response(self::STATUS_CODE, "", "");
        }

        if (strpos($url, "RetryMaxTimes") !== false)
            throw new \Exception("Retrying won't help");

        if (strpos($url, "RetryFifteenTimes") !== false) {
            if ($this->sendCount <= 14) {
                throw new MustRetryException("You need to retry");
            }
            // After 14 retries, return successfully
            return new Response(self::STATUS_CODE, "", "");
        }

        if (strpos($url, "HitRateLimit") !== false) {
            if ($this->sendCount <= 1) {
                throw new TooManyRequestsException("Slow down", 0, 6);
            }
            // After rate limit, return successfully
            return new Response(self::STATUS_CODE, "", "");
        }

        // Only return successfully if explicitly told not to crash
        if (strpos($url, "DoNotRetry") !== false)
            return new Response(self::STATUS_CODE, "", "");

        // By default, throw an exception to simulate a sender error
        throw new \Exception("Sender error");
    }

    public function getSendCount() {
        return $this->sendCount;
    }
}