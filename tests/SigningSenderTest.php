<?php

namespace SmartyStreets\PhpSdk\Tests;

require_once('Mocks/MockSender.php');
require_once(dirname(dirname(__FILE__)) . '/src/Request.php');
require_once(dirname(dirname(__FILE__)) . '/src/Response.php');
require_once(dirname(dirname(__FILE__)) . '/src/StaticCredentials.php');
require_once(dirname(dirname(__FILE__)) . '/src/SigningSender.php');
use SmartyStreets\PhpSdk\Tests\Mocks\MockSender;
use SmartyStreets\PhpSdk\Request;
use SmartyStreets\PhpSdk\Response;
use SmartyStreets\PhpSdk\StaticCredentials;
use SmartyStreets\PhpSdk\SigningSender;
use PHPUnit\Framework\TestCase;

class SigningSenderTest extends TestCase {

    public function testSigningOfRequest() {
        $signer = new StaticCredentials("id", "secret");
        $mockSender = new MockSender(new Response("", ""));
        $sender = new SigningSender($signer, $mockSender);
        $request = new Request();
        $request->setUrlPrefix("http://localhost/");

        $sender->send($request);

        $actualRequest = $mockSender->getRequest();
        $this->assertEquals("http://localhost/?auth-id=id&auth-token=secret", $actualRequest->getUrl());
    }

    public function testResponseReturnedCorrectly() {
        $signer = new StaticCredentials("id", "secret");
        $expectedResponse = new Response(200, "");
        $mockSender = new MockSender($expectedResponse);
        $sender = new SigningSender($signer, $mockSender);

        $actualResponse = $sender->send(new Request());

        $this->assertEquals($expectedResponse, $actualResponse);
    }
}
