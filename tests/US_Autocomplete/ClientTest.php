<?php

namespace SmartyStreets\PhpSdk\Tests\US_Autocomplete;

require_once(dirname(dirname(__FILE__)) . '/Mocks/MockSerializer.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/MockDeserializer.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/RequestCapturingSender.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/MockStatusCodeSender.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/MockSender.php');
require_once(dirname(dirname(__FILE__)) . '/Mocks/MockCrashingSender.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/URLPrefixSender.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_Autocomplete/Result.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_Autocomplete/Client.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_Autocomplete/Lookup.php');

use SmartyStreets\PhpSdk\Tests\Mocks\MockDeserializer;
use SmartyStreets\PhpSdk\Tests\Mocks\MockSender;
use SmartyStreets\PhpSdk\Tests\Mocks\MockSerializer;
use SmartyStreets\PhpSdk\Tests\Mocks\RequestCapturingSender;
use SmartyStreets\PhpSdk\URLPrefixSender;
use SmartyStreets\PhpSdk\Response;
use SmartyStreets\PhpSdk\US_Autocomplete\Result;
use SmartyStreets\PhpSdk\US_Autocomplete\Client;
use SmartyStreets\PhpSdk\US_Autocomplete\Lookup;
use SmartyStreets\PhpSdk\US_Autocomplete\GeolocateType;
use SmartyStreets\PhpSdk\US_Autocomplete\Suggestion;
use PHPUnit\Framework\TestCase;


class ClientTest extends TestCase {
    //region [ Single Lookup ]

    public function testSendingSinglePrefixOnlyLookup() {
        $capturingSender = new RequestCapturingSender();
        $sender = new URLPrefixSender("http://localhost/", $capturingSender);
        $serializer = new MockSerializer(new Result());
        $client = new Client($sender, $serializer);

        $client->sendLookup(new Lookup('1'));

        $this->assertEquals("http://localhost/?prefix=1&geolocate=true&geolocate_precision=city",
            $capturingSender->getRequest()->getUrl());
    }

    public function testSendingSingleFullyPopulatedLookup() {
        $capturingSender = new RequestCapturingSender();
        $sender = new URLPrefixSender("http://localhost/", $capturingSender);
        $serializer = new MockSerializer(new Result());
        $client = new Client($sender, $serializer);
        $expectedURL = "http://localhost/?prefix=1&suggestions=2&city_filter=3&state_filter=4&prefer=5&prefer_ratio=0.6&geolocate=true&geolocate_precision=state";
        $lookup = new Lookup();
        $lookup->setPrefix('1');
        $lookup->setMaxSuggestions(2);
        $lookup->addCityFilter("3");
        $lookup->addStateFilter("4");
        $lookup->addPrefer("5");
        $lookup->setPreferRatio("0.6");
        $lookup->setGeolocateType(new GeolocateType(GEOLOCATE_TYPE_STATE));

        $client->sendLookup($lookup);

        $this->assertEquals($expectedURL, $capturingSender->getRequest()->getUrl());
    }

    public function testSendingLookupWithGeolocateTypeSetToNone() {
        $capturingSender = new RequestCapturingSender();
        $sender = new URLPrefixSender("http://localhost/", $capturingSender);
        $serializer = new MockSerializer(new Result());
        $expectedURL = "http://localhost/?prefix=1&geolocate=false";
        $client = new Client($sender, $serializer);
        $lookup = new Lookup();
        $lookup->setPrefix('1');
        $lookup->setGeolocateType(new GeolocateType(GEOLOCATE_TYPE_NONE));

        $client->sendLookup($lookup);

        $this->assertEquals($expectedURL, $capturingSender->getRequest()->getUrl());
    }

    //endregion

    //region [ Response Handling ]

    public function testDeserializeCalledWithResponseBody() {
        $response = new Response(0, "Hello, World!");
        $mockSender = new MockSender($response);
        $sender = new URLPrefixSender("http://localhost/", $mockSender);
        $deserializer = new MockDeserializer(null);
        $client = new Client($sender, $deserializer);

        $client->sendLookup(new Lookup('1'));

        $this->assertEquals($response->getPayload(), $deserializer->getPayload());
    }

    public function testResultCorrectlyAssignedToCorrespondingLookup() {
        $rawSuggestions = array(array('text' => '1'), array('text' => '2'));
        $rawResult = array('suggestions' => $rawSuggestions);
        $expectedResult = new Result($rawResult);

        $lookup = new Lookup('1');

        $mockSender = new MockSender(new Response(0, "{[]}"));
        $sender = new URLPrefixSender("http://localhost/", $mockSender);
        $deserializer = new MockDeserializer($rawResult);
        $client = new Client($sender, $deserializer);

        $client->sendLookup($lookup);

        $this->assertEquals($expectedResult->getSuggestions()[0]->getText(), $lookup->getResult()[0]->getText());
        $this->assertEquals($expectedResult->getSuggestions()[1]->getText(), $lookup->getResult()[1]->getText());
    }

    //endregion
}
