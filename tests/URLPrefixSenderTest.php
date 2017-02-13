<?php

require_once(dirname(dirname(__FILE__)) . '/src/smartystreets/api/Request.php');
require_once(dirname(dirname(__FILE__)) . '/src/smartystreets/api/Response.php');
require_once(dirname(dirname(__FILE__)) . '/src/smartystreets/api/URLPrefixSender.php');
require_once('mocks/MockSender.php');
use smartystreets\api\Request;
use smartystreets\api\Response;
use smartystreets\api\URLPrefixSender;
use mocks\MockSender;

class URLPrefixSenderTest extends PHPUnit_Framework_TestCase {
    public function testProvidedURLOverridesRequestURL() {
        $request = new Request();
        $request->setUrlPrefix("original");
        $override = "override?";
        $inner = new MockSender(new Response(123, null));
        $sender = new URLPrefixSender($override, $inner);

        $sender->send($request);

        $this->assertEquals($override, $request->getUrl());
    }
}