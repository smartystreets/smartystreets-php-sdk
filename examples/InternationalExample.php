<?php
require_once __DIR__ . '/../vendor/autoload.php';

use GuzzleHttp\Client as GuzzleClient;
use Http\Factory\Guzzle\RequestFactory;
use Http\Factory\Guzzle\StreamFactory;
use SmartyStreets\PhpSdk\ClientBuilder;
use SmartyStreets\PhpSdk\NativeSerializer;
use SmartyStreets\PhpSdk\International_Street\Lookup;

$example = new InternationalExample();
$example->run();

class InternationalExample {
    public function run() {
        $httpClient = new GuzzleClient();
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();

        $client = (new ClientBuilder($httpClient, $requestFactory, $streamFactory, $serializer))
            ->buildInternationalStreetApiClient();

        $lookup = new Lookup();
        $lookup->setCountry("GB");
        $lookup->setFreeform("10 Downing St, London");

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
            echo("\nNo candidates found.");
            return;
        }
        print_r($result);
    }
}