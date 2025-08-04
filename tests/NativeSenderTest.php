<?php

// namespace SmartyStreets\PhpSdk\Tests\US_ZIPCode;

require_once(dirname(dirname(__FILE__)) . '/src/NativeSender.php');
require_once(dirname(dirname(__FILE__)) . '/src/Request.php');
require_once(__DIR__ . '/../src/Exceptions/SmartyException.php');
use SmartyStreets\PhpSdk\NativeSender;
use SmartyStreets\PhpSdk\Exceptions\SmartyException;
use SmartyStreets\PhpSdk\Request;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Group;

class NativeSenderTest extends TestCase {

    #[Group('integration')]
    public function testBuildRequestHeaders() {
        $request = new Request();
        $request->setUrlPrefix("http://localhost:8080");
        $customHeaders = [
            'vegetable' => 'carrot',
            'fruit' => 'banana'
        ];

        $nativeSender = new NativeSender(10000, null, false, "rivers", $customHeaders);

        $refClass = new ReflectionClass($nativeSender);
        $buildRequestMethod = $refClass->getMethod('buildRequest');
        $buildRequestMethod->setAccessible(true);

        $ch = $buildRequestMethod->invoke($nativeSender, $request);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);

        curl_exec($ch);
        $requestHeaders = curl_getinfo($ch, CURLINFO_HEADER_OUT);
        curl_close($ch);

        $this->assertNotFalse($requestHeaders);
        $this->assertStringContainsString("vegetable: carrot", $requestHeaders);
        $this->assertStringContainsString("fruit: banana", $requestHeaders);
        $this->assertStringContainsString("X-Forwarded-For: rivers", $requestHeaders);
        $this->assertStringContainsString("User-Agent: smartystreets", $requestHeaders);
        $this->assertStringContainsString("Content-Type: application/json", $requestHeaders);
        $this->assertStringContainsString("Accept-Encoding: gzip", $requestHeaders);
    }

    #[Group('integration')]
    public function testBadStatusCode() {
        $request = new Request();
        $request->setUrlPrefix("http://localhost:8080/EchoServer.php?status=402");

        $nativeSender = new NativeSender(10000, null, false);

        $response = $nativeSender->send($request);
        $status = $response->getStatusCode();
        $this->assertEquals("402", $status);
    }

    #[Group('integration')]
    public function testBadURL() {
        $this->expectException(SmartyException::class);
        $request = new Request();
        $request->setUrlPrefix("http://badserver");

        $nativeSender = new NativeSender(10000, null, false);

        $response = $nativeSender->send($request);
    }

    #[Group('integration')]
    public function testGoodResponse() {
        $request = new Request();
        $request->setUrlPrefix("http://localhost:8080/EchoServer.php");

        $nativeSender = new NativeSender(10000, null, false);

        $response = $nativeSender->send($request);
        $status = $response->getStatusCode();
        $this->assertEquals("200", $status);
        $expectedBody = <<<EOD
        {
            "message": "This is a sample message."
        }
        EOD;
        $this->assertEquals($expectedBody, $response->getPayload());
        $this->assertEquals(5, count($response->getHeaders()));
    }
}