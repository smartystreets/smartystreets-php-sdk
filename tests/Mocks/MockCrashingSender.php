<?php

namespace SmartyStreets\PhpSdk\Tests\Mocks;

require_once(dirname(dirname(dirname(__FILE__))) . '/src/Sender.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/Response.php');

use SmartyStreets\PhpSdk\Exceptions\MustRetryException;
use SmartyStreets\PhpSdk\Exceptions\TooManyRequestsException;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Psr7\Response;

class MockCrashingSender implements ClientInterface {
    const STATUS_CODE = 200;
    private $sendCount = 0;

    public function __construct() { }

    public function sendRequest(RequestInterface $request): ResponseInterface {
        $this->sendCount++;
        $url = (string)$request->getUri();
        if (strpos($url, "RetryThreeTimes") !== false) {
            if ($this->sendCount <= 3) {
                throw new MustRetryException("You need to retry");
            }
        }
        if (strpos($url, "RetryMaxTimes") !== false)
            throw new \Exception("Retrying won't help");
        if (strpos($url, "RetryFifteenTimes") !== false)
            if ($this->sendCount <= 14)
                throw new MustRetryException("You need to retry");
        if (strpos($url, "HitRateLimit") !== false)
            if ($this->sendCount <= 1)
                throw new TooManyRequestsException("Slow down");
        return new Response(self::STATUS_CODE);
    }

    public function getSendCount() {
        return $this->sendCount;
    }
}