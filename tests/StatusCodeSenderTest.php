<?php

namespace SmartyStreets\PhpSdk\Tests;

require_once('Mocks/MockStatusCodeSender.php');
require_once(dirname(dirname(__FILE__)) . '/src/StatusCodeSender.php');
require_once(dirname(dirname(__FILE__)) . '/src/Request.php');

use SmartyStreets\PhpSdk\Exceptions\BadCredentialsException;
use SmartyStreets\PhpSdk\Exceptions\BadGatewayException;
use SmartyStreets\PhpSdk\Exceptions\BadRequestException;
use SmartyStreets\PhpSdk\Exceptions\ForbiddenException;
use SmartyStreets\PhpSdk\Exceptions\GatewayTimeoutException;
use SmartyStreets\PhpSdk\Exceptions\InternalServerErrorException;
use SmartyStreets\PhpSdk\Exceptions\PaymentRequiredException;
use SmartyStreets\PhpSdk\Exceptions\RequestEntityTooLargeException;
use SmartyStreets\PhpSdk\Exceptions\RequestTimeoutException;
use SmartyStreets\PhpSdk\Exceptions\ServiceUnavailableException;
use SmartyStreets\PhpSdk\Exceptions\SmartyException;
use SmartyStreets\PhpSdk\Exceptions\TooManyRequestsException;
use SmartyStreets\PhpSdk\Exceptions\UnprocessableEntityException;
use SmartyStreets\PhpSdk\Tests\Mocks\MockStatusCodeSender;
use SmartyStreets\PhpSdk\StatusCodeSender;
use SmartyStreets\PhpSdk\Request;
use PHPUnit\Framework\TestCase;

class StatusCodeSenderTest extends TestCase {

