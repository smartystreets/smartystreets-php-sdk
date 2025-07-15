<?php

namespace SmartyStreets\PhpSdk\Tests;

require_once(dirname(dirname(__FILE__)) . '/src/Request.php');
use GuzzleHttp\Psr7\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase {
    public function testQueryStringParameterAddition() {
        $request = new Request('GET', 'http://localhost/');
        $uri = $request->getUri()->withQuery('name=value');
        $request = $request->withUri($uri);
        $this->assertEquals('http://localhost/?name=value', (string)$request->getUri());
    }

    public function testQueryStringParameterEncoding() {
        $request = new Request('GET', 'http://localhost/');
        $uri = $request->getUri()->withQuery('name%26=value&name1=other+%21value%24');
        $request = $request->withUri($uri);
        $this->assertEquals('http://localhost/?name%26=value&name1=other+%21value%24', (string)$request->getUri());
    }

    public function testHeaderAddition() {
        $request = new Request('GET', 'http://localhost/');
        $request = $request->withHeader('header1', 'value1')->withHeader('header2', 'value2');
        $this->assertEquals('value1', $request->getHeaderLine('header1'));
        $this->assertEquals('value2', $request->getHeaderLine('header2'));
    }

    public function testBodyPayload() {
        $body = 'bytes';
        $request = new Request('POST', 'http://localhost/', [], $body);
        $this->assertEquals($body, (string)$request->getBody());
    }
}
