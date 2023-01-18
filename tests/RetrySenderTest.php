<?php

namespace SmartyStreets\PhpSdk\Tests;

require_once('Mocks/MockCrashingSender.php');
require_once('Mocks/MockLogger.php');
require_once('Mocks/MockSleeper.php');
require_once(dirname(dirname(__FILE__)) . '/src/RetrySender.php');
require_once(dirname(dirname(__FILE__)) . '/src/Request.php');
use SmartyStreets\PhpSdk\Tests\Mocks\MockCrashingSender;
use SmartyStreets\PhpSdk\Tests\Mocks\MockLogger;
use SmartyStreets\PhpSdk\Tests\Mocks\MockSleeper;
use SmartyStreets\PhpSdk\RetrySender;
use SmartyStreets\PhpSdk\Request;
use PHPUnit\Framework\TestCase;

class RetrySenderTest extends TestCase {
    private $mockCrashingSender,
            $mockLogger,
            $mockSleeper;

    public function setUp() : void {
        $this->mockCrashingSender = new MockCrashingSender();
        $this->mockLogger = new MockLogger();
        $this->mockSleeper = new MockSleeper();
    }

    public function testSuccessDoesNotRetry() {
        $this->sendRequest("DoNotRetry");

        $this->assertEquals(1, $this->mockCrashingSender->getSendCount());
    }

    public function testRetryUntilSuccess() {
        $this->sendRequest("RetryThreeTimes");

        $this->assertEquals(4, $this->mockCrashingSender->getSendCount());
    }

    public function testRetryUntilMaxAttempts() {
        $this->expectException(\Exception::class);

        $this->sendRequest("RetryMaxTimes");
    }

    public function testBackoffDoesNotExceedMax() {
        $expectedDurations = array(10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10);

        $this->sendRequest("RetryFifteenTimes");

        $this->assertEquals(15, $this->mockCrashingSender->getSendCount());
        $this->assertEquals($expectedDurations, $this->mockSleeper->getSleepDurations());
    }

    //public function testSleepOnRateLimit() {
    //    $this->expectException(\TooManyRequestsException::class);

    //    $this->sendRequest("HitRateLimit");
    //}

    private function sendRequest($requestBehavior) {
        $request = new Request();
        $request->setUrlPrefix($requestBehavior);

        $retrySender = new RetrySender(15, $this->mockSleeper, $this->mockLogger, $this->mockCrashingSender);

        $retrySender->send($request);
    }
}