<?php

require_once('mocks/MockStatusCodeSender.php');
require_once(dirname(dirname(__FILE__)) . '/src/smartystreets/api/StatusCodeSender.php');
require_once(dirname(dirname(__FILE__)) . '/src/smartystreets/api/Request.php');
use mocks\MockStatusCodeSender;
use smartystreets\api\StatusCodeSender as StatusCodeSender;
use smartystreets\api\Request;

class StatusCodeSenderTest extends PHPUnit_Framework_TestCase {

    public function test200Response() {
        $sender = new StatusCodeSender(new MockStatusCodeSender(200));

        $response = $sender->send(new Request());

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test400ResponseThrowsBadRequestException() {
        $classType = \smartystreets\api\exceptions\BadRequestException::class;

        $this->assertSend(400, $classType);
    }

    public function test401ResponseThrowsBadCredentialsException() {
        $classType = \smartystreets\api\exceptions\BadCredentialsException::class;

        $this->assertSend(401, $classType);
    }

    public function test402ResponsePThrowsPaymentRequiredException() {
        $classType = \smartystreets\api\exceptions\PaymentRequiredException::class;

        $this->assertSend(402, $classType);
    }

    public function test413ResponseThrowsRequestEntityTooLargeException() {
        $classType = \smartystreets\api\exceptions\RequestEntityTooLargeException::class;

        $this->assertSend(413, $classType);
    }

    public function test429ResponseThrowsTooManyRequestsException() {
        $classType = \smartystreets\api\exceptions\TooManyRequestsException::class;

        $this->assertSend(429, $classType);
    }

    public function test500ResponseThrowsInternalServerErrorException() {
        $classType = \smartystreets\api\exceptions\InternalServerErrorException::class;

        $this->assertSend(500, $classType);
    }

    public function test503ResponseThrowsServiceUnavailableException() {
        $classType = \smartystreets\api\exceptions\ServiceUnavailableException::class;

        $this->assertSend(503, $classType);
    }

    private function assertSend($statusCode, $classType) {
        $sender = new StatusCodeSender(new MockStatusCodeSender($statusCode));

        $this->expectException($classType);

        $sender->send(new Request());
    }
}