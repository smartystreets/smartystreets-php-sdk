<?php

namespace SmartyStreets\PhpSdk\Tests;

require_once(dirname(dirname(__FILE__)) . '/src/Request.php');
require_once(dirname(dirname(__FILE__)) . '/src/Response.php');
require_once(dirname(dirname(__FILE__)) . '/src/NativeSender.php');
require_once(dirname(dirname(__FILE__)) . '/src/Proxy.php');
require_once('Mocks/MockSender.php');
use SmartyStreets\PhpSdk\Proxy;
use SmartyStreets\PhpSdk\Response;
use SmartyStreets\PhpSdk\NativeSender;
use SmartyStreets\PhpSdk\Tests\Mocks\MockSender;
use GuzzleHttp\Psr7\Request;
use PHPUnit\Framework\TestCase;

class XForwardedForTest extends TestCase {
    public function testNativeSetOnQuery() {
        $request = new Request('GET', 'https://example.com/');
        $requestWithHeader = $request->withHeader('X-Forwarded-For', '0.0.0.0');
        $this->assertEquals('0.0.0.0', $requestWithHeader->getHeaderLine('X-Forwarded-For'));
    }

    public function testNativeNotSet() {
        $request = new Request('GET', 'https://example.com/');
        $this->assertFalse($request->hasHeader('X-Forwarded-For'));
    }
}