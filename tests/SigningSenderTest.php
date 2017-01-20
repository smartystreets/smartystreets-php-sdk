<?php

require_once(dirname(dirname(__FILE__)) . '/src/smartystreets/api/Request.php');
require_once(dirname(dirname(__FILE__)) . '/src/smartystreets/api/Response.php');
require_once(dirname(dirname(__FILE__)) . '/src/smartystreets/api/StaticCredentials.php');
require_once(dirname(dirname(__FILE__)) . '/src/smartystreets/api/SigningSender.php');
require_once('mocks/MockSender.php');
use smartystreets\api\Request as Request;
use smartystreets\api\Response as Response;
use smartystreets\api\StaticCredentials as StaticCredentials;
use smartystreets\api\SigningSender as SigningSender;
use mocks\MockSender;

class SigningSenderTest extends PHPUnit_Framework_TestCase {

    public function testSigningOfRequest() {
        $signer = new StaticCredentials("id", "secret");
        $mockSender = new MockSender(new Response("", ""));
        $sender = new SigningSender($signer, $mockSender);

        $sender->send(new Request("http://localhost/"));

        $request = $mockSender->getRequest();
        $this->assertEquals("http://localhost/?auth-id=id&auth-token=secret", $request->getUrl());
    }

    public function testResponseReturnedCorrectly() {
        $signer = new StaticCredentials("id", "secret");
        $expectedResponse = new Response(200, "");
        $mockSender = new MockSender($expectedResponse);
        $sender = new SigningSender($signer, $mockSender);

        $actualResponse = $sender->send(new Request("http://localhost"));

        $this->assertEquals($expectedResponse, $actualResponse);
    }
}
