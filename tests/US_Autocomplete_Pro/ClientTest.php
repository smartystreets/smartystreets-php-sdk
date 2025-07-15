<?php

namespace SmartyStreets\PhpSdk\Tests\US_Autocomplete_Pro;

use PHPUnit\Framework\TestCase;
use SmartyStreets\PhpSdk\Tests\Mocks\MockSender;
use GuzzleHttp\Psr7\Response;
use SmartyStreets\PhpSdk\US_Autocomplete_Pro\Client;
use SmartyStreets\PhpSdk\US_Autocomplete_Pro\Lookup;
use SmartyStreets\PhpSdk\NativeSerializer;
use Http\Factory\Guzzle\RequestFactory;
use Http\Factory\Guzzle\StreamFactory;

class ClientTest extends TestCase
{
    public function testSendLookupSuccess()
    {
        $mockResponse = new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], '{"suggestions":[{"street_line":"1600 Amphitheatre Pkwy","city":"Mountain View","state":"CA"}]}');
        $mockHttpClient = new MockSender($mockResponse);
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();

        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup();
        $lookup->setSearch('1600 Amphitheatre');
        $lookup->setMaxResults(5);

        $client->sendLookup($lookup);
        $result = $lookup->getResult();
        $this->assertNotNull($result);
        $suggestions = $result->getSuggestions();
        $this->assertIsArray($suggestions);
        $this->assertEquals('1600 Amphitheatre Pkwy', $suggestions[0]->getStreetLine());
        $this->assertEquals('Mountain View', $suggestions[0]->getCity());
        $this->assertEquals('CA', $suggestions[0]->getState());
    }

    public function testSendLookupHttpError()
    {
        $mockResponse = new \GuzzleHttp\Psr7\Response(500, ['Content-Type' => 'application/json'], 'Internal Server Error');
        $mockHttpClient = new MockSender($mockResponse);
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();

        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup();
        $lookup->setSearch('1600 Amphitheatre');
        $lookup->setMaxResults(5);

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
        $lookup = new Lookup(); // No fields set
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
        $lookup = new Lookup();
        $lookup->setSearch('1600 Amphitheatre');
        $lookup->setMaxResults(5);
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
        $lookup = new Lookup();
        $lookup->setSearch('1600 Amphitheatre');
        $lookup->setMaxResults(5);
        $client->sendLookup($lookup);
        $result = $lookup->getResult();
        $suggestions = $result->getSuggestions();
        if ($suggestions === null) {
            $this->assertNull($suggestions);
        } else {
            $this->assertIsArray($suggestions);
            $this->assertEmpty($suggestions);
        }
    }

    public function testSendLookupWithInvalidMaxResultsThrows() {
        $mockResponse = new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], '{}');
        $mockHttpClient = new MockSender($mockResponse);
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup();
        $lookup->setSearch('test');
        $this->expectException(\InvalidArgumentException::class);
        $lookup->setMaxResults(20); // Invalid, should throw
        // $client->sendLookup($lookup); // Not needed, exception is thrown above
    }

    public function testSendLookupWithGeolocationPreference() {
        $mockResponse = new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], '{"suggestions":[{"street_line":"1 Test St","city":"Testville","state":"TS"}]}');
        $mockHttpClient = new MockSender($mockResponse);
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup();
        $lookup->setSearch('1 Test');
        $lookup->setPreferGeolocation(new \SmartyStreets\PhpSdk\US_Autocomplete_Pro\GeolocateType('city'));
        $client->sendLookup($lookup);
        $result = $lookup->getResult();
        $this->assertNotNull($result);
        $suggestions = $result->getSuggestions();
        $this->assertIsArray($suggestions);
        $this->assertEquals('1 Test St', $suggestions[0]->getStreetLine());
    }

    public function testSendLookupWithPartialSuggestionFields() {
        $mockResponse = new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], '{"suggestions":[{"street_line":"2 Partial St"}]}');
        $mockHttpClient = new MockSender($mockResponse);
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup();
        $lookup->setSearch('2 Partial');
        $client->sendLookup($lookup);
        $result = $lookup->getResult();
        $suggestions = $result->getSuggestions();
        $this->assertIsArray($suggestions);
        $this->assertEquals('2 Partial St', $suggestions[0]->getStreetLine());
        $this->assertNull($suggestions[0]->getCity());
        $this->assertNull($suggestions[0]->getState());
    }

    public function testSendLookupWithExtraFieldsInResponse() {
        $mockResponse = new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], '{"suggestions":[{"street_line":"3 Extra St","city":"Extra City","state":"EXTRA","extra_field":"should_ignore"}]}');
        $mockHttpClient = new MockSender($mockResponse);
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup();
        $lookup->setSearch('3 Extra');
        $client->sendLookup($lookup);
        $result = $lookup->getResult();
        $suggestions = $result->getSuggestions();
        $this->assertIsArray($suggestions);
        $this->assertEquals('3 Extra St', $suggestions[0]->getStreetLine());
        $this->assertEquals('Extra City', $suggestions[0]->getCity());
        $this->assertEquals('EXTRA', $suggestions[0]->getState());
        $this->assertFalse(property_exists($suggestions[0], 'extra_field'));
    }

    public function testSendLookupWithMissingKeysInApiResponse() {
        $mockResponse = new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], '{"unexpected":"value"}');
        $mockHttpClient = new MockSender($mockResponse);
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup();
        $lookup->setSearch('test');
        $client->sendLookup($lookup);
        $result = $lookup->getResult();
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
        $lookup = new Lookup();
        $lookup->setSearch('test');
        $this->expectException(\Exception::class);
        $client->sendLookup($lookup);
    }

    public function testSendLookupWithUnicodeEmoji() {
        $mockHttpClient = new MockSender(new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], '{}'));
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup();
        $lookup->setSearch('東京 🗹');
        $client->sendLookup($lookup);
        $this->assertNotNull($lookup->getResult());
    }

    public function testResultObjectStructureNulls() {
        $result = new \SmartyStreets\PhpSdk\US_Autocomplete_Pro\Result([]);
        $suggestions = $result->getSuggestions();
        $this->assertArrayNotHasKey(999, $suggestions);
    }
}