<?php

namespace SmartyStreets\Tests;

require_once(dirname(dirname(__FILE__)) . '/src/Request.php');
require_once(dirname(dirname(__FILE__)) . '/src/Response.php');
require_once(dirname(dirname(__FILE__)) . '/src/URLPrefixSender.php');
require_once('Mocks/MockSender.php');
use SmartyStreets\Request;
use SmartyStreets\Response;
use SmartyStreets\URLPrefixSender;
use SmartyStreets\Tests\Mocks\MockSender;

class URLPrefixSenderTest extends \PHPUnit_Framework_TestCase {
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