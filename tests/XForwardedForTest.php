<?php

namespace SmartyStreets\PhpSdk\Tests;

require_once(dirname(dirname(__FILE__)) . '/src/Request.php');
require_once(dirname(dirname(__FILE__)) . '/src/Response.php');
require_once(dirname(dirname(__FILE__)) . '/src/NativeSender.php');
require_once(dirname(dirname(__FILE__)) . '/src/Proxy.php');
require_once(dirname(dirname(__FILE__)) . '/src/Exceptions/SmartyException.php');
require_once('Mocks/MockSender.php');
use SmartyStreets\PhpSdk\Proxy;
use SmartyStreets\PhpSdk\Request;
use SmartyStreets\PhpSdk\Response;
use SmartyStreets\PhpSdk\NativeSender;
use SmartyStreets\PhpSdk\Tests\Mocks\MockSender;
use SmartyStreets\PhpSdk\Exceptions\SmartyException;
use PHPUnit\Framework\TestCase;

class XForwardedForTest extends TestCase {
    public function testNativeSetOnQuery() {
        $request = new Request();
        //$licenses = ["one","two","three"];
        //$inner = new MockSender(new Response(123, null, ""));
        $sender = new NativeSender(10000, null, false, "0.0.0.0");

        try {
            $sender->send($request);
        } catch (SmartyException $ex) {
        }
        $this->assertEquals("0.0.0.0", $request->getHeaders()["X-Forwarded-For"]);
    }

    public function testNativeNotSet() {
        $request = new Request();
        //$inner = new MockSender(new Response(123, null, ""));
        $sender = new NativeSender();

        try {
            $sender->send($request);
        } catch (SmartyException $ex) {
        }
        $headers = $request->getHeaders();

        $this->assertEquals(false, array_key_exists("X-Forwarded-For", $headers));
    }
}