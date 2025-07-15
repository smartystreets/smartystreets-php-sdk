<?php

namespace SmartyStreets\PhpSdk\Tests\US_Extract;

use PHPUnit\Framework\TestCase;
use SmartyStreets\PhpSdk\Tests\Mocks\MockSender;
use GuzzleHttp\Psr7\Response;
use SmartyStreets\PhpSdk\US_Extract\Client;
use SmartyStreets\PhpSdk\US_Extract\Lookup;
use SmartyStreets\PhpSdk\NativeSerializer;
use Http\Factory\Guzzle\RequestFactory;
use Http\Factory\Guzzle\StreamFactory;

class ClientTest extends TestCase
{
    public function testSendLookupSuccess()
    {
        $mockResponse = new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], '{"metadata":{"address_count":1,"verified_count":1},"addresses":[{"text":"1600 Amphitheatre Pkwy, Mountain View, CA 94043","verified":true}]}');
        $mockHttpClient = new MockSender($mockResponse);
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();

        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup();
        $lookup->setText('1600 Amphitheatre Pkwy, Mountain View, CA 94043');

        $client->sendLookup($lookup);
        $result = $lookup->getResult();
        $this->assertNotNull($result);
        $addresses = $result->getAddresses();
        $this->assertIsArray($addresses);
        $this->assertEquals('1600 Amphitheatre Pkwy, Mountain View, CA 94043', $addresses[0]->getText());
        $this->assertTrue($addresses[0]->isVerified());
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
        $lookup->setText('1600 Amphitheatre Pkwy, Mountain View, CA 94043');

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
        $lookup->setText('1600 Amphitheatre Pkwy, Mountain View, CA 94043');
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
        $lookup->setText('1600 Amphitheatre Pkwy, Mountain View, CA 94043');
        $client->sendLookup($lookup);
        $result = $lookup->getResult();
        $this->assertIsArray($result->getAddresses());
        $this->assertEmpty($result->getAddresses());
    }

    public function testSendLookupWithMissingKeysInApiResponse() {
        $mockResponse = new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], '{"unexpected":"value"}');
        $mockHttpClient = new MockSender($mockResponse);
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $client = new \SmartyStreets\PhpSdk\US_Extract\Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new \SmartyStreets\PhpSdk\US_Extract\Lookup();
        $lookup->setText('test');
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
        $client = new \SmartyStreets\PhpSdk\US_Extract\Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new \SmartyStreets\PhpSdk\US_Extract\Lookup();
        $lookup->setText('test');
        $this->expectException(\Exception::class);
        $client->sendLookup($lookup);
    }

    public function testSendLookupWithUnicodeEmoji() {
        $mockResponse = new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], '{}');
        $mockHttpClient = new MockSender($mockResponse);
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $client = new \SmartyStreets\PhpSdk\US_Extract\Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new \SmartyStreets\PhpSdk\US_Extract\Lookup();
        $lookup->setText('東京 🗹');
        $client->sendLookup($lookup);
        $this->assertNotNull($lookup->getResult());
    }

    public function testResultObjectStructureNulls() {
        $result = new \SmartyStreets\PhpSdk\US_Extract\Result([]);
        $addresses = $result->getAddresses();
        $this->assertArrayNotHasKey(999, $addresses);
    }
}
