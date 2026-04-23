<?php

namespace SmartyStreets\PhpSdk\Tests\US_Enrichment;

require_once(dirname(dirname(__FILE__)) . '/Mocks/MockSerializer.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/MockDeserializer.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/RequestCapturingSender.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/MockSender.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_Enrichment/Client.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_Enrichment/Business/Summary/Lookup.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_Enrichment/Business/Detail/Lookup.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/URLPrefixSender.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/Response.php');

use PHPUnit\Framework\TestCase;
use SmartyStreets\PhpSdk\Exceptions\SmartyException;
use SmartyStreets\PhpSdk\Response;
use SmartyStreets\PhpSdk\Tests\Mocks\MockDeserializer;
use SmartyStreets\PhpSdk\Tests\Mocks\MockSender;
use SmartyStreets\PhpSdk\Tests\Mocks\MockSerializer;
use SmartyStreets\PhpSdk\Tests\Mocks\RequestCapturingSender;
use SmartyStreets\PhpSdk\URLPrefixSender;
use SmartyStreets\PhpSdk\US_Enrichment\Business\Detail\Lookup as DetailLookup;
use SmartyStreets\PhpSdk\US_Enrichment\Business\Summary\Lookup as SummaryLookup;
use SmartyStreets\PhpSdk\US_Enrichment\Client;

class BusinessClientTest extends TestCase {

    // region Summary URL shape

    public function testSendingBusinessLookupBySmartyKey() {
        $capturing = new RequestCapturingSender();
        $client = new Client(new URLPrefixSender("http://localhost", $capturing), new MockSerializer(null));

        $client->sendBusinessLookup("1");

        $this->assertEquals("http://localhost/lookup/1/business?", $capturing->getRequest()->getUrl());
    }

    public function testSendingBusinessComponentsLookup() {
        $capturing = new RequestCapturingSender();
        $client = new Client(new URLPrefixSender("http://localhost", $capturing), new MockSerializer(null));

        $lookup = new SummaryLookup();
        $lookup->setStreet("street");
        $lookup->setCity("city");
        $lookup->setState("state");
        $lookup->setZipcode("zipcode");

        $client->sendBusinessLookup($lookup);

        $this->assertEquals(
            "http://localhost/lookup/search/business?street=street&city=city&state=state&zipcode=zipcode",
            $capturing->getRequest()->getUrl()
        );
    }

    public function testSendingBusinessFreeformLookup() {
        $capturing = new RequestCapturingSender();
        $client = new Client(new URLPrefixSender("http://localhost", $capturing), new MockSerializer(null));

        $lookup = new SummaryLookup();
        $lookup->setFreeform("freeform");

        $client->sendBusinessLookup($lookup);

        $this->assertEquals("http://localhost/lookup/search/business?freeform=freeform", $capturing->getRequest()->getUrl());
    }

    // endregion

    // region Detail URL shape

    public function testSendingBusinessDetailLookupByBusinessId() {
        $capturing = new RequestCapturingSender();
        $client = new Client(new URLPrefixSender("http://localhost", $capturing), new MockSerializer(null));

        $client->sendBusinessDetailLookup("ABC123");

        $this->assertEquals("http://localhost/business/ABC123?", $capturing->getRequest()->getUrl());
    }

    public function testBusinessDetailUrlEncodesReservedChars() {
        $capturing = new RequestCapturingSender();
        $client = new Client(new URLPrefixSender("http://localhost", $capturing), new MockSerializer(null));

        $client->sendBusinessDetailLookup("a/b?c#d");

        $this->assertEquals("http://localhost/business/a%2Fb%3Fc%23d?", $capturing->getRequest()->getUrl());
    }

    public function testBusinessDetailSendsEtagHeader() {
        $capturing = new RequestCapturingSender();
        $client = new Client(new URLPrefixSender("http://localhost", $capturing), new MockSerializer(null));

        $lookup = new DetailLookup("ABC123");
        $lookup->setRequestEtag("xyz-789");

        $client->sendBusinessDetailLookup($lookup);

        $headers = $capturing->getRequest()->getHeaders();
        $this->assertArrayHasKey('Etag', $headers);
        $this->assertEquals("xyz-789", $headers['Etag']);
    }

    public function testBusinessDetailIncludeFieldsLandInUrl() {
        $capturing = new RequestCapturingSender();
        $client = new Client(new URLPrefixSender("http://localhost", $capturing), new MockSerializer(null));

        $lookup = new DetailLookup("ABC123");
        $lookup->addIncludeAttribute("phone");

        $client->sendBusinessDetailLookup($lookup);

        $this->assertEquals("http://localhost/business/ABC123?include=phone", $capturing->getRequest()->getUrl());
    }

