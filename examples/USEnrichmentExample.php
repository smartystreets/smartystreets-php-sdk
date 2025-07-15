<?php
require_once __DIR__ . '/../vendor/autoload.php';

use GuzzleHttp\Client as GuzzleClient;
use Http\Factory\Guzzle\RequestFactory;
use Http\Factory\Guzzle\StreamFactory;
use SmartyStreets\PhpSdk\ClientBuilder;
use SmartyStreets\PhpSdk\NativeSerializer;
use SmartyStreets\PhpSdk\US_Enrichment\Lookup;

$example = new USEnrichmentExample();
$example->run();

class USEnrichmentExample {
    public function run() {
        $httpClient = new GuzzleClient();
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();

        $client = (new ClientBuilder($httpClient, $requestFactory, $streamFactory, $serializer))
            ->buildUsEnrichmentApiClient();

        $lookup = new Lookup();
        $lookup->setAddress("1600 Amphitheatre Pkwy, Mountain View, CA 94043");

        try {
            $client->sendLookup($lookup);
            $this->displayResults($lookup);
        } catch (Exception $ex) {
            echo($ex->getMessage());
        }
    }

    public function displayResults(Lookup $lookup) {
        $result = $lookup->getResponse();
        if (empty($result)) {
            echo("\nNo enrichment data found.");
            return;
        }
        print_r($result);
    }
}