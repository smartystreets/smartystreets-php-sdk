<?php

namespace SmartyStreets\PhpSdk\Tests\US_Autocomplete_Pro;

use PHPUnit\Framework\TestCase;
use Http\Mock\Client as MockHttpClient;
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
        $mockHttpClient = new MockHttpClient();
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();

        $mockResponseBody = '{"suggestions":[{"street_line":"1600 Amphitheatre Pkwy","city":"Mountain View","state":"CA"}]}';
        $mockHttpClient->addResponse(new Response(200, ['Content-Type' => 'application/json'], $mockResponseBody));

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
        $mockHttpClient = new MockHttpClient();
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();

        $mockHttpClient->addResponse(new Response(500, ['Content-Type' => 'application/json'], 'Internal Server Error'));

        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup();
        $lookup->setSearch('1600 Amphitheatre');
        $lookup->setMaxResults(5);

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
        $lookup->setSearch('1600 Amphitheatre');
        $lookup->setMaxResults(5);
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
}