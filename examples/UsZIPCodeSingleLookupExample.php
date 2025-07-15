<?php

require_once __DIR__ . '/../vendor/autoload.php';

use GuzzleHttp\Client as GuzzleClient;
use Http\Factory\Guzzle\RequestFactory;
use Http\Factory\Guzzle\StreamFactory;
use SmartyStreets\PhpSdk\ClientBuilder;
use SmartyStreets\PhpSdk\NativeSerializer;
use SmartyStreets\PhpSdk\US_ZIPCode\Lookup;

$example = new UsZIPCodeSingleLookupExample();
$example->run();

class UsZIPCodeSingleLookupExample {
    public function run() {
        $httpClient = new GuzzleClient();
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();

        $client = (new ClientBuilder($httpClient, $requestFactory, $streamFactory, $serializer))
            ->buildUsZIPCodeApiClient();

        $lookup = new Lookup();
        $lookup->setCity("Mountain View");
        $lookup->setState("CA");
        $lookup->setZipCode("94043");

        try {
            $client->sendLookup($lookup);
            $this->displayResults($lookup);
        } catch (Exception $ex) {
            echo($ex->getMessage());
        }
    }

    public function displayResults(Lookup $lookup) {
        $result = $lookup->getResult();
        if (empty($result)) {
            echo("\nNo results found.");
            return;
        }
        $firstResult = $result[0];
        echo("\nCity: " . $firstResult->getCity());
        echo("\nState: " . $firstResult->getState());
        echo("\nZIP Code: " . $firstResult->getZipCode());
    }
}