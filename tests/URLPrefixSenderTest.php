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
    public function testProvidedURLPresent() {
        $request = new Request();
        $fake_url_prefix = "/fake_address_id";
        $request->setUrlPrefix($fake_url_prefix); 
        $original_url_prefix = "http://mysite.com/lookup";

        $inner = new MockSender(new Response(123, null, ""));
        $sender = new URLPrefixSender($original_url_prefix, $inner);

        $sender->send($request);

        $this->assertEquals("http://mysite.com/lookup/fake_address_id?",$request->getUrl());
    }

    public function testProvidedURLNotPresent() {
        $request = new Request();
        $original_url_prefix = "http://mysite.com/lookup";

        $inner = new MockSender(new Response(123, null, ""));
        $sender = new URLPrefixSender($original_url_prefix, $inner);

        $sender->send($request);

        $this->assertEquals("http://mysite.com/lookup?", $request->getUrl());
    }
}