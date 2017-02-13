<?php

require_once('mocks/MockCrashingSender.php');
require_once(dirname(dirname(__FILE__)) . '/src/smartystreets/api/RetrySender.php');
require_once(dirname(dirname(__FILE__)) . '/src/smartystreets/api/Request.php');
use mocks\MockCrashingSender;
use smartystreets\api\RetrySender as RetrySender;
use smartystreets\api\Request;

class RetrySenderTest extends PHPUnit_Framework_TestCase {
    private $mockCrashingSender;

    public function setUp() {
        $this->mockCrashingSender = new MockCrashingSender();
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
        $classType = \Exception::class;

        $this->expectException($classType);

        $this->sendRequest("RetryMaxTimes");
    }

    private function sendRequest($requestBehavior) {
        $request = new Request();
        $request->setUrlPrefix($requestBehavior);

        $retrySender = new RetrySender(5, $this->mockCrashingSender);

        $retrySender->send($request);
    }

}