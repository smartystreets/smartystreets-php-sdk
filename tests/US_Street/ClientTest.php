<?php

namespace SmartyStreets\PhpSdk\Tests\US_Street;

use PHPUnit\Framework\TestCase;
use Http\Mock\Client as MockHttpClient;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use GuzzleHttp\Psr7\Response;
use SmartyStreets\PhpSdk\US_Street\Client;
use SmartyStreets\PhpSdk\US_Street\Lookup;
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

        $mockResponseBody = '[{"input_id":"24601","input_index":0,"candidate_index":1,"delivery_line_1":"1600 Amphitheatre Pkwy","last_line":"Mountain View, CA 94043","components":{"zipcode":"94043","plus4_code":"1351"},"metadata":{"county_name":"Santa Clara","latitude":37.4224764,"longitude":-122.0842499}}]';
        $mockHttpClient->addResponse(new Response(200, ['Content-Type' => 'application/json'], $mockResponseBody));

        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup();
        $lookup->setStreet('1600 Amphitheatre Pkwy');
        $lookup->setCity('Mountain View');
        $lookup->setState('CA');
        $lookup->setZipcode('94043');

        $client->sendLookup($lookup);
        $results = $lookup->getResult();
        $this->assertNotNull($results);
        $this->assertIsArray($results);
        $this->assertNotEmpty($results);
        if (is_array($results[0])) {
            $this->fail('Expected result[0] to be an object, got array.');
        }
        $this->assertEquals('1600 Amphitheatre Pkwy', $results[0]->getDeliveryLine1());
        $this->assertEquals('Mountain View, CA 94043', $results[0]->getLastLine());
        $this->assertNotNull($results[0]->getComponents());
        $this->assertNotNull($results[0]->getMetadata());
        $this->assertNotNull($results[0]->getAnalysis());
        $this->assertEquals('94043', $results[0]->getComponents()->getZIPCode());
        $this->assertEquals('Santa Clara', $results[0]->getMetadata()->getCountyName());
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
        $lookup->setStreet('1600 Amphitheatre Pkwy');
        $lookup->setCity('Mountain View');
        $lookup->setState('CA');
        $lookup->setZipcode('94043');

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
        $lookup->setZipcode('INVALID');
        $mockHttpClient->addResponse(new Response(400, ['Content-Type' => 'application/json'], '{"error":"Invalid ZIP"}'));
        $this->expectException(SmartyException::class);
        $client->sendLookup($lookup);
    }

    public function testSendBatchWithMaxSize() {
        $mockHttpClient = new MockHttpClient();
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $batch = new \SmartyStreets\PhpSdk\Batch();
        for ($i = 0; $i < 100; $i++) {
            $lookup = new Lookup();
            $lookup->setStreet('Street ' . $i);
            $lookup->setCity('City');
            $lookup->setState('ST');
            $lookup->setZipcode('12345');
            $batch->add($lookup);
        }
        $mockHttpClient->addResponse(new Response(200, ['Content-Type' => 'application/json'], '[]'));
        $client->sendBatch($batch);
        $this->assertEquals(100, $batch->size());
    }

    public function testSendBatchOverMaxSizeThrows() {
        $this->expectException(\SmartyStreets\PhpSdk\Exceptions\BatchFullException::class);
        $batch = new \SmartyStreets\PhpSdk\Batch();
        for ($i = 0; $i < 101; $i++) {
            $lookup = new Lookup();
            $batch->add($lookup);
        }
    }

    public function testSendLookupWithMalformedJsonResponse() {
        $mockHttpClient = new MockHttpClient();
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $mockHttpClient->addResponse(new Response(200, ['Content-Type' => 'application/json'], '{not valid json'));
        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup();
        $lookup->setStreet('1600 Amphitheatre Pkwy');
        $lookup->setCity('Mountain View');
        $lookup->setState('CA');
        $lookup->setZipcode('94043');
        $this->expectException(SmartyException::class);
        $client->sendLookup($lookup);
    }

    public function testSendLookupWithEmptyApiResponseReturnsEmptyArray() {
        $mockHttpClient = new MockHttpClient();
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $mockHttpClient->addResponse(new Response(200, ['Content-Type' => 'application/json'], '[]'));
        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup();
        $lookup->setStreet('1600 Amphitheatre Pkwy');
        $lookup->setCity('Mountain View');
        $lookup->setState('CA');
        $lookup->setZipcode('94043');
        $client->sendLookup($lookup);
        $results = $lookup->getResult();
        $this->assertIsArray($results);
        $this->assertEmpty($results);
    }

    public function testCandidateGettersNeverReturnNull() {
        $candidate = new \SmartyStreets\PhpSdk\US_Street\Candidate([]);
        $this->assertNotNull($candidate->getComponents());
        $this->assertNotNull($candidate->getMetadata());
        $this->assertNotNull($candidate->getAnalysis());
    }

    public function testSendLookupWithStringBoundaries() {
        $mockHttpClient = new MockHttpClient();
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        // Extremely long string
        $long = str_repeat('A', 1000);
        $lookup = new Lookup();
        $lookup->setStreet($long);
        $lookup->setCity($long);
        $lookup->setState($long);
        $lookup->setZipcode($long);
        $mockHttpClient->addResponse(new Response(200, ['Content-Type' => 'application/json'], '[]'));
        $client->sendLookup($lookup);
        $this->assertIsArray($lookup->getResult());
        // Unicode/emoji
        $unicode = '東京 🏙️';
        $lookup = new Lookup();
        $lookup->setStreet($unicode);
        $lookup->setCity($unicode);
        $lookup->setState($unicode);
        $lookup->setZipcode('94043');
        $mockHttpClient->addResponse(new Response(200, ['Content-Type' => 'application/json'], '[]'));
        $client->sendLookup($lookup);
        $this->assertIsArray($lookup->getResult());
        // Empty string
        $lookup = new Lookup();
        $lookup->setStreet('');
        $lookup->setCity('');
        $lookup->setState('');
        $lookup->setZipcode('');
        $this->expectException(SmartyException::class);
        $client->sendLookup($lookup);
    }

    public function testSendBatchWithMixedValidAndInvalidLookups() {
        $mockHttpClient = new MockHttpClient();
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $batch = new \SmartyStreets\PhpSdk\Batch();
        $valid = new Lookup();
        $valid->setStreet('1600 Amphitheatre Pkwy');
        $valid->setCity('Mountain View');
        $valid->setState('CA');
        $valid->setZipcode('94043');
        $invalid = new Lookup(); // No fields set
        $batch->add($valid);
        $batch->add($invalid);
        $mockHttpClient->addResponse(new Response(200, ['Content-Type' => 'application/json'], '[{"input_id":"24601","input_index":0,"candidate_index":1,"delivery_line_1":"1600 Amphitheatre Pkwy","last_line":"Mountain View, CA 94043","components":{"zipcode":"94043","plus4_code":"1351"},"metadata":{"county_name":"Santa Clara","latitude":37.4224764,"longitude":-122.0842499}}]'));
        // The SDK does not throw for mixed batches, so just assert the valid result is present
        $client->sendBatch($batch);
        $results = $valid->getResult();
        $this->assertIsArray($results);
        $this->assertNotEmpty($results);
    }

    public function testSendLookupWithUnexpectedApiFields() {
        $mockHttpClient = new MockHttpClient();
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();
        $client = new Client($mockHttpClient, $requestFactory, $streamFactory, $serializer);
        $lookup = new Lookup();
        $lookup->setStreet('1600 Amphitheatre Pkwy');
        $lookup->setCity('Mountain View');
        $lookup->setState('CA');
        $lookup->setZipcode('94043');
        $mockHttpClient->addResponse(new Response(200, ['Content-Type' => 'application/json'], '[{"input_id":"24601","input_index":0,"candidate_index":1,"delivery_line_1":"1600 Amphitheatre Pkwy","last_line":"Mountain View, CA 94043","components":{"zipcode":"94043","plus4_code":"1351"},"metadata":{"county_name":"Santa Clara","latitude":37.4224764,"longitude":-122.0842499},"unexpected_field":"unexpected_value"}]'));
        $client->sendLookup($lookup);
        $results = $lookup->getResult();
        $this->assertIsArray($results);
        $this->assertNotEmpty($results);
        // Instead of assertObjectHasAttribute, check for property_exists or method_exists
        $this->assertTrue(property_exists($results[0], 'deliveryLine1') || method_exists($results[0], 'getDeliveryLine1'));
    }
} 