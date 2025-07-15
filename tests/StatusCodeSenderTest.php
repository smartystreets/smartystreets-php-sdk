<?php

namespace SmartyStreets\PhpSdk\Tests;

require_once('Mocks/MockStatusCodeSender.php');
require_once(dirname(dirname(__FILE__)) . '/src/StatusCodeSender.php');
require_once(dirname(dirname(__FILE__)) . '/src/Request.php');

use SmartyStreets\PhpSdk\Exceptions\BadCredentialsException;
use SmartyStreets\PhpSdk\Exceptions\BadRequestException;
use SmartyStreets\PhpSdk\Exceptions\GatewayTimeoutException;
use SmartyStreets\PhpSdk\Exceptions\InternalServerErrorException;
use SmartyStreets\PhpSdk\Exceptions\PaymentRequiredException;
use SmartyStreets\PhpSdk\Exceptions\RequestEntityTooLargeException;
use SmartyStreets\PhpSdk\Exceptions\ServiceUnavailableException;
use SmartyStreets\PhpSdk\Exceptions\TooManyRequestsException;
use SmartyStreets\PhpSdk\Exceptions\UnprocessableEntityException;
use SmartyStreets\PhpSdk\Tests\Mocks\MockStatusCodeSender;
use SmartyStreets\PhpSdk\StatusCodeSender;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientInterface;

class StatusCodeSenderTest extends TestCase {

    public function test200Response() {
        $sender = new StatusCodeSender(new MockStatusCodeSender(200));
        $response = $sender->sendRequest(new Request('GET', 'https://example.com/'));
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test400ResponseThrowsBadRequestException() {
        $classType = BadRequestException::class;

        $this->assertSend(400, $classType);
    }

    public function test401ResponseThrowsBadCredentialsException() {
        $classType = BadCredentialsException::class;

        $this->assertSend(401, $classType);
    }

    public function test402ResponseThrowsPaymentRequiredException() {
        $classType = PaymentRequiredException::class;

        $this->assertSend(402, $classType);
    }

    public function test413ResponseThrowsRequestEntityTooLargeException() {
        $classType = RequestEntityTooLargeException::class;

        $this->assertSend(413, $classType);
    }

    public function test422ResponseThrowsUnprocessableEntityException() {
        $classType = UnprocessableEntityException::class;

        $this->assertSend(422, $classType);
    }

    public function test429ResponseThrowsTooManyRequestsException() {
        $classType = TooManyRequestsException::class;

        $this->assertSend(429, $classType);
    }

    public function test500ResponseThrowsInternalServerErrorException() {
        $classType = InternalServerErrorException::class;

        $this->assertSend(500, $classType);
    }

    public function test503ResponseThrowsServiceUnavailableException() {
        $classType = ServiceUnavailableException::class;

        $this->assertSend(503, $classType);
    }

    public function test504ResponseThrowsGatewayTimeoutException() {
        $classType = GatewayTimeoutException::class;

        $this->assertSend(504, $classType);
    }

    public function testDefaultCaseThrowsSmartyException() {
        $sender = new StatusCodeSender(new MockStatusCodeSender(599));
        $this->expectException(\SmartyStreets\PhpSdk\Exceptions\SmartyException::class);
        $sender->sendRequest(new Request('GET', 'https://example.com/'));
    }

    public function test429WithMalformedResponseBody() {
        $mockSender = new class implements ClientInterface {
            public function sendRequest($request): \Psr\Http\Message\ResponseInterface {
                return new \GuzzleHttp\Psr7\Response(429, [], 'not-json');
            }
        };
        $sender = new StatusCodeSender($mockSender);
        $this->expectException(\SmartyStreets\PhpSdk\Exceptions\TooManyRequestsException::class);
        $sender->sendRequest(new Request('GET', 'https://example.com/'));
    }

    public function test429WithErrorsArrayInResponseBody() {
        $mockSender = new class implements ClientInterface {
            public function sendRequest($request): \Psr\Http\Message\ResponseInterface {
                $body = json_encode(['errors' => [['message' => 'rate limit exceeded']]]);
                return new \GuzzleHttp\Psr7\Response(429, [], $body);
            }
        };
        $sender = new StatusCodeSender($mockSender);
        $this->expectException(\SmartyStreets\PhpSdk\Exceptions\TooManyRequestsException::class);
        try {
            $sender->sendRequest(new Request('GET', 'https://example.com/'));
        } catch (\SmartyStreets\PhpSdk\Exceptions\TooManyRequestsException $e) {
            $this->assertStringContainsString('rate limit exceeded', $e->getMessage());
            throw $e;
        }
    }

    private function assertSend($statusCode, $classType) {
        $sender = new StatusCodeSender(new MockStatusCodeSender($statusCode));
        $this->expectException($classType);
        $sender->sendRequest(new Request('GET', 'https://example.com/'));
    }
}