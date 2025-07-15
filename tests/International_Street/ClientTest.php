<?php

namespace SmartyStreets\PhpSdk\Tests\International_Street;

use PHPUnit\Framework\TestCase;
use Http\Mock\Client as MockHttpClient;
use GuzzleHttp\Psr7\Response;
use SmartyStreets\PhpSdk\International_Street\Client;
use SmartyStreets\PhpSdk\International_Street\Lookup;
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

        $mockResponseBody = '[{"address1":"10 Downing St","components":{"locality":"London","country_iso_3":"GBR"}}]';
        $mockHttpClient->addResponse(new Response(200, ['Content-Type' => 'application/json'], $mockResponseBody));

        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup();
        $lookup->setCountry('GB');
        $lookup->setFreeform('10 Downing St, London');

        $client->sendLookup($lookup);
        $results = $lookup->getResult();
        $this->assertNotNull($results);
        $this->assertIsArray($results);
        $this->assertEquals('10 Downing St', $results[0]->getAddress1());
        $this->assertEquals('London', $results[0]->getComponents()->getLocality());
        $this->assertEquals('GBR', $results[0]->getComponents()->getCountryIso3());
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
        $lookup->setCountry('GB');
        $lookup->setFreeform('10 Downing St, London');

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
        $lookup->setCountry('GB');
        $lookup->setFreeform('10 Downing St, London');
        $this->expectException(\SmartyStreets\PhpSdk\Exceptions\SmartyException::class);
        $client->sendLookup($lookup);
    }

    public function testSendLookupWithEmptyApiResponse() {
        $mockHttpClient = new MockHttpClient();
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $mockHttpClient->addResponse(new Response(200, ['Content-Type' => 'application/json'], '[]'));
        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup();
        $lookup->setCountry('GB');
        $lookup->setFreeform('10 Downing St, London');
        $client->sendLookup($lookup);
        $results = $lookup->getResult();
        $this->assertIsArray($results);
        $this->assertEmpty($results);
    }
}
