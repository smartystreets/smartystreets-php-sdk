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

class CustomHeaderTest extends TestCase {
    public function testNativeSetOnQuery() {
        $request = new Request();
        $sender = new NativeSender(10000, null, false, null, ["Header" => "Custom"]);

        $sender->send($request, '');

        $this->assertEquals("Custom", $request->getHeaders()["Header"]);
    }
}