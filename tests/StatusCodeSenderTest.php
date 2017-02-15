<?php

namespace SmartyStreets\Tests;

require_once('Mocks/MockStatusCodeSender.php');
require_once(dirname(dirname(__FILE__)) . '/src/StatusCodeSender.php');
require_once(dirname(dirname(__FILE__)) . '/src/Request.php');
use SmartyStreets\Tests\Mocks\MockStatusCodeSender;
use SmartyStreets\StatusCodeSender as StatusCodeSender;
use SmartyStreets\Request;

class StatusCodeSenderTest extends \PHPUnit_Framework_TestCase {

    public function test200Response() {
        $sender = new StatusCodeSender(new MockStatusCodeSender(200));

        $response = $sender->send(new Request());

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test400ResponseThrowsBadRequestException() {
        $classType = \SmartyStreets\Exceptions\BadRequestException::class;

        $this->assertSend(400, $classType);
    }

    public function test401ResponseThrowsBadCredentialsException() {
        $classType = \SmartyStreets\Exceptions\BadCredentialsException::class;

        $this->assertSend(401, $classType);
    }

    public function test402ResponsePThrowsPaymentRequiredException() {
        $classType = \SmartyStreets\Exceptions\PaymentRequiredException::class;

        $this->assertSend(402, $classType);
    }

    public function test413ResponseThrowsRequestEntityTooLargeException() {
        $classType = \SmartyStreets\Exceptions\RequestEntityTooLargeException::class;

        $this->assertSend(413, $classType);
    }

    public function test429ResponseThrowsTooManyRequestsException() {
        $classType = \SmartyStreets\Exceptions\TooManyRequestsException::class;

        $this->assertSend(429, $classType);
    }

    public function test500ResponseThrowsInternalServerErrorException() {
        $classType = \SmartyStreets\Exceptions\InternalServerErrorException::class;

        $this->assertSend(500, $classType);
    }

    public function test503ResponseThrowsServiceUnavailableException() {
        $classType = \SmartyStreets\Exceptions\ServiceUnavailableException::class;

        $this->assertSend(503, $classType);
    }

    private function assertSend($statusCode, $classType) {
        $sender = new StatusCodeSender(new MockStatusCodeSender($statusCode));

        $this->expectException($classType);

        $sender->send(new Request());
    }
}