<?php

namespace SmartyStreets\PhpSdk\Tests\International_Street;

use PHPUnit\Framework\TestCase;
use SmartyStreets\PhpSdk\Tests\Mocks\MockSender;
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
        $mockResponse = new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], '[{"address1":"10 Downing St","components":{"locality":"London","country_iso_3":"GBR"}}]');
        $mockHttpClient = new MockSender($mockResponse);
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();

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
        $mockResponse = new \GuzzleHttp\Psr7\Response(500, ['Content-Type' => 'application/json'], 'Internal Server Error');
        $mockHttpClient = new MockSender($mockResponse);
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();

        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup();
        $lookup->setCountry('GB');
        $lookup->setFreeform('10 Downing St, London');

        $this->expectException(\SmartyStreets\PhpSdk\Exceptions\SmartyException::class);
        $client->sendLookup($lookup);
    }

    public function testSendLookupWithEmptyInputThrows() {
        $mockResponse = new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], '[]');
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
        $lookup->setCountry('GB');
        $lookup->setFreeform('10 Downing St, London');
        $this->expectException(\SmartyStreets\PhpSdk\Exceptions\SmartyException::class);
        $client->sendLookup($lookup);
    }

    public function testSendLookupWithEmptyApiResponse() {
        $mockResponse = new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], '[]');
        $mockHttpClient = new MockSender($mockResponse);
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup();
        $lookup->setCountry('GB');
        $lookup->setFreeform('10 Downing St, London');
        $client->sendLookup($lookup);
        $results = $lookup->getResult();
        $this->assertIsArray($results);
        $this->assertEmpty($results);
    }

    public function testSendLookupWithMissingKeysInApiResponse() {
        $mockResponse = new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], '[{"unexpected":"value"}]');
        $mockHttpClient = new MockSender($mockResponse);
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $client = new \SmartyStreets\PhpSdk\International_Street\Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new \SmartyStreets\PhpSdk\International_Street\Lookup();
        $lookup->setCountry('GB');
        $lookup->setFreeform('test');
        $client->sendLookup($lookup);
        $results = $lookup->getResult();
        $this->assertIsArray($results);
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
        $client = new \SmartyStreets\PhpSdk\International_Street\Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new \SmartyStreets\PhpSdk\International_Street\Lookup();
        $lookup->setCountry('GB');
        $lookup->setFreeform('test');
        $this->expectException(\Exception::class);
        $client->sendLookup($lookup);
    }

    public function testSendLookupWithUnicodeEmoji() {
        $mockResponse = new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], '[]');
        $mockHttpClient = new MockSender($mockResponse);
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $client = new \SmartyStreets\PhpSdk\International_Street\Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new \SmartyStreets\PhpSdk\International_Street\Lookup();
        $lookup->setCountry('GB');
        $lookup->setFreeform('東京 🗹');
        $client->sendLookup($lookup);
        $this->assertIsArray($lookup->getResult());
    }

    public function testResultObjectStructureNulls() {
        $candidate = new \SmartyStreets\PhpSdk\International_Street\Candidate([]);
        $this->assertNull($candidate->getAddress1());
        $this->assertNull($candidate->getComponents()->getLocality());
    }
}
