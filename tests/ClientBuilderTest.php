<?php

namespace SmartyStreets\PhpSdk\Tests;

require_once(dirname(dirname(__FILE__)) . '/src/ClientBuilder.php');

use SmartyStreets\PhpSdk\ClientBuilder;
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

    private function getCustomQuery(ClientBuilder $builder) {
        $reflection = new \ReflectionClass($builder);
        $property = $reflection->getProperty('customQuery');
        $property->setAccessible(true);
        return $property->getValue($builder);
    }
}
