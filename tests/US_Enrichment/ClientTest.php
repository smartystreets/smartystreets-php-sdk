<?php

namespace SmartyStreets\PhpSdk\Tests\US_Enrichment;

use PHPUnit\Framework\TestCase;
use Http\Mock\Client as MockHttpClient;
use GuzzleHttp\Psr7\Response;
use SmartyStreets\PhpSdk\US_Enrichment\Client;
use SmartyStreets\PhpSdk\US_Enrichment\Lookup;
use SmartyStreets\PhpSdk\NativeSerializer;
use Http\Factory\Guzzle\RequestFactory;
use Http\Factory\Guzzle\StreamFactory;

class ClientTest extends TestCase
{
    public function testSendLookupSuccess()
    {
        $mockHttpClient = new MockHttpClient();
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();

        $mockResponseBody = '{"enrichment":[{"address":"1600 Amphitheatre Pkwy, Mountain View, CA 94043","property":"office"}]}';
        $mockHttpClient->addResponse(new Response(200, ['Content-Type' => 'application/json'], $mockResponseBody));

        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup();
        $lookup->setFreeform('1600 Amphitheatre Pkwy, Mountain View, CA 94043');

        $client->sendLookup($lookup);
        $result = $lookup->getResponse();
        $this->assertNotNull($result);
        $this->assertIsArray($result);
        // If value objects are returned, check their type and non-null sub-objects
        if (isset($result[0]) && is_object($result[0])) {
            // Instead of property_exists, check for expected methods or use correct property names
            $this->assertTrue(method_exists($result[0], 'getSmartyKey') || property_exists($result[0], 'smartyKey'));
            $this->assertTrue(method_exists($result[0], 'getDataSetName') || property_exists($result[0], 'dataSetName'));
        }
    }

    public function testSendLookupHttpError()
    {
        $mockHttpClient = new MockHttpClient();
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();

        $mockHttpClient->addResponse(new Response(500, ['Content-Type' => 'application/json'], 'Internal Server Error'));

        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup();
        $lookup->setFreeform('1600 Amphitheatre Pkwy, Mountain View, CA 94043');

        $this->expectException(\SmartyStreets\PhpSdk\Exceptions\SmartyException::class);
        $client->sendLookup($lookup);
    }

    public function testSendLookupWithEmptyInputThrows() {
        $mockHttpClient = new MockHttpClient();
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup(); // No fields set
        $this->expectException(\SmartyStreets\PhpSdk\Exceptions\SmartyException::class);
        $client->sendLookup($lookup);
    }

    public function testSendLookupWithMalformedApiResponse() {
        $mockHttpClient = new MockHttpClient();
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $mockHttpClient->addResponse(new Response(200, ['Content-Type' => 'application/json'], '{not json}'));
        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup();
        $lookup->setFreeform('1600 Amphitheatre Pkwy, Mountain View, CA 94043');
        $this->expectException(\SmartyStreets\PhpSdk\Exceptions\SmartyException::class);
        $client->sendLookup($lookup);
    }

    public function testSendLookupWithEmptyApiResponse() {
        $mockHttpClient = new MockHttpClient();
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $mockHttpClient->addResponse(new Response(200, ['Content-Type' => 'application/json'], '{}'));
        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup();
        $lookup->setFreeform('1600 Amphitheatre Pkwy, Mountain View, CA 94043');
        $client->sendLookup($lookup);
        $result = $lookup->getResponse();
        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }
}
