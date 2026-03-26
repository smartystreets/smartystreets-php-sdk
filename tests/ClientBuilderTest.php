<?php

namespace SmartyStreets\PhpSdk\Tests;

require_once(dirname(dirname(__FILE__)) . '/src/ClientBuilder.php');
require_once(dirname(dirname(__FILE__)) . '/src/StaticCredentials.php');
require_once(dirname(dirname(__FILE__)) . '/src/US_Street/Lookup.php');
require_once(dirname(__FILE__) . '/Mocks/RequestCapturingSender.php');

use SmartyStreets\PhpSdk\ClientBuilder;
use SmartyStreets\PhpSdk\StaticCredentials;
use SmartyStreets\PhpSdk\Tests\Mocks\RequestCapturingSender;
use PHPUnit\Framework\TestCase;

class ClientBuilderTest extends TestCase {

    public function testWithFeatureIANATimeZone() {
        $builder = new ClientBuilder();
        $builder->withFeatureIanaTimeZone();

        $this->assertEquals('iana-timezone', $this->getCustomQuery($builder)['features']);
    }

    public function testWithFeatureIANATimeZoneAndComponentAnalysis_ShouldAppend() {
        $builder = new ClientBuilder();
        $builder->withFeatureComponentAnalysis();
        $builder->withFeatureIanaTimeZone();

        $this->assertEquals('component-analysis,iana-timezone', $this->getCustomQuery($builder)['features']);
    }

    public function testWithWrappedSender_WrapsWithMiddlewareChain() {
        $capturingSender = new RequestCapturingSender();
        $credentials = new StaticCredentials('test-id', 'test-token');
        $client = (new ClientBuilder($credentials))
            ->withWrappedSender($capturingSender)
            ->buildUsStreetApiClient();

        $lookup = new \SmartyStreets\PhpSdk\US_Street\Lookup('1 Rosedale');
        $client->sendLookup($lookup);

        $url = $capturingSender->getRequest()->getUrl();
        $this->assertStringContainsString('us-street.api.smarty.com', $url);
        $this->assertStringContainsString('auth-id=test-id', $url);
        $this->assertStringContainsString('auth-token=test-token', $url);
    }

    private function getCustomQuery(ClientBuilder $builder) {
        $reflection = new \ReflectionClass($builder);
        $property = $reflection->getProperty('customQuery');
        $property->setAccessible(true);
        return $property->getValue($builder);
    }
}
