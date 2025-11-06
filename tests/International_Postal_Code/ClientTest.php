<?php

namespace SmartyStreets\PhpSdk\Tests\International_Postal_Code;

use PHPUnit\Framework\TestCase;
use SmartyStreets\PhpSdk\Tests\Mocks\MockSender;
use GuzzleHttp\Psr7\Response;
use SmartyStreets\PhpSdk\International_Postal_Code\Client;
use SmartyStreets\PhpSdk\International_Postal_Code\Lookup;
use SmartyStreets\PhpSdk\International_Postal_Code\Candidate;
use SmartyStreets\PhpSdk\NativeSerializer;
use Http\Factory\Guzzle\RequestFactory;
use Http\Factory\Guzzle\StreamFactory;

class ClientTest extends TestCase
{
    public function testLookupSerializedAndSent_ResponseCandidatesIncorporatedIntoLookup()
    {
        $mockResponse = new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], '[
            {"input_id": "1"},
            {"administrative_area": "2"},
            {"locality": "3"},
            {"postal_code": "4"}
        ]');
        $mockHttpClient = new MockSender($mockResponse);
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();

        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup();
        $lookup->setAdministrativeArea('42');

        $client->sendLookup($lookup);

        $request = $mockHttpClient->getRequest();
        $this->assertNotNull($request);
        $this->assertEquals('GET', $request->getMethod());
        $this->assertStringContainsString('/lookup', $request->getUri()->getPath());
        $this->assertStringContainsString('administrative_area=42', $request->getUri()->getQuery());

        $results = $lookup->getResults();
        $this->assertIsArray($results);
        $this->assertCount(4, $results);
        $this->assertEquals('1', $results[0]->getInputId());
        $this->assertEquals('2', $results[1]->getAdministrativeArea());
        $this->assertEquals('3', $results[2]->getLocality());
        $this->assertEquals('4', $results[3]->getPostalCodeShort());
    }

    public function testNilLookupThrows()
    {
        $mockResponse = new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], '[]');
        $mockHttpClient = new MockSender($mockResponse);
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);

        $this->expectException(\SmartyStreets\PhpSdk\Exceptions\SmartyException::class);
        $this->expectExceptionMessage('lookup cannot be null');
        $client->sendLookup(null);
    }

    public function testEmptyLookup()
    {
        $mockResponse = new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], '');
        $mockHttpClient = new MockSender($mockResponse);
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup();

        $this->expectException(\SmartyStreets\PhpSdk\Exceptions\SmartyException::class);
        $client->sendLookup($lookup);
    }

    public function testSenderErrorPreventsDeserialization()
    {
        $mockHttpClient = new class implements \Psr\Http\Client\ClientInterface {
            public function sendRequest(\Psr\Http\Message\RequestInterface $request): \Psr\Http\Message\ResponseInterface {
                throw new \Exception('GOPHERS!');
            }
        };
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup();
        $lookup->setLocality('HI');

        $this->expectException(\Exception::class);
        $client->sendLookup($lookup);

        $results = $lookup->getResults();
        $this->assertIsArray($results);
        $this->assertEmpty($results);
    }

    public function testDeserializationErrorPreventsDeserialization()
    {
        $mockResponse = new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], 'I have no JSON');
        $mockHttpClient = new MockSender($mockResponse);
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup();
        $lookup->setLocality('HI');

        $this->expectException(\SmartyStreets\PhpSdk\Exceptions\SmartyException::class);
        $client->sendLookup($lookup);

        $results = $lookup->getResults();
        $this->assertIsArray($results);
        $this->assertEmpty($results);
    }

    public function testFullJSONResponseDeserialization()
    {
        $mockResponse = new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], '[
{
    "input_id": "1",
    "country_iso_3": "2",
    "locality": "3",
    "administrative_area": "4",
    "sub_administrative_area": "5",
    "super_administrative_area": "6",
    "postal_code": "7"
}
]');
        $mockHttpClient = new MockSender($mockResponse);
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup();

        $client->sendLookup($lookup);

        $results = $lookup->getResults();
        $this->assertIsArray($results);
        $this->assertCount(1, $results);
        $candidate = $results[0];
        $this->assertEquals('1', $candidate->getInputId());
        $this->assertEquals('2', $candidate->getCountryIso3());
        $this->assertEquals('3', $candidate->getLocality());
        $this->assertEquals('4', $candidate->getAdministrativeArea());
        $this->assertEquals('5', $candidate->getSubAdministrativeArea());
        $this->assertEquals('6', $candidate->getSuperAdministrativeArea());
        $this->assertEquals('7', $candidate->getPostalCodeShort());
    }

    public function testHttpError()
    {
        $mockResponse = new \GuzzleHttp\Psr7\Response(500, ['Content-Type' => 'application/json'], 'Internal Server Error');
        $mockHttpClient = new MockSender($mockResponse);
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();

        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup();
        $lookup->setLocality('Test');

        $this->expectException(\SmartyStreets\PhpSdk\Exceptions\SmartyException::class);
        $client->sendLookup($lookup);
    }
}

