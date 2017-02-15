<?php

namespace SmartyStreets\Tests;

require_once(dirname(dirname(__FILE__)) . '/src/Request.php');
require_once(dirname(dirname(__FILE__)) . '/src/SharedCredentials.php');
use SmartyStreets\Request;
use SmartyStreets\SharedCredentials;

class SharedCredentialsTest extends \PHPUnit_Framework_TestCase {
    public function testSignedRequest() {
        $request = $this->createSignedRequest();
        $expected = "https://us-street.api.smartystreets.com/street-address?auth-id=3516378604772256";

        $this->assertEquals($expected, $request->getUrl());
    }

    public function testReferringHeader() {
        $request = $this->createSignedRequest();

        $this->assertEquals("https://example.com", $request->getHeaders()["Referer"]);
    }

    private function createSignedRequest() {
        $mobile = new SharedCredentials("3516378604772256", "example.com");
        $request = new Request();
        $request->setUrlPrefix("https://us-street.api.smartystreets.com/street-address?");

        $mobile->sign($request);
        return $request;
    }

}
