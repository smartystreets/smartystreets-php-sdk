<?php

namespace SmartyStreets\PhpSdk\Tests\US_ZIPCode;

use PHPUnit\Framework\TestCase;
use Http\Mock\Client as MockHttpClient;
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
        $mockHttpClient = new MockHttpClient();
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();

        $mockResponseBody = '[{"input_index":0,"city_states":[{"city":"Mountain View","state":"CA"}],"zipcodes":[{"zipcode":"94043"}]}]';
        $mockHttpClient->addResponse(new Response(200, ['Content-Type' => 'application/json'], $mockResponseBody));

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
        $mockHttpClient = new MockHttpClient();
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();

        $mockHttpClient->addResponse(new Response(500, ['Content-Type' => 'application/json'], 'Internal Server Error'));

        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup();
        $lookup->setCity('Mountain View');
        $lookup->setState('CA');
        $lookup->setZipCode('94043');

        $this->expectException(SmartyException::class);
        $client->sendLookup($lookup);
    }

    public function testSendLookupWithEmptyInputThrows() {
        $mockHttpClient = new MockHttpClient();
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup(); // No fields set
        $this->expectException(SmartyException::class);
        $client->sendLookup($lookup);
    }

    public function testSendLookupWithInvalidInput() {
        $mockHttpClient = new MockHttpClient();
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
        $mockHttpClient = new MockHttpClient();
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $mockHttpClient->addResponse(new Response(200, ['Content-Type' => 'application/json'], '[]'));
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
        $mockHttpClient = new MockHttpClient();
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $mockHttpClient->addResponse(new Response(200, ['Content-Type' => 'application/json'], '{not json}'));
        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup();
        $lookup->setCity('Mountain View');
        $lookup->setState('CA');
        $lookup->setZipCode('94043');
        $this->expectException(SmartyException::class);
        $client->sendLookup($lookup);
    }

    public function testSendLookupWithPartialApiResponse() {
        $mockHttpClient = new MockHttpClient();
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $mockResponseBody = '[{"input_index":0}]';
        $mockHttpClient->addResponse(new Response(200, ['Content-Type' => 'application/json'], $mockResponseBody));
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
        $mockHttpClient = new MockHttpClient();
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $valids = ['00000', '99999', '12345'];
        foreach ($valids as $zip) {
            $lookup = new Lookup();
            $lookup->setZipCode($zip);
            $mockHttpClient->addResponse(new Response(200, ['Content-Type' => 'application/json'], '[{"input_index":0,"zipcodes":[{"zipcode":"' . $zip . '"}]}]'));
            $client->sendLookup($lookup);
            $result = $lookup->getResult();
            $this->assertNotNull($result);
        }
        $invalids = ['1234', 'ABCDE', '', null];
        foreach ($invalids as $zip) {
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
}
