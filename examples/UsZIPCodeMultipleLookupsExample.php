<?php
require_once __DIR__ . '/../vendor/autoload.php';

use GuzzleHttp\Client as GuzzleClient;
use Http\Factory\Guzzle\RequestFactory;
use Http\Factory\Guzzle\StreamFactory;
use SmartyStreets\PhpSdk\ClientBuilder;
use SmartyStreets\PhpSdk\NativeSerializer;
use SmartyStreets\PhpSdk\US_ZIPCode\Lookup;

$example = new UsZIPCodeMultipleLookupsExample();
$example->run();

class UsZIPCodeMultipleLookupsExample {
    public function run() {
        $httpClient = new GuzzleClient();
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();

        $client = (new ClientBuilder($httpClient, $requestFactory, $streamFactory, $serializer))
            ->buildUsZIPCodeApiClient();

        $lookup1 = new Lookup();
        $lookup1->setCity("Mountain View");
        $lookup1->setState("CA");
        $lookup1->setZipCode("94043");

        $lookup2 = new Lookup();
        $lookup2->setCity("Provo");
        $lookup2->setState("UT");
        $lookup2->setZipCode("84604");

        try {
            $client->sendLookup($lookup1);
            $client->sendLookup($lookup2);
            $this->displayResults($lookup1);
            $this->displayResults($lookup2);
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
        print_r($result);
    }
}