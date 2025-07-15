<?php
require_once __DIR__ . '/../vendor/autoload.php';

use GuzzleHttp\Client as GuzzleClient;
use Http\Factory\Guzzle\RequestFactory;
use Http\Factory\Guzzle\StreamFactory;
use SmartyStreets\PhpSdk\ClientBuilder;
use SmartyStreets\PhpSdk\NativeSerializer;
use SmartyStreets\PhpSdk\US_Reverse_Geo\Lookup;

$example = new USReverseGeoExample();
$example->run();

class USReverseGeoExample {
    public function run() {
        $httpClient = new GuzzleClient();
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();

        $client = (new ClientBuilder($httpClient, $requestFactory, $streamFactory, $serializer))
            ->buildUsReverseGeoApiClient();

        $lookup = new Lookup();
        $lookup->setLatitude(37.4224764);
        $lookup->setLongitude(-122.0842499);

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
            echo("\nNo reverse geo data found.");
            return;
        }
        print_r($result);
    }
}