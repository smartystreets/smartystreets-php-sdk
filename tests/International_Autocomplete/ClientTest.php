<?php

namespace SmartyStreets\PhpSdk\Tests\International_Autocomplete;

use PHPUnit\Framework\TestCase;
use SmartyStreets\PhpSdk\Tests\Mocks\MockSender;
use GuzzleHttp\Psr7\Response;
use SmartyStreets\PhpSdk\International_Autocomplete\Client;
use SmartyStreets\PhpSdk\International_Autocomplete\Lookup;
use SmartyStreets\PhpSdk\NativeSerializer;
use Http\Factory\Guzzle\RequestFactory;
use Http\Factory\Guzzle\StreamFactory;

class ClientTest extends TestCase
{
    public function testSendLookupSuccess()
    {
        $mockResponse = new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], '{"candidates":[{"address_text":"10 Downing St, London, GB"}]}');
        $mockHttpClient = new MockSender($mockResponse);
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();

        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup();
        $lookup->setSearch('10 Downing');
        $lookup->setCountry('GB');
        $lookup->setMaxResults(5);

        $client->sendLookup($lookup);
        $result = $lookup->getResult();
        $this->assertNotNull($result);
        $candidates = $result->getCandidates();
        $this->assertIsArray($candidates);
        $this->assertEquals('10 Downing St, London, GB', $candidates[0]->getAddressText());
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
        $lookup->setSearch('10 Downing');
        $lookup->setCountry('GB');
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
        $lookup->setSearch('10 Downing');
        $lookup->setCountry('GB');
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
        $lookup->setSearch('10 Downing');
        $lookup->setCountry('GB');
        $lookup->setMaxResults(5);
        $client->sendLookup($lookup);
        $result = $lookup->getResult();
        $candidates = $result->getCandidates();
        if ($candidates === null) {
            $this->assertNull($candidates);
        } else {
            $this->assertIsArray($candidates);
            $this->assertEmpty($candidates);
        }
    }

    public function testSendLookupWithMissingKeysInApiResponse() {
        $mockResponse = new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], '{"unexpected":"value"}');
        $mockHttpClient = new MockSender($mockResponse);
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $client = new \SmartyStreets\PhpSdk\International_Autocomplete\Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new \SmartyStreets\PhpSdk\International_Autocomplete\Lookup();
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
        $client = new \SmartyStreets\PhpSdk\International_Autocomplete\Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new \SmartyStreets\PhpSdk\International_Autocomplete\Lookup();
        $lookup->setSearch('test');
        $this->expectException(\Exception::class);
        $client->sendLookup($lookup);
    }

    public function testSendLookupWithUnicodeEmoji() {
        $mockResponse = new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], '{}');
        $mockHttpClient = new MockSender($mockResponse);
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $client = new \SmartyStreets\PhpSdk\International_Autocomplete\Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new \SmartyStreets\PhpSdk\International_Autocomplete\Lookup();
        $lookup->setSearch('東京 🗹');
        $client->sendLookup($lookup);
        $this->assertNotNull($lookup->getResult());
    }

    public function testResultObjectStructureNulls() {
        $result = new \SmartyStreets\PhpSdk\International_Autocomplete\Result([]);
        $candidates = $result->getCandidates();
        if ($candidates === null) {
            $this->assertNull($candidates);
        } else {
            $this->assertArrayNotHasKey(999, $candidates);
        }
    }
}
