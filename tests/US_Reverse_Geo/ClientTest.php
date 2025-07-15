<?php

namespace SmartyStreets\PhpSdk\Tests\US_Reverse_Geo;

use PHPUnit\Framework\TestCase;
use Http\Mock\Client as MockHttpClient;
use GuzzleHttp\Psr7\Response;
use SmartyStreets\PhpSdk\US_Reverse_Geo\Client;
use SmartyStreets\PhpSdk\US_Reverse_Geo\Lookup;
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

        $mockResponseBody = '{"results":[{"coordinate":{"latitude":37.4224764,"longitude":-122.0842499},"address":{"street":"1600 Amphitheatre Pkwy","city":"Mountain View","state_abbreviation":"CA","zipcode":"94043"}}]}';
        $mockHttpClient->addResponse(new Response(200, ['Content-Type' => 'application/json'], $mockResponseBody));

        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup(37.4224764, -122.0842499);

        $client->sendLookup($lookup);
        $result = $lookup->getResponse();
        $this->assertNotNull($result);
        $results = $result->getResults();
        $this->assertIsArray($results);
        $this->assertEquals(37.4224764, $results[0]->getCoordinate()->getLatitude());
        $this->assertEquals(-122.0842499, $results[0]->getCoordinate()->getLongitude());
        $this->assertEquals('1600 Amphitheatre Pkwy', $results[0]->getAddress()->getStreet());
    }

    public function testSendLookupHttpError()
    {
        $mockHttpClient = new MockHttpClient();
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();

        $mockHttpClient->addResponse(new Response(500, ['Content-Type' => 'application/json'], 'Internal Server Error'));

        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup(37.4224764, -122.0842499);

        $this->expectException(\SmartyStreets\PhpSdk\Exceptions\SmartyException::class);
        $client->sendLookup($lookup);
    }

    public function testSendLookupWithEmptyInputThrows() {
        $mockHttpClient = new MockHttpClient();
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup(null, null); // No lat/lon
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
        $lookup = new Lookup(37.4224764, -122.0842499);
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
        $lookup = new Lookup(37.4224764, -122.0842499);
        $client->sendLookup($lookup);
        $result = $lookup->getResponse();
        $this->assertNotNull($result);
        $results = $result->getResults();
        if ($results === null) {
            $this->assertNull($results);
        } else {
            $this->assertIsArray($results);
            $this->assertEmpty($results);
        }
    }

    public function testSendLookupWithLatLonBoundaries() {
        $mockHttpClient = new MockHttpClient();
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        // Valid boundaries
        $valids = [
            [-90, -180],
            [-90, 180],
            [90, -180],
            [90, 180],
            [0, 0],
        ];
        foreach ($valids as [$lat, $lon]) {
            $mockHttpClient->addResponse(new Response(200, ['Content-Type' => 'application/json'], '{"results":[]}'));
            $lookup = new Lookup($lat, $lon);
            $client->sendLookup($lookup);
            $result = $lookup->getResponse();
            $this->assertNotNull($result);
        }
        // Just outside valid boundaries
        $invalids = [
            [-90.0001, 0],
            [90.0001, 0],
            [0, -180.0001],
            [0, 180.0001],
        ];
        foreach ($invalids as [$lat, $lon]) {
            $lookup = new Lookup($lat, $lon);
            $this->expectException(\SmartyStreets\PhpSdk\Exceptions\SmartyException::class);
            $client->sendLookup($lookup);
        }
    }
}
