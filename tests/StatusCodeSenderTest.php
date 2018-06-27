<?php

namespace SmartyStreets\PhpSdk\Tests;

require_once('Mocks/MockStatusCodeSender.php');
require_once(dirname(dirname(__FILE__)) . '/src/StatusCodeSender.php');
require_once(dirname(dirname(__FILE__)) . '/src/Request.php');
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
        $classType = \SmartyStreets\PhpSdk\Exceptions\BadRequestException::class;

        $this->assertSend(400, $classType);
    }

    public function test401ResponseThrowsBadCredentialsException() {
        $classType = \SmartyStreets\PhpSdk\Exceptions\BadCredentialsException::class;

        $this->assertSend(401, $classType);
    }

    public function test402ResponsePThrowsPaymentRequiredException() {
        $classType = \SmartyStreets\PhpSdk\Exceptions\PaymentRequiredException::class;

        $this->assertSend(402, $classType);
    }

    public function test413ResponseThrowsRequestEntityTooLargeException() {
        $classType = \SmartyStreets\PhpSdk\Exceptions\RequestEntityTooLargeException::class;

        $this->assertSend(413, $classType);
    }

    public function test422ResponseThrowsUnprocessableEntityException() {
        $classType = \SmartyStreets\PhpSdk\Exceptions\UnprocessableEntityException::class;

        $this->assertSend(422, $classType);
    }

    public function test429ResponseThrowsTooManyRequestsException() {
        $classType = \SmartyStreets\PhpSdk\Exceptions\TooManyRequestsException::class;

        $this->assertSend(429, $classType);
    }

    public function test500ResponseThrowsInternalServerErrorException() {
        $classType = \SmartyStreets\PhpSdk\Exceptions\InternalServerErrorException::class;

        $this->assertSend(500, $classType);
    }

    public function test503ResponseThrowsServiceUnavailableException() {
        $classType = \SmartyStreets\PhpSdk\Exceptions\ServiceUnavailableException::class;

        $this->assertSend(503, $classType);
    }

    public function test504ResponseThrowsGatewayTimeoutException() {
        $classType = \SmartyStreets\PhpSdk\Exceptions\GatewayTimeoutException::class;

        $this->assertSend(504, $classType);
    }

    private function assertSend($statusCode, $classType) {
        $sender = new StatusCodeSender(new MockStatusCodeSender($statusCode));

        $this->expectException($classType);

        $sender->send(new Request());
    }
}