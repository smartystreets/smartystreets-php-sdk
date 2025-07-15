<?php

namespace SmartyStreets\PhpSdk\Tests;

require_once(dirname(dirname(__FILE__)) . '/src/Request.php');
require_once(dirname(dirname(__FILE__)) . '/src/Response.php');
require_once(dirname(dirname(__FILE__)) . '/src/URLPrefixSender.php');
require_once('Mocks/MockSender.php');
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;
use SmartyStreets\PhpSdk\URLPrefixSender;
use SmartyStreets\PhpSdk\Tests\Mocks\MockSender;
use PHPUnit\Framework\TestCase;

class URLPrefixSenderTest extends TestCase {
    public function testProvidedURLPresent() {
        $request = new Request('GET', '/fake_address_id');
        $original_url_prefix = "http://mysite.com/lookup";
        $inner = new MockSender(new \GuzzleHttp\Psr7\Response(123));
        $sender = new URLPrefixSender($original_url_prefix, $inner);
        $sender->sendRequest($request);
        $sentRequest = $inner->getRequest();
        $this->assertEquals("http://mysite.com/lookup/fake_address_id", (string)$sentRequest->getUri());
    }

    public function testProvidedURLNotPresent() {
        $request = new Request('GET', '/');
        $original_url_prefix = "http://mysite.com/lookup";
        $inner = new MockSender(new \GuzzleHttp\Psr7\Response(123));
        $sender = new URLPrefixSender($original_url_prefix, $inner);
        $sender->sendRequest($request);
        $sentRequest = $inner->getRequest();
        $this->assertEquals("http://mysite.com/lookup/", (string)$sentRequest->getUri());
    }

    public function testMultipleSends() {
        $request = new Request('GET', '/fake_address_id');
        $original_url_prefix = "http://mysite.com/lookup";
        $inner = new MockSender(new \GuzzleHttp\Psr7\Response(123));
        $sender = new URLPrefixSender($original_url_prefix, $inner);
        $sender->sendRequest($request);
        $sender->sendRequest($request);
        $sentRequest = $inner->getRequest();
        $this->assertEquals("http://mysite.com/lookup/fake_address_id", (string)$sentRequest->getUri());
    }

    public function testAbsoluteUriNotPrefixed() {
        $request = new Request('GET', 'https://external.com/path');
        $original_url_prefix = "http://mysite.com/lookup";
        $inner = new MockSender(new \GuzzleHttp\Psr7\Response(200));
        $sender = new URLPrefixSender($original_url_prefix, $inner);
        $sender->sendRequest($request);
        $sentRequest = $inner->getRequest();
        $this->assertEquals("https://external.com/path", (string)$sentRequest->getUri());
    }

    public function testQueryStringIsPreserved() {
        $request = new Request('GET', '/foo?bar=baz');
        $original_url_prefix = "http://mysite.com/lookup/";
        $inner = new MockSender(new \GuzzleHttp\Psr7\Response(200));
        $sender = new URLPrefixSender($original_url_prefix, $inner);
        $sender->sendRequest($request);
        $sentRequest = $inner->getRequest();
        $this->assertEquals("http://mysite.com/lookup/foo?bar=baz", (string)$sentRequest->getUri());
    }

    public function testPrefixAndPathEdgeCases() {
        $cases = [
            ["http://mysite.com/lookup/", "/foo", "http://mysite.com/lookup/foo"],
            ["http://mysite.com/lookup", "foo", "http://mysite.com/lookup/foo"],
            ["http://mysite.com/lookup/", "foo", "http://mysite.com/lookup/foo"],
            ["http://mysite.com/lookup", "/foo", "http://mysite.com/lookup/foo"],
        ];
        foreach ($cases as [$prefix, $path, $expected]) {
            $request = new Request('GET', $path);
            $inner = new MockSender(new \GuzzleHttp\Psr7\Response(200));
            $sender = new URLPrefixSender($prefix, $inner);
            $sender->sendRequest($request);
            $sentRequest = $inner->getRequest();
            $this->assertEquals($expected, (string)$sentRequest->getUri());
        }
    }
}