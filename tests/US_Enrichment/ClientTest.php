<?php

namespace SmartyStreets\PhpSdk\Tests\US_Enrichment;

use PHPUnit\Framework\TestCase;
use SmartyStreets\PhpSdk\Tests\Mocks\MockSender;
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
        $mockResponse = new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], '{"enrichment":[{"address":"1600 Amphitheatre Pkwy, Mountain View, CA 94043","property":"office"}]}');
        $mockHttpClient = new MockSender($mockResponse);
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();

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
        $mockResponse = new \GuzzleHttp\Psr7\Response(500, ['Content-Type' => 'application/json'], 'Internal Server Error');
        $mockHttpClient = new MockSender($mockResponse);
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();

        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup();
        $lookup->setFreeform('1600 Amphitheatre Pkwy, Mountain View, CA 94043');

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
        $lookup->setFreeform('1600 Amphitheatre Pkwy, Mountain View, CA 94043');
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
        $lookup->setFreeform('1600 Amphitheatre Pkwy, Mountain View, CA 94043');
        $client->sendLookup($lookup);
        $result = $lookup->getResponse();
        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    public function testSendPropertyFinancialLookupWithStringAndObject() {
        $mockResponse = new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], '[{"foo":"bar"}]');
        $mockHttpClient = new MockSender($mockResponse);
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        // String input should throw
        $this->expectException(\SmartyStreets\PhpSdk\Exceptions\SmartyException::class);
        $client->sendPropertyFinancialLookup('some-key');
        // Object input (happy path)
        // (move to a separate test to avoid expectException interfering)
    }

    public function testSendPropertyFinancialLookupWithObject() {
        $mockResponse = new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], '[{"foo":"bar"}]');
        $mockHttpClient = new MockSender($mockResponse);
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup();
        $lookup->setFreeform('address');
        $result2 = $client->sendPropertyFinancialLookup($lookup);
        $this->assertNotNull($result2);
        $this->assertEquals('property', $lookup->getDataSetName());
        $this->assertEquals('financial', $lookup->getDataSubsetName());
    }

    public function testSendPropertyPrincipalLookupWithStringAndObject() {
        $mockResponse = new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], '[{"foo":"bar"}]');
        $mockHttpClient = new MockSender($mockResponse);
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $this->expectException(\SmartyStreets\PhpSdk\Exceptions\SmartyException::class);
        $client->sendPropertyPrincipalLookup('some-key');
    }

    public function testSendPropertyPrincipalLookupWithObject() {
        $mockResponse = new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], '[{"foo":"bar"}]');
        $mockHttpClient = new MockSender($mockResponse);
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup();
        $lookup->setFreeform('address');
        $result2 = $client->sendPropertyPrincipalLookup($lookup);
        $this->assertNotNull($result2);
        $this->assertEquals('property', $lookup->getDataSetName());
        $this->assertEquals('principal', $lookup->getDataSubsetName());
    }

    public function testSendGeoReferenceLookupWithStringAndObject() {
        $mockResponse = new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], '[{"foo":"bar"}]');
        $mockHttpClient = new MockSender($mockResponse);
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $this->expectException(\SmartyStreets\PhpSdk\Exceptions\SmartyException::class);
        $client->sendGeoReferenceLookup('some-key');
    }

    public function testSendGeoReferenceLookupWithObject() {
        $mockResponse = new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], '[{"foo":"bar"}]');
        $mockHttpClient = new MockSender($mockResponse);
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup();
        $lookup->setFreeform('address');
        $result2 = $client->sendGeoReferenceLookup($lookup);
        $this->assertNotNull($result2);
        $this->assertEquals('geo-reference', $lookup->getDataSetName());
        $this->assertNull($lookup->getDataSubsetName());
    }

    public function testSendSecondaryLookupWithStringAndObject() {
        $mockResponse = new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], '[{"foo":"bar"}]');
        $mockHttpClient = new MockSender($mockResponse);
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $this->expectException(\SmartyStreets\PhpSdk\Exceptions\SmartyException::class);
        $client->sendSecondaryLookup('some-key');
    }

    public function testSendSecondaryLookupWithObject() {
        $mockResponse = new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], '[{"foo":"bar"}]');
        $mockHttpClient = new MockSender($mockResponse);
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup();
        $lookup->setFreeform('address');
        $result2 = $client->sendSecondaryLookup($lookup);
        $this->assertNotNull($result2);
        $this->assertEquals('secondary', $lookup->getDataSetName());
        $this->assertNull($lookup->getDataSubsetName());
    }

    public function testSendSecondaryCountLookupWithStringAndObject() {
        $mockResponse = new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], '[{"foo":"bar"}]');
        $mockHttpClient = new MockSender($mockResponse);
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $this->expectException(\SmartyStreets\PhpSdk\Exceptions\SmartyException::class);
        $client->sendSecondaryCountLookup('some-key');
    }

    public function testSendSecondaryCountLookupWithObject() {
        $mockResponse = new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], '[{"foo":"bar"}]');
        $mockHttpClient = new MockSender($mockResponse);
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup();
        $lookup->setFreeform('address');
        $result2 = $client->sendSecondaryCountLookup($lookup);
        $this->assertNotNull($result2);
        $this->assertEquals('secondary', $lookup->getDataSetName());
        $this->assertEquals('count', $lookup->getDataSubsetName());
    }

    public function testSendGenericLookupWithStringAndObject() {
        $mockResponse = new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], '[{"foo":"bar"}]');
        $mockHttpClient = new MockSender($mockResponse);
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $this->expectException(\SmartyStreets\PhpSdk\Exceptions\SmartyException::class);
        $client->sendGenericLookup('some-key', 'ds', 'dss');
    }

    public function testSendGenericLookupWithObject() {
        $mockResponse = new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], '[{"foo":"bar"}]');
        $mockHttpClient = new MockSender($mockResponse);
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup();
        $lookup->setFreeform('address');
        $result2 = $client->sendGenericLookup($lookup, 'ds', 'dss');
        $this->assertNotNull($result2);
        $this->assertEquals('ds', $lookup->getDataSetName());
        $this->assertEquals('dss', $lookup->getDataSubsetName());
    }

    public function testSendLookupWithMissingKeysInApiResponse() {
        $mockResponse = new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], '{"unexpected":"value"}');
        $mockHttpClient = new MockSender($mockResponse);
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup();
        $lookup->setFreeform('test');
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
        $lookup = new Lookup();
        $lookup->setFreeform('test');
        $this->expectException(\Exception::class);
        $client->sendLookup($lookup);
    }

    public function testSendLookupWithUnicodeEmoji() {
        $mockResponse = new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], '{}');
        $mockHttpClient = new MockSender($mockResponse);
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup();
        $lookup->setFreeform('東京 🗹');
        $client->sendLookup($lookup);
        $this->assertNotNull($lookup->getResponse());
    }

    public function testResultObjectStructureNulls() {
        $result = new \SmartyStreets\PhpSdk\US_Enrichment\Result([]);
        $matched = $result->getMatchedAddress();
        $this->assertInstanceOf(\SmartyStreets\PhpSdk\US_Enrichment\MatchedAddress::class, $matched);
        $this->assertNull($matched->street);
        $this->assertNull($matched->city);
        $this->assertNull($matched->state);
        $this->assertNull($matched->zipcode);
    }
}
