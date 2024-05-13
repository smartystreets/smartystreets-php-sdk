<?php

namespace SmartyStreets\PhpSdk\Tests;

require_once(dirname(dirname(__FILE__)) . '/src/Request.php');
require_once(dirname(dirname(__FILE__)) . '/src/Response.php');
require_once(dirname(dirname(__FILE__)) . '/src/NativeSender.php');
require_once(dirname(dirname(__FILE__)) . '/src/Proxy.php');
require_once('Mocks/MockSender.php');
use SmartyStreets\PhpSdk\Proxy;
use SmartyStreets\PhpSdk\Request;
use SmartyStreets\PhpSdk\Response;
use SmartyStreets\PhpSdk\NativeSender;
use SmartyStreets\PhpSdk\Tests\Mocks\MockSender;
use PHPUnit\Framework\TestCase;

class XForwardedForTest extends TestCase {
    public function testNativeSetOnQuery() {
        $request = new Request();
        //$licenses = ["one","two","three"];
        //$inner = new MockSender(new Response(123, null, ""));
        $sender = new NativeSender(10000, null, false, "0.0.0.0");

        $sender->send($request);

        $this->assertEquals("0.0.0.0", $request->getHeaders()["X_FORWARDED_FOR"]);
    }

    public function testNativeNotSet() {
        $request = new Request();
        //$inner = new MockSender(new Response(123, null, ""));
        $sender = new NativeSender();

        $sender->send($request);

        $this->assertEquals(null, $request->getHeaders()["X_FORWARDED_FOR"]);
    }
}