<?php

namespace SmartyStreets\PhpSdk\Tests;

require_once(dirname(dirname(__FILE__)) . '/src/Request.php');
require_once(dirname(dirname(__FILE__)) . '/src/SharedCredentials.php');
use SmartyStreets\PhpSdk\Request;
use SmartyStreets\PhpSdk\SharedCredentials;
use PHPUnit\Framework\TestCase;

class SharedCredentialsTest extends TestCase {
    public function testSignedRequest() {
        $request = $this->createSignedRequest();
        $expected = "https://us-street.api.smartystreets.com/street-address?key=3516378604772256";

        $this->assertEquals($expected, $request->getUrl());
    }

    public function testReferringHeader() {
        $request = $this->createSignedRequest();

        $this->assertEquals("referer:https://example.com", $request->getHeaders()["Referer"]);
    }

    private function createSignedRequest() {
        $mobile = new SharedCredentials("3516378604772256", "example.com");
        $request = new Request();
        $request->setUrlPrefix("https://us-street.api.smartystreets.com/street-address?");

        $mobile->sign($request);
        return $request;
    }

}
