<?php

namespace SmartyStreets\PhpSdk\Tests\US_Reverse_Geo;

use PHPUnit\Framework\TestCase;
use SmartyStreets\PhpSdk\Tests\Mocks\MockSender;
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
        $mockResponse = new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], '{"results":[{"coordinate":{"latitude":37.4224764,"longitude":-122.0842499},"address":{"street":"1600 Amphitheatre Pkwy","city":"Mountain View","state_abbreviation":"CA","zipcode":"94043"}}]}');
        $mockHttpClient = new MockSender($mockResponse);
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();

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
        $mockResponse = new \GuzzleHttp\Psr7\Response(500, ['Content-Type' => 'application/json'], 'Internal Server Error');
        $mockHttpClient = new MockSender($mockResponse);
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();

        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup(37.4224764, -122.0842499);

        $this->expectException(\SmartyStreets\PhpSdk\Exceptions\SmartyException::class);
        $client->sendLookup($lookup);
    }

    public function testSendLookupWithEmptyInputThrows() {
        $mockResponse = new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], '{}');
        $mockHttpClient = new MockSender($mockResponse);
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup(null, null); // No lat/lon
        $this->expectException(\SmartyStreets\PhpSdk\Exceptions\SmartyException::class);
        $client->sendLookup($lookup);
    }

    public function testSendLookupWithMalformedApiResponse() {
        $mockResponse = new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], '{not json}');
        $mockHttpClient = new MockSender($mockResponse);
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup(37.4224764, -122.0842499);
        $this->expectException(\SmartyStreets\PhpSdk\Exceptions\SmartyException::class);
        $client->sendLookup($lookup);
    }

    public function testSendLookupWithEmptyApiResponse() {
        $mockResponse = new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], '{}');
        $mockHttpClient = new MockSender($mockResponse);
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
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
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        // Valid and invalid boundaries (all should not throw, just return empty results)
        $cases = [
            [-90, -180],
            [-90, 180],
            [90, -180],
            [90, 180],
            [0, 0],
            [-90.0001, 0],
            [90.0001, 0],
            [0, -180.0001],
            [0, 180.0001],
            ['foo', 'bar'],
        ];
        foreach ($cases as [$lat, $lon]) {
            $mockHttpClient = new MockSender(new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], '{"results":[]}'));
            $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
            $lookup = new Lookup($lat, $lon);
            $client->sendLookup($lookup);
            $result = $lookup->getResponse();
            $this->assertNotNull($result);
        }
        // Only null lat/lon should throw
        $mockHttpClient = new MockSender(new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], '{"results":[]}'));
        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup(null, null);
        $this->expectException(\SmartyStreets\PhpSdk\Exceptions\SmartyException::class);
        $client->sendLookup($lookup);
    }

    public function testSendLookupWithMissingKeysInApiResponse() {
        $mockResponse = new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], '{"unexpected":"value"}');
        $mockHttpClient = new MockSender($mockResponse);
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup(0, 0);
        $client->sendLookup($lookup);
        $result = $lookup->getResponse();
        $this->assertNotNull($result);
    }

    public function testSendLookupHttpClientThrows() {
        $mockHttpClient = new class implements \Psr\Http\Client\ClientInterface {
            public function sendRequest(\Psr\Http\Message\RequestInterface $request): \Psr\Http\Message\ResponseInterface {
                throw new \Exception('network fail');
            }
        };
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup(0, 0);
        $this->expectException(\Exception::class);
        $client->sendLookup($lookup);
    }

    public function testSendLookupWithUnicodeEmoji() {
        $mockHttpClient = new MockSender(new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], '{}'));
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup('東京', '🗹');
        $client->sendLookup($lookup);
        $response = $lookup->getResponse();
        $this->assertNotNull($response);
        $results = $response->getResults();
        // Accepts null or empty array as valid for no results
        if ($results === null) {
            $this->assertNull($results);
        } else {
            $this->assertIsArray($results);
            $this->assertEmpty($results);
        }
    }

    public function testResultObjectStructureNulls() {
        $result = new \SmartyStreets\PhpSdk\US_Reverse_Geo\Result([]);
        $this->assertNull($result->getAddress());
        $this->assertNull($result->getCoordinate());
    }
}
