<?php

namespace SmartyStreets\PhpSdk\Tests;

require_once(dirname(dirname(__FILE__)) . '/src/Request.php');
require_once(dirname(dirname(__FILE__)) . '/src/CustomHeaderSender.php');
require_once(dirname(dirname(__FILE__)) . '/src/ClientBuilder.php');
require_once('Mocks/RequestCapturingSender.php');
use SmartyStreets\PhpSdk\Request;
use SmartyStreets\PhpSdk\CustomHeaderSender;
use SmartyStreets\PhpSdk\ClientBuilder;
use SmartyStreets\PhpSdk\Tests\Mocks\RequestCapturingSender;
use PHPUnit\Framework\TestCase;

class CustomHeaderTest extends TestCase {
    public function testCustomHeaderSenderSetsHeader() {
        $request = new Request();
        $inner = new RequestCapturingSender();
        $sender = new CustomHeaderSender(['Header' => 'Custom'], $inner);

        $sender->send($request);

        $this->assertEquals('Custom', $inner->getRequest()->getHeaders()['Header']);
    }

    public function testAppendedNonUserAgentHeaderAppendsToExistingValue() {
        $request = new Request();
        $request->setHeader('Accept', 'application/json');
        $inner = new RequestCapturingSender();
        $sender = new CustomHeaderSender(['Accept' => 'text/html'], $inner, ['Accept' => ', ']);

        $sender->send($request);

        $this->assertEquals('application/json, text/html', $inner->getRequest()->getHeaders()['Accept']);
    }

    public function testAppendedHeaderIsCaseInsensitiveWithExistingHeader() {
        $request = new Request();
        $request->setHeader('Content-Type', 'application/json');
        $inner = new RequestCapturingSender();
        $sender = new CustomHeaderSender(['content-type' => 'text/html'], $inner, ['content-type' => ', ']);

        $sender->send($request);

        $this->assertEquals('application/json, text/html', $inner->getRequest()->getHeaders()['Content-Type']);
        $this->assertArrayNotHasKey('content-type', $inner->getRequest()->getHeaders());
    }

    public function testAppendedNonUserAgentHeaderSetsValueWhenNoExisting() {
        $request = new Request();
        $inner = new RequestCapturingSender();
        $sender = new CustomHeaderSender(['X-Custom' => 'value'], $inner, ['X-Custom' => '; ']);

        $sender->send($request);

        $this->assertEquals('value', $inner->getRequest()->getHeaders()['X-Custom']);
    }

    public function testUserAgentSetWhenSpecifiedAsCustomHeader() {
        $request = new Request();
        $inner = new RequestCapturingSender();
        $sender = new CustomHeaderSender(['User-Agent' => 'custom-app'], $inner);

        $sender->send($request);

        $this->assertEquals('custom-app', $inner->getRequest()->getHeaders()['User-Agent']);
    }

    public function testUserAgentCaseInsensitiveReplacement() {
        $request = new Request();
        $inner = new RequestCapturingSender();
        $sender = new CustomHeaderSender(['user-agent' => 'custom-app'], $inner);

        $sender->send($request);

        $this->assertEquals('custom-app', $inner->getRequest()->getHeaders()['user-agent']);
    }

    public function testAppendedUserAgentAppendsToExistingRequestUserAgent() {
        $request = new Request();
        $request->setHeader('User-Agent', 'existing-agent');
        $inner = new RequestCapturingSender();
        $sender = new CustomHeaderSender(['User-Agent' => 'custom-app'], $inner, ['User-Agent' => ' ']);

        $sender->send($request);

        $this->assertEquals('existing-agent custom-app', $inner->getRequest()->getHeaders()['User-Agent']);
    }

    public function testAppendedUserAgentSetsValueWhenNoExistingUserAgent() {
        $request = new Request();
        $inner = new RequestCapturingSender();
        $sender = new CustomHeaderSender(['User-Agent' => 'custom-app'], $inner, ['User-Agent' => ' ']);

        $sender->send($request);

        $this->assertEquals('custom-app', $inner->getRequest()->getHeaders()['User-Agent']);
    }

    public function testRegularCustomHeadersSetAlongsideUserAgent() {
        $request = new Request();
        $inner = new RequestCapturingSender();
        $sender = new CustomHeaderSender(['Header' => 'Custom', 'User-Agent' => 'custom-app'], $inner, ['User-Agent' => ' ']);

        $sender->send($request);

        $this->assertEquals('Custom', $inner->getRequest()->getHeaders()['Header']);
        $this->assertEquals('custom-app', $inner->getRequest()->getHeaders()['User-Agent']);
    }

    public function testAppendHeaderAfterCustomHeaderReplacesValue() {
        $request = new Request();
        $request->setHeader('Accept', 'application/json');
        $inner = new RequestCapturingSender();
        // No append entry for Accept — should replace
        $sender = new CustomHeaderSender(['Accept' => 'text/html'], $inner, []);

        $sender->send($request);

        $this->assertEquals('text/html', $inner->getRequest()->getHeaders()['Accept']);
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
