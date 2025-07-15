<?php

namespace SmartyStreets\PhpSdk\Tests\US_Extract;

use PHPUnit\Framework\TestCase;
use Http\Mock\Client as MockHttpClient;
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
        $mockHttpClient = new MockHttpClient();
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();

        $mockResponseBody = '{"metadata":{"address_count":1,"verified_count":1},"addresses":[{"text":"1600 Amphitheatre Pkwy, Mountain View, CA 94043","verified":true}]}';
        $mockHttpClient->addResponse(new Response(200, ['Content-Type' => 'application/json'], $mockResponseBody));

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
        $mockHttpClient = new MockHttpClient();
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();

        $mockHttpClient->addResponse(new Response(500, ['Content-Type' => 'application/json'], 'Internal Server Error'));

        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup();
        $lookup->setText('1600 Amphitheatre Pkwy, Mountain View, CA 94043');

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
        $lookup->setText('1600 Amphitheatre Pkwy, Mountain View, CA 94043');
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
        $lookup->setText('1600 Amphitheatre Pkwy, Mountain View, CA 94043');
        $client->sendLookup($lookup);
        $result = $lookup->getResult();
        $this->assertIsArray($result->getAddresses());
        $this->assertEmpty($result->getAddresses());
    }
}
