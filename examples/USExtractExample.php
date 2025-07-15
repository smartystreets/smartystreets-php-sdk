<?php
require_once __DIR__ . '/../vendor/autoload.php';

use GuzzleHttp\Client as GuzzleClient;
use Http\Factory\Guzzle\RequestFactory;
use Http\Factory\Guzzle\StreamFactory;
use SmartyStreets\PhpSdk\ClientBuilder;
use SmartyStreets\PhpSdk\NativeSerializer;
use SmartyStreets\PhpSdk\US_Extract\Lookup;

$example = new USExtractExample();
$example->run();

class USExtractExample {
    public function run() {
        $httpClient = new GuzzleClient();
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();

        $client = (new ClientBuilder($httpClient, $requestFactory, $streamFactory, $serializer))
            ->buildUsExtractApiClient();

        $lookup = new Lookup();
        $lookup->setText("Here is some text with an address: 1600 Amphitheatre Pkwy, Mountain View, CA 94043.");

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
            echo("\nNo addresses found.");
            return;
        }
        print_r($result);
    }
}