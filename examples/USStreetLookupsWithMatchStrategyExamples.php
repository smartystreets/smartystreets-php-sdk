<?php
require_once __DIR__ . '/../vendor/autoload.php';

use GuzzleHttp\Client as GuzzleClient;
use Http\Factory\Guzzle\RequestFactory;
use Http\Factory\Guzzle\StreamFactory;
use SmartyStreets\PhpSdk\ClientBuilder;
use SmartyStreets\PhpSdk\NativeSerializer;
use SmartyStreets\PhpSdk\US_Street\Lookup;

$example = new USStreetLookupsWithMatchStrategyExamples();
$example->run();

class USStreetLookupsWithMatchStrategyExamples {
    public function run() {
        $httpClient = new GuzzleClient();
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();

        $client = (new ClientBuilder($httpClient, $requestFactory, $streamFactory, $serializer))
            ->buildUsStreetApiClient();

        $lookup = new Lookup();
        $lookup->setStreet("1600 Amphitheatre Pkwy");
        $lookup->setCity("Mountain View");
        $lookup->setState("CA");
        $lookup->setMatchStrategy(Lookup::STRICT);

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
            echo("\nNo candidates found.");
            return;
        }
        print_r($results);
    }
}