    public function testBusinessDetailExcludeFieldsLandInUrl() {
        $capturing = new RequestCapturingSender();
        $client = new Client(new URLPrefixSender("http://localhost", $capturing), new MockSerializer(null));

        $lookup = new DetailLookup("ABC123");
        $lookup->addExcludeAttribute("credit_score");

        $client->sendBusinessDetailLookup($lookup);

        $this->assertEquals("http://localhost/business/ABC123?exclude=credit_score", $capturing->getRequest()->getUrl());
    }

    public function testBusinessDetailCustomParametersLandInUrl() {
        $capturing = new RequestCapturingSender();
        $client = new Client(new URLPrefixSender("http://localhost", $capturing), new MockSerializer(null));

        $lookup = new DetailLookup("ABC123");
        $lookup->addCustomParameter("experimental", "1");
        $lookup->addCustomParameter("trace", "on");

        $client->sendBusinessDetailLookup($lookup);

        $this->assertEquals(
            "http://localhost/business/ABC123?experimental=1&trace=on",
            $capturing->getRequest()->getUrl()
        );
    }

    public function testBusinessDetailIncludeExcludeAndCustomCombined() {
        $capturing = new RequestCapturingSender();
        $client = new Client(new URLPrefixSender("http://localhost", $capturing), new MockSerializer(null));

        $lookup = new DetailLookup("ABC123");
        $lookup->addIncludeAttribute("phone");
        $lookup->addExcludeAttribute("credit_score");
        $lookup->addCustomParameter("trace", "on");

        $client->sendBusinessDetailLookup($lookup);

        $this->assertEquals(
            "http://localhost/business/ABC123?include=phone&exclude=credit_score&trace=on",
            $capturing->getRequest()->getUrl()
        );
    }

    // endregion

    // region Validation

    public function testRejectEmptyBusinessId() {
        $client = new Client(new URLPrefixSender("http://localhost", new RequestCapturingSender()), new MockSerializer(null));
        $this->expectException(SmartyException::class);
        $client->sendBusinessDetailLookup("");
    }

    public function testRejectNullBusinessId() {
        $client = new Client(new URLPrefixSender("http://localhost", new RequestCapturingSender()), new MockSerializer(null));
        $this->expectException(SmartyException::class);
        $client->sendBusinessDetailLookup(null);
    }

    public function testRejectWhitespaceBusinessId() {
        $client = new Client(new URLPrefixSender("http://localhost", new RequestCapturingSender()), new MockSerializer(null));
        $this->expectException(SmartyException::class);
        $client->sendBusinessDetailLookup("   ");
    }

    public function testRejectWhitespaceSmartyKeyOnSummaryLookup() {
        $client = new Client(new URLPrefixSender("http://localhost", new RequestCapturingSender()), new MockSerializer(null));
        $this->expectException(SmartyException::class);
        $client->sendBusinessLookup("   ");
    }

    public function testRejectWhitespaceOnAllStandardLookupFields() {
        $client = new Client(new URLPrefixSender("http://localhost", new RequestCapturingSender()), new MockSerializer(null));
        $lookup = new SummaryLookup("   ");
        $lookup->setStreet("   ");
        $lookup->setFreeform("   ");
        $this->expectException(SmartyException::class);
        $client->sendBusinessLookup($lookup);
    }

    // endregion

    // region Detail deserialization contract

    public function testBusinessDetailRejectsMultipleResults() {
        $lookup = new DetailLookup("ABC");
        try {
            $lookup->buildResults([
                ['smarty_key' => '1'],
                ['smarty_key' => '2'],
            ]);
            $this->fail("Expected SmartyException");
        } catch (SmartyException $ex) {
            $this->assertNull($lookup->getResult());
        }
    }

    public function testBusinessDetailAcceptsSingleResult() {
        $lookup = new DetailLookup("ABC");
        $lookup->buildResults([
            [
                'smarty_key' => '7',
                'data_set_name' => 'business',
                'business_id' => 'ABC',
                'attributes' => ['company_name' => 'Acme Corp'],
            ],
        ]);

        $result = $lookup->getResult();
        $this->assertNotNull($result);
        $this->assertEquals('ABC', $result->businessId);
        $this->assertNotNull($result->attributes);
        $this->assertEquals('Acme Corp', $result->attributes->companyName);
    }

    public function testBusinessDetailAcceptsEmptyResults() {
        $lookup = new DetailLookup("ABC");
        $lookup->buildResults([]);
        $this->assertNull($lookup->getResult());
    }

    // endregion

