<?php
require_once __DIR__ . '/../vendor/autoload.php';

use GuzzleHttp\Client as GuzzleClient;
use Http\Factory\Guzzle\RequestFactory;
use Http\Factory\Guzzle\StreamFactory;
use SmartyStreets\PhpSdk\ClientBuilder;
use SmartyStreets\PhpSdk\NativeSerializer;
use SmartyStreets\PhpSdk\US_Street\Lookup;
use SmartyStreets\PhpSdk\Batch;

$example = new UsStreetMultipleAddressesExample();
$example->run();

class UsStreetMultipleAddressesExample
{
    public function run()
    {
        $httpClient = new GuzzleClient();
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();

        $client = (new ClientBuilder($httpClient, $requestFactory, $streamFactory, $serializer))
            ->buildUsStreetApiClient();
        $batch = new Batch();

        $address0 = new Lookup();
        $address0->setInputId("24601");
        $address0->setStreet("1600 amphitheatre parkway");
        $address0->setLastline("Mountain view, California");
        $address0->setMaxCandidates(5);
        $address0->setMatchStrategy(Lookup::INVALID);

        $address1 = new Lookup("1 Rosedale, Baltimore, Maryland");
        $address1->setMaxCandidates(1);

        $address2 = new Lookup("123 Bogus Street, Pretend Lake, Oklahoma");
        $address2->setInputId("8675309");

        $address3 = new Lookup();
        $address3->setStreet("1 Infinite Loop");
        $address3->setZIPCode("95014");

        try {
            $batch->add($address0);
            $batch->add($address1);
            $batch->add($address2);
            $batch->add($address3);

            $client->sendBatch($batch);
            $this->displayResults($batch);
        } catch (\Exception $ex) {
            echo($ex->getMessage());
        }
    }

    public function displayResults(Batch $batch)
    {
        $lookups = $batch->getAllLookups();

        for ($i = 0; $i < $batch->size(); $i++) {
            $candidates = $lookups[$i]->getResult();

            if (empty($candidates)) {
                echo("\nAddress " . $i . " is invalid.\n");
                continue;
            }

            echo("\nAddress " . $i . " has at least one candidate. If the match parameter is set to STRICT, the address is valid. Otherwise, check the Analysis output fields to see if the address is valid.\n");

            foreach ($candidates as $candidate) {
                $components = $candidate->getComponents();
                $metadata = $candidate->getMetadata();

                echo("\n\nCandidate " . $candidate->getCandidateIndex() . ":");
                echo("\nDelivery line 1: " . $candidate->getDeliveryLine1());
                echo("\nLast line:       " . $candidate->getLastLine());
                echo("\nZIP Code:        " . $components->getZIPCode() . "-" . $components->getPlus4Code());
                echo("\nCounty:          " . $metadata->getCountyName());
                echo("\nLatitude:        " . $metadata->getLatitude());
                echo("\nLongitude:       " . $metadata->getLongitude());
            }
            echo("\n***********************************\n");
        }
        echo("\n");
    }
}