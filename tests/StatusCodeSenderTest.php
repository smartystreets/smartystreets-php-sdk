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
use SmartyStreets\PhpSdk\Exceptions\RequestNotModifiedException;
use SmartyStreets\PhpSdk\Exceptions\RequestTimeoutException;
use SmartyStreets\PhpSdk\Exceptions\ServiceUnavailableException;
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

    public function testNotModifiedExceptionCarriesResponseEtag() {
        $sender = new StatusCodeSender(new MockStatusCodeSender(304, '', ['Etag' => 'server-refreshed-etag']));
        try {
            $sender->send(new Request());
            $this->fail("Expected RequestNotModifiedException");
        } catch (RequestNotModifiedException $ex) {
            $this->assertEquals('server-refreshed-etag', $ex->getResponseEtag());
        }
    }

    public function testNotModifiedExceptionResponseEtagIsCaseInsensitive() {
        $sender = new StatusCodeSender(new MockStatusCodeSender(304, '', ['ETAG' => 'case-insensitive-etag']));
        try {
            $sender->send(new Request());
            $this->fail("Expected RequestNotModifiedException");
        } catch (RequestNotModifiedException $ex) {
            $this->assertEquals('case-insensitive-etag', $ex->getResponseEtag());
        }
    }

    public function testNotModifiedExceptionResponseEtagNullWhenHeaderAbsent() {
        $sender = new StatusCodeSender(new MockStatusCodeSender(304, '', null));
        try {
            $sender->send(new Request());
            $this->fail("Expected RequestNotModifiedException");
        } catch (RequestNotModifiedException $ex) {
            $this->assertNull($ex->getResponseEtag());
        }
    }

    public function test400UsesMessageFromResponsePayload() {
        $this->assertMessageFromPayload(400, BadRequestException::class);
    }

    public function test400FallsBackToDefaultMessage() {
        $this->assertFallbackMessage(400, BadRequestException::class,
            "Bad Request (Malformed Payload): A GET request lacked a street field or the request body of a POST request contained malformed JSON.");
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
            $this->assertEquals($fallback, $ex->getMessage());
            $this->assertEquals($statusCode, $ex->getCode());
        }
    }
}