    // region ETag response-capture (200 path)

    public function testBusinessDetailCapturesResponseEtagOnLookup() {
        $response = new Response(200, '[]', ['Etag' => 'server-etag-1']);
        $client = new Client(new MockSender($response), new MockDeserializer([]));

        $lookup = new DetailLookup("ABC");
        $client->sendBusinessDetailLookup($lookup);

        $this->assertEquals("server-etag-1", $lookup->getResponseEtag());
    }

    public function testResponseEtagDoesNotClobberRequestEtag() {
        $response = new Response(200, '[]', ['Etag' => 'server-etag-2']);
        $client = new Client(new MockSender($response), new MockDeserializer([]));

        $lookup = new DetailLookup("ABC");
        $lookup->setRequestEtag("caller-etag");

        $client->sendBusinessDetailLookup($lookup);

        $this->assertEquals("caller-etag", $lookup->getRequestEtag());
        $this->assertEquals("server-etag-2", $lookup->getResponseEtag());
    }

    public function testBusinessDetailCaseInsensitiveResponseEtagHeader() {
        $response = new Response(200, '[]', ['ETAG' => 'standard-cased-etag']);
        $client = new Client(new MockSender($response), new MockDeserializer([]));

        $lookup = new DetailLookup("ABC");
        $client->sendBusinessDetailLookup($lookup);

        $this->assertEquals("standard-cased-etag", $lookup->getResponseEtag());
    }

    public function testSummaryCapturesResponseEtagOnLookup() {
        $response = new Response(200, '[]', ['Etag' => 'server-etag-summary']);
        $client = new Client(new MockSender($response), new MockDeserializer([]));

        $lookup = new SummaryLookup("1");
        $client->sendBusinessLookup($lookup);

        $this->assertEquals("server-etag-summary", $lookup->getResponseEtag());
    }

    public function testResponseEtagNullWhenHeaderAbsent() {
        $response = new Response(200, '[]', []);
        $client = new Client(new MockSender($response), new MockDeserializer([]));

        $lookup = new DetailLookup("ABC");
        $lookup->setRequestEtag("caller-etag");

        $client->sendBusinessDetailLookup($lookup);

        $this->assertEquals("caller-etag", $lookup->getRequestEtag());
        $this->assertNull($lookup->getResponseEtag());
    }

    // endregion

    // region Payload hydration round-trips

    public function testSummaryHydratesBusinessEntriesFromPayload() {
        $response = new Response(200, '[]', []);
        $serializer = new MockDeserializer([
            [
                'smarty_key' => '1962995076',
                'data_set_name' => 'business',
                'businesses' => [
                    ['company_name' => 'Acme Corp', 'business_id' => 'B1'],
                    ['company_name' => 'Other Inc', 'business_id' => 'B2'],
                ],
            ],
        ]);
        $client = new Client(new MockSender($response), $serializer);

        $results = $client->sendBusinessLookup("1962995076");

        $this->assertCount(1, $results);
        $this->assertEquals('1962995076', $results[0]->smartyKey);
        $this->assertCount(2, $results[0]->businesses);
        $this->assertEquals('Acme Corp', $results[0]->businesses[0]->companyName);
        $this->assertEquals('B1', $results[0]->businesses[0]->businessId);
        $this->assertEquals('Other Inc', $results[0]->businesses[1]->companyName);
    }

    public function testDetailHydratesAttributesFromPayload() {
        $response = new Response(200, '[]', []);
        $serializer = new MockDeserializer([
            [
                'smarty_key' => '7',
                'data_set_name' => 'business',
                'business_id' => 'ABC',
                'attributes' => [
                    'company_name' => 'Acme Corp',
                    'phone' => '555-1212',
                    'fortune_1000_rank' => '42',
                    'naics_01_code' => '111110',
                ],
            ],
        ]);
        $client = new Client(new MockSender($response), $serializer);

        $result = $client->sendBusinessDetailLookup("ABC");

        $this->assertNotNull($result);
        $this->assertEquals('ABC', $result->businessId);
        $this->assertEquals('Acme Corp', $result->attributes->companyName);
        $this->assertEquals('555-1212', $result->attributes->phone);
        $this->assertEquals('42', $result->attributes->fortune1000Rank);
        $this->assertEquals('111110', $result->attributes->naics01Code);
    }

    public function testDetailReturnsNullWhenPayloadIsEmpty() {
        $serializer = new MockDeserializer([]);
        $client = new Client(new MockSender(new Response(200, '[]', [])), $serializer);

        $result = $client->sendBusinessDetailLookup("ABC");

        $this->assertNull($result);
    }

    // endregion
}
