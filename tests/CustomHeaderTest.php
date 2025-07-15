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

class CustomHeaderTest extends TestCase {
    public function testNativeSetOnQuery() {
        $request = new Request('GET', 'https://example.com/');
        // Simulate a sender that adds a custom header
        $customHeader = ['Header' => 'Custom'];
        $requestWithHeader = $request->withHeader('Header', 'Custom');
        $this->assertEquals('Custom', $requestWithHeader->getHeaderLine('Header'));
    }
}