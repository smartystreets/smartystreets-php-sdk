<?php

namespace SmartyStreets\PhpSdk\Tests;

require_once(dirname(dirname(__FILE__)) . '/src/Request.php');
require_once(dirname(dirname(__FILE__)) . '/src/NativeSender.php');
require_once(dirname(dirname(__FILE__)) . '/src/Exceptions/SmartyException.php');
require_once(dirname(dirname(__FILE__)) . '/src/ClientBuilder.php');
use SmartyStreets\PhpSdk\Request;
use SmartyStreets\PhpSdk\NativeSender;
use SmartyStreets\PhpSdk\ClientBuilder;
use SmartyStreets\PhpSdk\Exceptions\SmartyException;
use PHPUnit\Framework\TestCase;

class TestableSender extends NativeSender {
    public function exposeBuildUserAgent() {
        return $this->buildUserAgent();
    }
}

class CustomHeaderTest extends TestCase {
    public function testNativeSetOnQuery() {
        $request = new Request();
        $sender = new NativeSender(10000, null, false, null, ["Header" => "Custom"]);

        try {
        $sender->send($request);
        } catch (SmartyException $ex) {
        }

        $this->assertEquals("Custom", $request->getHeaders()["Header"]);
    }

    public function testAppendedHeadersAreNotSetAsRegularHeaders() {
        $request = new Request();
        $sender = new NativeSender(10000, null, false, null, ["User-Agent" => "custom-value"], ["User-Agent" => " "]);

        try {
            $sender->send($request);
        } catch (SmartyException $ex) {
        }

        $this->assertArrayNotHasKey("User-Agent", $request->getHeaders());
    }

    public function testRegularCustomHeadersStillSetWhenAppendedHeadersPresent() {
        $request = new Request();
        $sender = new NativeSender(10000, null, false, null, ["Header" => "Custom", "User-Agent" => "custom-value"], ["User-Agent" => " "]);

        try {
            $sender->send($request);
        } catch (SmartyException $ex) {
        }

        $this->assertEquals("Custom", $request->getHeaders()["Header"]);
        $this->assertArrayNotHasKey("User-Agent", $request->getHeaders());
    }

    public function testAppendedNonUserAgentHeaderAppendsToExistingValue() {
        $request = new Request();
        $request->setHeader('Accept', 'application/json');
        $sender = new NativeSender(10000, null, false, null, ["Accept" => "text/html"], ["Accept" => ", "]);

        try {
            $sender->send($request);
        } catch (SmartyException $ex) {
        }

        $this->assertEquals("application/json, text/html", $request->getHeaders()["Accept"]);
    }

    public function testAppendedHeaderIsCaseInsensitiveWithExistingHeader() {
        $request = new Request();
        $request->setHeader('Content-Type', 'application/json');
        $sender = new NativeSender(10000, null, false, null, ["content-type" => "text/html"], ["content-type" => ", "]);

        try {
            $sender->send($request);
        } catch (SmartyException $ex) {
        }

        $this->assertEquals("application/json, text/html", $request->getHeaders()["Content-Type"]);
        $this->assertArrayNotHasKey("content-type", $request->getHeaders());
    }

    public function testAppendedNonUserAgentHeaderSetsValueWhenNoExisting() {
        $request = new Request();
        $sender = new NativeSender(10000, null, false, null, ["X-Custom" => "value"], ["X-Custom" => "; "]);

        try {
            $sender->send($request);
        } catch (SmartyException $ex) {
        }

        $this->assertEquals("value", $request->getHeaders()["X-Custom"]);
    }

    public function testUserAgentContainsSDKVersionByDefault() {
        $sender = new TestableSender();
        $userAgent = $sender->exposeBuildUserAgent();

        $this->assertStringContainsString('smartystreets (sdk:php@', $userAgent);
    }

