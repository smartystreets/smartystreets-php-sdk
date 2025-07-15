<?php

namespace SmartyStreets\PhpSdk\Tests\US_ZIPCode;

use PHPUnit\Framework\TestCase;
use SmartyStreets\PhpSdk\Tests\Mocks\MockSender;
use GuzzleHttp\Psr7\Response;
use SmartyStreets\PhpSdk\US_ZIPCode\Client;
use SmartyStreets\PhpSdk\US_ZIPCode\Lookup;
use SmartyStreets\PhpSdk\NativeSerializer;
use Http\Factory\Guzzle\RequestFactory;
use Http\Factory\Guzzle\StreamFactory;
use SmartyStreets\PhpSdk\Exceptions\SmartyException;

class ClientTest extends TestCase
{
    public function testSendLookupSuccess()
    {
        $mockResponse = new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], '[{"input_index":0,"city_states":[{"city":"Mountain View","state":"CA"}],"zipcodes":[{"zipcode":"94043"}]}]');
        $mockHttpClient = new MockSender($mockResponse);
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();

        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup();
        $lookup->setCity('Mountain View');
        $lookup->setState('CA');
        $lookup->setZipCode('94043');

        $client->sendLookup($lookup);
        $result = $lookup->getResult();
        $this->assertNotNull($result);
        $city = $result->getCityAtIndex(0);
        $zip = $result->getZIPCodeAtIndex(0);
        $this->assertNotNull($city);
        $this->assertNotNull($zip);
        $this->assertEquals('Mountain View', $city->getCity());
        $this->assertEquals('CA', $city->getState());
        $this->assertEquals('94043', $zip->getZIPCode());
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
        $lookup->setCity('Mountain View');
        $lookup->setState('CA');
        $lookup->setZipCode('94043');

        $this->expectException(SmartyException::class);
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
        $this->expectException(SmartyException::class);
        $client->sendLookup($lookup);
    }

    public function testSendLookupWithInvalidInput() {
        $mockResponse = new \GuzzleHttp\Psr7\Response(400, ['Content-Type' => 'application/json'], '{"error":"Invalid ZIP"}');
        $mockHttpClient = new MockSender($mockResponse);
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup();
        $lookup->setCity(''); // Invalid city
        $lookup->setState('!@#'); // Invalid state
        $lookup->setZipCode('abcde'); // Invalid zip
        $this->expectException(SmartyException::class);
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
        $lookup->setCity('Mountain View');
        $lookup->setState('CA');
        $lookup->setZipCode('94043');
        $client->sendLookup($lookup);
        $result = $lookup->getResult();
        $this->assertIsArray($result->getCities());
        $this->assertIsArray($result->getZIPCodes());
        $this->assertEmpty($result->getCities());
        $this->assertEmpty($result->getZIPCodes());
    }

    public function testSendLookupWithMalformedApiResponse() {
        $mockResponse = new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], '{not json}');
        $mockHttpClient = new MockSender($mockResponse);
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup();
        $lookup->setCity('Mountain View');
        $lookup->setState('CA');
        $lookup->setZipCode('94043');
        $this->expectException(SmartyException::class);
        $client->sendLookup($lookup);
    }

    public function testSendLookupWithPartialApiResponse() {
        $mockResponse = new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], '[{"input_index":0}]');
        $mockHttpClient = new MockSender($mockResponse);
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup();
        $lookup->setCity('Mountain View');
        $lookup->setState('CA');
        $lookup->setZipCode('94043');
        $client->sendLookup($lookup);
        $result = $lookup->getResult();
        $city = $result->getCityAtIndex(0);
        $zip = $result->getZIPCodeAtIndex(0);
        if ($city !== null) {
            $this->assertNull($city->getCity());
            $this->assertNull($city->getMailableCity());
            $this->assertNull($city->getStateAbbreviation());
            $this->assertNull($city->getState());
        } else {
            $this->assertNull($city);
        }
        if ($zip !== null) {
            $this->assertNull($zip->getZIPCode());
            $this->assertNull($zip->getZIPCodeType());
            $this->assertNull($zip->getDefaultCity());
            $this->assertNull($zip->getCountyFips());
            $this->assertNull($zip->getCountyName());
            $this->assertNull($zip->getStateAbbreviation());
            $this->assertNull($zip->getState());
            $this->assertNull($zip->getLatitude());
            $this->assertNull($zip->getLongitude());
            $this->assertNull($zip->getPrecision());
            $this->assertEmpty($zip->getAlternateCounties());
        } else {
            $this->assertNull($zip);
        }
    }

    public function testSendLookupWithZipCodeBoundaries() {
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $valids = ['00000', '99999', '12345'];
        foreach ($valids as $zip) {
            $mockResponse = new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], '[{"input_index":0,"zipcodes":[{"zipcode":"' . $zip . '"}]}]');
            $mockHttpClient = new MockSender($mockResponse);
            $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
            $lookup = new Lookup();
            $lookup->setZipCode($zip);
            $client->sendLookup($lookup);
            $result = $lookup->getResult();
            $this->assertNotNull($result);
        }
        $invalids = ['1234', 'ABCDE', '', null];
        foreach ($invalids as $zip) {
            $mockResponse = new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], '[{"input_index":0,"zipcodes":[]}]');
            $mockHttpClient = new MockSender($mockResponse);
            $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
            $lookup = new Lookup();
            $lookup->setZipCode($zip);
            $this->expectException(\SmartyStreets\PhpSdk\Exceptions\SmartyException::class);
            $client->sendLookup($lookup);
        }
    }

    public function testResultGettersNeverReturnNull() {
        $result = new \SmartyStreets\PhpSdk\US_ZIPCode\Result([]);
        $this->assertIsArray($result->getCities());
        $this->assertIsArray($result->getZIPCodes());
        $this->assertNotNull($result->getCityAtIndex(0));
        $this->assertNotNull($result->getZIPCodeAtIndex(0));
    }

    public function testSendLookupWithMissingKeysInApiResponse() {
        $mockHttpClient = new \Http\Mock\Client();
        $requestFactory = new \Http\Factory\Guzzle\RequestFactory();
        $streamFactory = new \Http\Factory\Guzzle\StreamFactory();
        $serializer = new \SmartyStreets\PhpSdk\NativeSerializer();
        $mockHttpClient->addResponse(new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], '[{"unexpected":"value"}]'));
        $client = new \SmartyStreets\PhpSdk\US_ZIPCode\Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new \SmartyStreets\PhpSdk\US_ZIPCode\Lookup();
        $lookup->setCity('test');
        $lookup->setState('TS');
        $lookup->setZipCode('12345');
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
        $lookup->setCity('test');
        $lookup->setState('TS');
        $lookup->setZipCode('12345');
        $this->expectException(\Exception::class);
        $client->sendLookup($lookup);
    }

    public function testSendBatchWithAllInvalidLookups() {
        $mockHttpClient = new \Http\Mock\Client();
        $requestFactory = new \Http\Factory\Guzzle\RequestFactory();
        $streamFactory = new \Http\Factory\Guzzle\StreamFactory();
        $serializer = new \SmartyStreets\PhpSdk\NativeSerializer();
        $client = new \SmartyStreets\PhpSdk\US_ZIPCode\Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $batch = new \SmartyStreets\PhpSdk\Batch();
        for ($i = 0; $i < 5; $i++) {
            $batch->add(new \SmartyStreets\PhpSdk\US_ZIPCode\Lookup());
        }
        $mockHttpClient->addResponse(new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], '[]'));
        $client->sendBatch($batch);
        foreach ($batch->getAllLookups() as $lookup) {
            $this->assertNotNull($lookup->getResult());
        }
    }

    public function testSendBatchWithEmptyBatchThrows() {
        $mockHttpClient = new \Http\Mock\Client();
        $requestFactory = new \Http\Factory\Guzzle\RequestFactory();
        $streamFactory = new \Http\Factory\Guzzle\StreamFactory();
        $serializer = new \SmartyStreets\PhpSdk\NativeSerializer();
        $client = new \SmartyStreets\PhpSdk\US_ZIPCode\Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $batch = new \SmartyStreets\PhpSdk\Batch();
        $this->expectException(\SmartyStreets\PhpSdk\Exceptions\SmartyException::class);
        $client->sendBatch($batch);
    }

    public function testSendLookupWithUnicodeEmoji() {
        $mockHttpClient = new \Http\Mock\Client();
        $requestFactory = new \Http\Factory\Guzzle\RequestFactory();
        $streamFactory = new \Http\Factory\Guzzle\StreamFactory();
        $serializer = new \SmartyStreets\PhpSdk\NativeSerializer();
        $mockHttpClient->addResponse(new \GuzzleHttp\Psr7\Response(200, ['Content-Type' => 'application/json'], '[]'));
        $client = new \SmartyStreets\PhpSdk\US_ZIPCode\Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new \SmartyStreets\PhpSdk\US_ZIPCode\Lookup();
        $lookup->setCity('東京 🗹');
        $lookup->setState('Москва');
        $lookup->setZipCode('94043');
        $client->sendLookup($lookup);
        $this->assertNotNull($lookup->getResult());
    }

    public function testResultObjectStructureNulls() {
        $result = new \SmartyStreets\PhpSdk\US_ZIPCode\Result([]);
        $city = $result->getCityAtIndex(999);
        $zip = $result->getZIPCodeAtIndex(999);
        $this->assertInstanceOf(\SmartyStreets\PhpSdk\US_ZIPCode\City::class, $city);
        $this->assertNull($city->getCity());
        $this->assertNull($city->getMailableCity());
        $this->assertNull($city->getStateAbbreviation());
        $this->assertNull($city->getState());
        $this->assertInstanceOf(\SmartyStreets\PhpSdk\US_ZIPCode\ZIPCode::class, $zip);
        $this->assertNull($zip->getZIPCode());
        $this->assertNull($zip->getZIPCodeType());
        $this->assertNull($zip->getDefaultCity());
        $this->assertNull($zip->getCountyFips());
        $this->assertNull($zip->getCountyName());
        $this->assertNull($zip->getStateAbbreviation());
        $this->assertNull($zip->getState());
        $this->assertNull($zip->getLatitude());
        $this->assertNull($zip->getLongitude());
        $this->assertNull($zip->getPrecision());
        $this->assertEmpty($zip->getAlternateCounties());
    }
}