    public function test200Response() {
        $sender = new StatusCodeSender(new MockStatusCodeSender(200));

        $response = $sender->send(new Request());

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
        // Custom retry-after
        $sender = new StatusCodeSender(new MockStatusCodeSender(429, "", ['retry-after' => '4']));
        try {
            $sender->send(new Request());
            $this->fail("Should have thrown exception.");
        } catch (TooManyRequestsException $ex) {
            $this->assertEquals(429, $ex->getCode());
            $this->assertEquals(4, $ex->getRetryAfterValue());
        }

        // Default retry-after
        $sender = new StatusCodeSender(new MockStatusCodeSender(429, "", null));
        try {
            $sender->send(new Request());
            $this->fail("Should have thrown exception.");
        } catch (TooManyRequestsException $ex) {
            $this->assertEquals(429, $ex->getCode());
            $this->assertEquals(10, $ex->getRetryAfterValue());
        }

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

    public function test304IsNotAnError() {
        $sender = new StatusCodeSender(new MockStatusCodeSender(304, '', ['Etag' => 'server-refreshed-etag']));

        $response = $sender->send(new Request());

        $this->assertEquals(304, $response->getStatusCode());
        $this->assertEquals('server-refreshed-etag', $response->getHeaders()['Etag']);
    }

    public function test400UsesMessageFromResponsePayload() {
        $this->assertMessageFromPayload(400, BadRequestException::class);
    }

    public function test400FallsBackToDefaultMessage() {
        $this->assertFallbackMessage(400, BadRequestException::class,
            "Bad Request (Malformed Payload): A GET request lacked a required field or the request body of a POST request contained malformed JSON.");
    }

    public function test401UsesMessageFromResponsePayload() {
        $this->assertMessageFromPayload(401, BadCredentialsException::class);
    }

    public function test401FallsBackToDefaultMessage() {
        $this->assertFallbackMessage(401, BadCredentialsException::class,
            "Unauthorized: The credentials were provided incorrectly or did not match any existing, active credentials.");
    }

    public function test402UsesMessageFromResponsePayload() {
        $this->assertMessageFromPayload(402, PaymentRequiredException::class);
    }

    public function test402FallsBackToDefaultMessage() {
        $this->assertFallbackMessage(402, PaymentRequiredException::class,
            "Payment Required: There is no active subscription for the account associated with the credentials submitted with the request.");
    }

    public function test408UsesMessageFromResponsePayload() {
        $this->assertMessageFromPayload(408, RequestTimeoutException::class);
    }

    public function test408FallsBackToDefaultMessage() {
        $this->assertFallbackMessage(408, RequestTimeoutException::class, "Request timeout error.");
    }

    public function test413UsesMessageFromResponsePayload() {
        $this->assertMessageFromPayload(413, RequestEntityTooLargeException::class);
    }

    public function test413FallsBackToDefaultMessage() {
        $this->assertFallbackMessage(413, RequestEntityTooLargeException::class,
            "Request Entity Too Large: The request body has exceeded the maximum size.");
    }

    public function test422UsesMessageFromResponsePayload() {
        $this->assertMessageFromPayload(422, UnprocessableEntityException::class);
    }

    public function test422FallsBackToDefaultMessage() {
        $this->assertFallbackMessage(422, UnprocessableEntityException::class, "GET request lacked required fields.");
    }

    public function test403ResponseThrowsForbiddenException() {
        $this->assertSend(403, ForbiddenException::class);
    }

    public function test403UsesMessageFromResponsePayload() {
        $this->assertMessageFromPayload(403, ForbiddenException::class);
    }

    public function test403FallsBackToDefaultMessage() {
        $this->assertFallbackMessage(403, ForbiddenException::class,
            "Forbidden: The request contained valid data and was understood by the server, but the server is refusing action.");
    }

    public function test429UsesMessageFromResponsePayload() {
        $payload = json_encode(['errors' => [
            ['message' => 'First problem.'],
            ['message' => 'Second problem.'],
        ]]);
        $sender = new StatusCodeSender(new MockStatusCodeSender(429, $payload));

        try {
            $sender->send(new Request());
            $this->fail("Should have thrown exception.");
        } catch (TooManyRequestsException $ex) {
            $this->assertEquals('First problem. Second problem.', $ex->getMessage());
        }
    }

    public function test429FallsBackToDefaultMessage() {
        $sender = new StatusCodeSender(new MockStatusCodeSender(429, ''));

        try {
            $sender->send(new Request());
            $this->fail("Should have thrown exception.");
        } catch (TooManyRequestsException $ex) {
            $this->assertEquals("Too Many Requests: The rate limit for your account has been exceeded. Body:", $ex->getMessage());
        }
    }

    public function test500UsesMessageFromResponsePayload() {
        $this->assertMessageFromPayload(500, InternalServerErrorException::class);
    }

    public function test500FallsBackToDefaultMessage() {
        $this->assertFallbackMessage(500, InternalServerErrorException::class, "Internal Server Error.");
    }

    public function test502UsesMessageFromResponsePayload() {
        $this->assertMessageFromPayload(502, BadGatewayException::class);
    }

    public function test502FallsBackToDefaultMessage() {
        $this->assertFallbackMessage(502, BadGatewayException::class, "Bad Gateway error.");
    }

    public function test503UsesMessageFromResponsePayload() {
        $this->assertMessageFromPayload(503, ServiceUnavailableException::class);
    }

    public function test503FallsBackToDefaultMessage() {
        $this->assertFallbackMessage(503, ServiceUnavailableException::class, "Service Unavailable. Try again later.");
    }

    public function test504UsesMessageFromResponsePayload() {
        $this->assertMessageFromPayload(504, GatewayTimeoutException::class);
    }

    public function test504FallsBackToDefaultMessage() {
        $this->assertFallbackMessage(504, GatewayTimeoutException::class,
            "The upstream data provider did not respond in a timely fashion and the request failed. A serious, yet rare occurrence indeed.");
    }

    public function testUnexpectedStatusCodeUsesMessageFromResponsePayload() {
        $this->assertMessageFromPayload(418, SmartyException::class);
    }

    public function testUnexpectedStatusCodeFallsBackToDefaultMessage() {
        $this->assertFallbackMessage(418, SmartyException::class,
            "The server returned an unexpected HTTP status code: 418");
    }

    public function testFallbackAppendsUnparseableBody() {
        $sender = new StatusCodeSender(new MockStatusCodeSender(422, 'not json'));

        try {
            $sender->send(new Request());
            $this->fail("Should have thrown exception.");
        } catch (UnprocessableEntityException $ex) {
            $this->assertEquals("GET request lacked required fields. Body: not json", $ex->getMessage());
        }
    }

    public function testFallbackAppendsBodyWithoutMessages() {
        $payload = json_encode(['errors' => []]);
        $sender = new StatusCodeSender(new MockStatusCodeSender(422, $payload));

        try {
            $sender->send(new Request());
            $this->fail("Should have thrown exception.");
        } catch (UnprocessableEntityException $ex) {
            $this->assertEquals("GET request lacked required fields. Body: " . $payload, $ex->getMessage());
        }
    }

    public function testBlankBodyYieldsEmptyBodyLabel() {
        $sender = new StatusCodeSender(new MockStatusCodeSender(422, '   '));

        try {
            $sender->send(new Request());
            $this->fail("Should have thrown exception.");
        } catch (UnprocessableEntityException $ex) {
            $this->assertEquals("GET request lacked required fields. Body:", $ex->getMessage());
        }
    }

    private function assertSend($statusCode, $classType) {
        $sender = new StatusCodeSender(new MockStatusCodeSender($statusCode));

        $this->expectException($classType);

        $sender->send(new Request());
    }

    private function assertMessageFromPayload($statusCode, $classType) {
        $payload = json_encode(['errors' => [
            ['message' => 'First problem.'],
            ['message' => 'Second problem.'],
        ]]);
        $sender = new StatusCodeSender(new MockStatusCodeSender($statusCode, $payload));

        try {
            $sender->send(new Request());
            $this->fail("Should have thrown exception.");
        } catch (\Exception $ex) {
            $this->assertInstanceOf($classType, $ex);
            $this->assertEquals('First problem. Second problem.', $ex->getMessage());
            $this->assertEquals($statusCode, $ex->getCode());
        }
    }

    private function assertFallbackMessage($statusCode, $classType, $fallback) {
        $sender = new StatusCodeSender(new MockStatusCodeSender($statusCode, ''));

        try {
            $sender->send(new Request());
            $this->fail("Should have thrown exception.");
        } catch (\Exception $ex) {
            $this->assertInstanceOf($classType, $ex);
            $this->assertEquals($fallback . " Body:", $ex->getMessage());
            $this->assertEquals($statusCode, $ex->getCode());
        }
    }
}