    public function testUserAgentAppendsCustomValueWithSeparator() {
        $sender = new TestableSender(10000, null, false, null, ["User-Agent" => "custom-app"], ["User-Agent" => " "]);
        $userAgent = $sender->exposeBuildUserAgent();

        $this->assertStringStartsWith('smartystreets (sdk:php@', $userAgent);
        $this->assertStringEndsWith(' custom-app', $userAgent);
    }

    public function testUserAgentUsesProvidedSeparator() {
        $sender = new TestableSender(10000, null, false, null, ["User-Agent" => "custom-app"], ["User-Agent" => " - "]);
        $userAgent = $sender->exposeBuildUserAgent();

        $this->assertStringContainsString(') - custom-app', $userAgent);
    }

    public function testUserAgentReplacedWhenNoAppendHeader() {
        $sender = new TestableSender(10000, null, false, null, ["User-Agent" => "custom-app"], []);
        $userAgent = $sender->exposeBuildUserAgent();

        $this->assertEquals('custom-app', $userAgent);
    }

    public function testWithCustomHeaderReplacesUserAgent() {
        $sender = new TestableSender(10000, null, false, null, ["User-Agent" => "my-app"], []);
        $userAgent = $sender->exposeBuildUserAgent();

        $this->assertEquals("my-app", $userAgent);
    }

    public function testWithCustomHeaderReplacesUserAgentCaseInsensitive() {
        $sender = new TestableSender(10000, null, false, null, ["user-agent" => "my-app"], []);
        $userAgent = $sender->exposeBuildUserAgent();

        $this->assertEquals("my-app", $userAgent);
    }

    public function testWithCustomHeaderAfterWithAppendedHeaderRemovesAppendBehavior() {
        $request = new Request();
        $request->setHeader('Accept', 'application/json');
        // Simulate calling withAppendedHeader then withCustomHeader on ClientBuilder:
        // withAppendedHeader sets both customHeaders and appendHeaders,
        // withCustomHeader should remove from appendHeaders, making it a replacement.
        $sender = new NativeSender(10000, null, false, null, ["Accept" => "text/html"], []);

        try {
            $sender->send($request);
        } catch (SmartyException $ex) {
        }

        // The header should be replaced, not appended
        $this->assertEquals("text/html", $request->getHeaders()["Accept"]);
    }

    public function testBuilderWithCustomHeaderAfterAppendedHeaderRemovesAppendBehavior() {
        $builder = new ClientBuilder();
        $builder->withAppendedHeader('Accept', 'text/html', ', ')
                ->withCustomHeader('Accept', 'text/plain');

        $reflection = new \ReflectionClass($builder);

        $appendHeaders = $reflection->getProperty('appendHeaders');
        $customHeaders = $reflection->getProperty('customHeaders');

        $this->assertEmpty($appendHeaders->getValue($builder));
        $this->assertEquals(['Accept' => 'text/plain'], $customHeaders->getValue($builder));
    }

    public function testBuilderWithAppendedHeaderAfterCustomHeaderAddsAppendBehavior() {
        $builder = new ClientBuilder();
        $builder->withCustomHeader('User-Agent', 'my-app')
                ->withAppendedHeader('User-Agent', 'my-app', ' ');

        $reflection = new \ReflectionClass($builder);

        $appendHeaders = $reflection->getProperty('appendHeaders');
        $customHeaders = $reflection->getProperty('customHeaders');

        $this->assertEquals(['User-Agent' => ' '], $appendHeaders->getValue($builder));
        $this->assertEquals(['User-Agent' => 'my-app'], $customHeaders->getValue($builder));
    }

    public function testBuilderWithCustomHeaderRemovesAppendCaseInsensitive() {
        $builder = new ClientBuilder();
        $builder->withAppendedHeader('user-agent', 'my-app', ' ')
                ->withCustomHeader('User-Agent', 'replacement');

        $reflection = new \ReflectionClass($builder);

        $appendHeaders = $reflection->getProperty('appendHeaders');

        $this->assertEmpty($appendHeaders->getValue($builder));
    }
}
