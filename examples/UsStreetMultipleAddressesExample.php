<?php

require_once(dirname(dirname(__FILE__)) . '/src/ClientBuilder.php');
require_once(dirname(dirname(__FILE__)) . '/src/us_street/Lookup.php');
require_once(dirname(dirname(__FILE__)) . '/src/StaticCredentials.php');
use SmartyStreets\Exceptions\SmartyException;
use SmartyStreets\Exceptions\BatchFullException;
use SmartyStreets\StaticCredentials;
use SmartyStreets\ClientBuilder;
use SmartyStreets\US_Street\Lookup;
use SmartyStreets\Batch;

$lookupExample = new UsStreetMultipleAddressesExample();
$lookupExample->run();

class UsStreetMultipleAddressesExample {
    public function run() {
        $staticCredentials = new StaticCredentials(getenv('SMARTY_AUTH_ID'), getenv('SMARTY_AUTH_TOKEN'));
        $client = (new ClientBuilder($staticCredentials))->buildStreetClient();
        $batch = new Batch();

        $address0 = new Lookup();
        $address0->setStreet("1600 amphitheatre parkway");
        $address0->setCity("Mountain view");
        $address0->setState("california");

        $address1 = new Lookup("1 Rosedale, Baltimore, Maryland"); // Freeform addresses work too.
        $address1->setMaxCandidates(10); // Allows up to ten possible matches to be returned (default is 1).

        $address2 = new Lookup("123 Bogus Street, Pretend Lake, Oklahoma");

        $address3 = new Lookup();
        $address3->setStreet("1 Infinite Loop");
        $address3->setZipCode("95014"); // You can just input the street and ZIP if you want.

        try {
            $batch->add($address0);
            $batch->add($address1);
            $batch->add($address2);
            $batch->add($address3);

            $client->sendBatch($batch);
            $this->displayResults($batch);
        }
        catch (BatchFullException $ex) {
            echo("Oops! Batch was already full.");
        }
        catch (SmartyException $ex) {
            echo($ex->getMessage());
        }
        catch (\Exception $ex) {
            echo($ex->getMessage());
        }
    }

    public function displayResults(Batch $batch) {
        $lookups = $batch->getAllLookups();

        for ($i = 0; $i < $batch->size(); $i++) {
            $candidates = $lookups[$i]->getResult();

            if (empty($candidates)) {
                echo("\nAddress " . $i . " is invalid.\n");
                continue;
            }

            echo("\nAddress " . $i . " is valid. (There is at least one candidate)");

            foreach ($candidates as $candidate) {
                $components = $candidate->getComponents();
                $metadata = $candidate->getMetadata();

                echo("\n\nCandidate " . $candidate->getCandidateIndex() . ":");
                echo("\nDelivery line 1: " . $candidate->getDeliveryLine1());
                echo("\nLast line:       " . $candidate->getLastLine());
                echo("\nZIP Code:        " . $components->getZipCode() . "-" . $components->getPlus4Code());
                echo("\nCounty:          " . $metadata->getCountyName());
                echo("\nLatitude:        " . $metadata->getLatitude());
                echo("\nLongitude:       " . $metadata->getLongitude());
            }
            echo("\n***********************************\n");
        }
        echo("\n");
    }
}
