<?php

namespace SmartyStreets\PhpSdk\Tests;

require_once(dirname(dirname(__FILE__)) . '/src/ClientBuilder.php');
require_once(dirname(dirname(__FILE__)) . '/src/StaticCredentials.php');
require_once(dirname(dirname(__FILE__)) . '/src/US_Street/Lookup.php');
require_once('Mocks/RequestCapturingSender.php');
use SmartyStreets\PhpSdk\ClientBuilder;
use SmartyStreets\PhpSdk\StaticCredentials;
use SmartyStreets\PhpSdk\Tests\Mocks\RequestCapturingSender;
use PHPUnit\Framework\TestCase;

class XForwardedForTest extends TestCase {
    public function testXForwardedForHeaderSetViaClientBuilder() {
        $capturingSender = new RequestCapturingSender();
        $credentials = new StaticCredentials('test-id', 'test-token');
        $client = (new ClientBuilder($credentials))
            ->withXForwardedFor('0.0.0.0')
            ->withSender($capturingSender)
            ->buildUsStreetApiClient();

        $lookup = new \SmartyStreets\PhpSdk\US_Street\Lookup('1 Rosedale');
        $client->sendLookup($lookup);

        $this->assertEquals('0.0.0.0', $capturingSender->getRequest()->getHeaders()['X-Forwarded-For']);
    }

    public function testXForwardedForNotSetWhenNotConfigured() {
        $capturingSender = new RequestCapturingSender();
        $credentials = new StaticCredentials('test-id', 'test-token');
        $client = (new ClientBuilder($credentials))
            ->withSender($capturingSender)
            ->buildUsStreetApiClient();

        $lookup = new \SmartyStreets\PhpSdk\US_Street\Lookup('1 Rosedale');
        $client->sendLookup($lookup);

        $this->assertArrayNotHasKey('X-Forwarded-For', $capturingSender->getRequest()->getHeaders());
    }

    public function testXForwardedForCombinedWithCustomHeaders() {
        $capturingSender = new RequestCapturingSender();
        $credentials = new StaticCredentials('test-id', 'test-token');
        $client = (new ClientBuilder($credentials))
            ->withXForwardedFor('0.0.0.0')
            ->withCustomHeader('X-Custom', 'value')
            ->withSender($capturingSender)
            ->buildUsStreetApiClient();

        $lookup = new \SmartyStreets\PhpSdk\US_Street\Lookup('1 Rosedale');
        $client->sendLookup($lookup);

        $this->assertEquals('0.0.0.0', $capturingSender->getRequest()->getHeaders()['X-Forwarded-For']);
        $this->assertEquals('value', $capturingSender->getRequest()->getHeaders()['X-Custom']);
    }
}
