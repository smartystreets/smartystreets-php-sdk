<?php

namespace SmartyStreets\PhpSdk\Tests;

require_once(dirname(dirname(__FILE__)) . '/src/Request.php');
require_once(dirname(dirname(__FILE__)) . '/src/Response.php');
require_once(dirname(dirname(__FILE__)) . '/src/URLPrefixSender.php');
require_once('Mocks/MockSender.php');
use SmartyStreets\PhpSdk\Request;
use SmartyStreets\PhpSdk\Response;
use SmartyStreets\PhpSdk\URLPrefixSender;
use SmartyStreets\PhpSdk\Tests\Mocks\MockSender;
use PHPUnit\Framework\TestCase;

class URLPrefixSenderTest extends TestCase {
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