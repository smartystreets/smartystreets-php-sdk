<?php

namespace SmartyStreets\PhpSdk\Tests;

require_once('Mocks/MockCrashingSender.php');
require_once(dirname(dirname(__FILE__)) . '/src/RetrySender.php');
require_once(dirname(dirname(__FILE__)) . '/src/Request.php');
use SmartyStreets\PhpSdk\Tests\Mocks\MockCrashingSender;
use SmartyStreets\PhpSdk\RetrySender;
use SmartyStreets\PhpSdk\Request;

class RetrySenderTest extends \PHPUnit_Framework_TestCase {
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