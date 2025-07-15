<?php

namespace SmartyStreets\PhpSdk\Tests;

require_once('Mocks/MockCrashingSender.php');
require_once('Mocks/MockLogger.php');
require_once('Mocks/MockSleeper.php');
require_once(dirname(dirname(__FILE__)) . '/src/Exceptions/MustRetryException.php');
require_once(dirname(dirname(__FILE__)) . '/src/RetrySender.php');
require_once(dirname(dirname(__FILE__)) . '/src/Request.php');
use SmartyStreets\PhpSdk\Tests\Mocks\MockCrashingSender;
use SmartyStreets\PhpSdk\Tests\Mocks\MockLogger;
use SmartyStreets\PhpSdk\Tests\Mocks\MockSleeper;
use SmartyStreets\PhpSdk\RetrySender;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientInterface;
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

    public function testRetriesOnSpecificStatusCodes() {
        $statusCodes = [408, 429, 500, 502, 503, 504];
        foreach ($statusCodes as $code) {
            $mockSender = new class($code) implements ClientInterface {
                private $code; private $count = 0;
                public function __construct($code) { $this->code = $code; }
                public function sendRequest($request): \Psr\Http\Message\ResponseInterface {
                    $this->count++;
                    return new \GuzzleHttp\Psr7\Response($this->code);
                }
                public function getSendCount() { return $this->count; }
            };
            $retrySender = new RetrySender(2, new MockSleeper(), new MockLogger(), $mockSender);
            try {
                $retrySender->sendRequest(new Request('GET', 'https://example.com/'));
            } catch (\RuntimeException $e) {
                $this->assertEquals(3, $mockSender->getSendCount());
            }
        }
    }

    public function testRetriesOnExceptionFromInnerSender() {
        $mockSender = new class implements ClientInterface {
            private $count = 0;
            public function sendRequest($request): \Psr\Http\Message\ResponseInterface {
                $this->count++;
                throw new \Exception('fail');
            }
            public function getSendCount() { return $this->count; }
        };
        $retrySender = new RetrySender(1, new MockSleeper(), new MockLogger(), $mockSender);
        $this->expectException(\Exception::class);
        try {
            $retrySender->sendRequest(new Request('GET', 'https://example.com/'));
        } catch (\Exception $e) {
            $this->assertEquals(2, $mockSender->getSendCount());
            throw $e;
        }
    }

    public function testLoggerIsCalledOnRetry() {
        $mockLogger = new class {
            public $logCalled = false;
            public function log($msg) { $this->logCalled = true; }
        };
        $mockSender = new class implements ClientInterface {
            public function sendRequest($request): \Psr\Http\Message\ResponseInterface {
                throw new \Exception('fail');
            }
        };
        $retrySender = new RetrySender(1, new MockSleeper(), $mockLogger, $mockSender);
        try { $retrySender->sendRequest(new Request('GET', 'https://example.com/')); } catch (\Exception $e) {}
        $this->assertTrue($mockLogger->logCalled);
    }

    public function testZeroRetriesMeansOneAttempt() {
        $mockSender = new class implements ClientInterface {
            public $count = 0;
            public function sendRequest($request): \Psr\Http\Message\ResponseInterface {
                $this->count++;
                throw new \Exception('fail');
            }
        };
        $retrySender = new RetrySender(0, new MockSleeper(), new MockLogger(), $mockSender);
        $this->expectException(\Exception::class);
        try { $retrySender->sendRequest(new Request('GET', 'https://example.com/')); } catch (\Exception $e) {
            $this->assertEquals(1, $mockSender->count);
            throw $e;
        }
    }

    private function sendRequest($requestBehavior) {
        $request = new Request('GET', 'https://example.com/' . $requestBehavior);
        $retrySender = new RetrySender(15, $this->mockSleeper, $this->mockLogger, $this->mockCrashingSender);
        $retrySender->sendRequest($request);
    }
}