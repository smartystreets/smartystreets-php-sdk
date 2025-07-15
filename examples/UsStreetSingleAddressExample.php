<?php

require_once __DIR__ . '/../vendor/autoload.php';

use GuzzleHttp\Client as GuzzleClient;
use Http\Factory\Guzzle\RequestFactory;
use Http\Factory\Guzzle\StreamFactory;
use SmartyStreets\PhpSdk\ClientBuilder;
use SmartyStreets\PhpSdk\NativeSerializer;
use SmartyStreets\PhpSdk\US_Street\Lookup;

$lookupExample = new UsStreetSingleAddressExample();
$lookupExample->run();

class UsStreetSingleAddressExample {
    public function run() {
        $httpClient = new GuzzleClient();
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();

        $client = (new ClientBuilder($httpClient, $requestFactory, $streamFactory, $serializer))
            ->buildUsStreetApiClient();

        $lookup = new Lookup();
        $lookup->setInputId("24601");
        $lookup->setAddressee("John Doe");
        $lookup->setStreet("1600 Amphitheatre Pkwy");
        $lookup->setStreet2("closet under the stairs");
        $lookup->setSecondary("APT 2");
        $lookup->setUrbanization("");
        $lookup->setCity("Mountain View");
        $lookup->setState("CA");
        $lookup->setZipcode("21229");
        $lookup->setMaxCandidates(3);
        $lookup->setCountySource(Lookup::GEOGRAPHIC);
        $lookup->setMatchStrategy(Lookup::INVALID);

        try {
            $client->sendLookup($lookup);
            $this->displayResults($lookup);
        } catch (Exception $ex) {
            echo($ex->getMessage());
        }
    }

    public function displayResults(Lookup $lookup) {
        $results = $lookup->getResult();

        if (empty($results)) {
            echo("\nNo candidates. This means the address is not valid.");
            return;
        }

        $firstCandidate = $results[0];

        echo("\nThere is at least one candidate. If the match parameter is set to STRICT, the address is valid. Otherwise, check the Analysis output fields to see if the address is valid.\n");
        echo("\nZIP Code: " . $firstCandidate->getComponents()->getZIPCode());
        echo("\nCounty: " . $firstCandidate->getMetadata()->getCountyName());
        echo("\nLatitude: " . $firstCandidate->getMetadata()->getLatitude());
        echo("\nLongitude: " . $firstCandidate->getMetadata()->getLongitude());
    }
}