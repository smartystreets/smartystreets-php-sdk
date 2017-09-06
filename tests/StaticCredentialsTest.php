<?php

namespace SmartyStreets\PhpSdk\Tests;

require_once(dirname(dirname(__FILE__)) . '/src/Request.php');
require_once(dirname(dirname(__FILE__)) . '/src/StaticCredentials.php');
use SmartyStreets\PhpSdk\Request;
use SmartyStreets\PhpSdk\StaticCredentials;
use PHPUnit\Framework\TestCase;

class StaticCredentialsTest extends TestCase {
    public function testStandardCredentials() {
        $this->assertSignedRequest("f83280df-s83d-f82j-d829-kd02l9tis7ek", "S9Djk63k2Ilj67vN82Km",
            "https://us-street.api.smartystreets.com/street-address?auth-id=f83280df-s83d-f82j-d829-kd02l9tis7ek&auth-token=S9Djk63k2Ilj67vN82Km");
    }

    public function testUrlEncoding() {
        $this->assertSignedRequest("as3\$d8+56d9", "d8j#ds'dfe2",
            "https://us-street.api.smartystreets.com/street-address?auth-id=as3%24d8%2B56d9&auth-token=d8j%23ds%27dfe2");
    }

    private function assertSignedRequest($id, $secret, $expected) {
        $credentials = new StaticCredentials($id, $secret);
        $request = new Request();
        $request->setUrlPrefix("https://us-street.api.smartystreets.com/street-address?");

        $credentials->sign($request);

        $this->assertEquals($expected, $request->getUrl());
    }
}
