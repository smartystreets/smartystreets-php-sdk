<?php

require_once(dirname(dirname(__FILE__)) . '/src/ClientBuilder.php');
require_once(dirname(dirname(__FILE__)) . '/src/US_Street/Lookup.php');
require_once(dirname(dirname(__FILE__)) . '/src/StaticCredentials.php');

use SmartyStreets\PhpSdk\Exceptions\SmartyException;
use SmartyStreets\PhpSdk\Exceptions\BatchFullException;
use SmartyStreets\PhpSdk\StaticCredentials;
use SmartyStreets\PhpSdk\ClientBuilder;
use SmartyStreets\PhpSdk\US_Street\Lookup;
use SmartyStreets\PhpSdk\Batch;

$lookupExample = new UsStreetMultipleAddressesExample();
$lookupExample->run();

class UsStreetMultipleAddressesExample
{
    public function run()
    {


        // $authId = 'Your SmartyStreets Auth ID here';
        // $authToken = 'Your SmartyStreets Auth Token here';

        // We recommend storing your secret keys in environment variables instead---it's safer!
        $authId = getenv('SMARTY_AUTH_ID');
        $authToken = getenv('SMARTY_AUTH_TOKEN');

        $staticCredentials = new StaticCredentials($authId, $authToken);

        // The appropriate license values to be used for your subscriptions
        // can be found on the Subscriptions page the account dashboard.
        // https://www.smartystreets.com/docs/cloud/licensing
        $client = (new ClientBuilder($staticCredentials))->withLicenses(["us-core-cloud"])
            ->buildUsStreetApiClient();
        $batch = new Batch();

        // Documentation for input fields can be found at:
        // https://smartystreets.com/docs/cloud/us-street-api

        $address0 = new Lookup();
        $address0->setInputId("24601"); // Optional ID from your system
        $address0->setStreet("1600 amphitheatre parkway");
        $address0->setLastline("Mountain view, California");
        $address0->setMaxCandidates(5);
        $address0->setMatchStrategy(LOOKUP::INVALID); // "invalid" is the most permissive match,
        // this will always return at least one result even if the address is invalid.
        // Refer to the documentation for additional MatchStrategy options.

        $address1 = new Lookup("1 Rosedale, Baltimore, Maryland"); // Freeform addresses work too.
        $address1->setMaxCandidates(1); // Allows up to ten possible matches to be returned (default is 1).

        $address2 = new Lookup("123 Bogus Street, Pretend Lake, Oklahoma");
        $address2->setInputId("8675309");

        $address3 = new Lookup();
        $address3->setStreet("1 Infinite Loop");
        $address3->setZIPCode("95014"); // You can just input the street and ZIP if you want.

        try {
            $batch->add($address0);
            $batch->add($address1);
            $batch->add($address2);
            $batch->add($address3);

            $client->sendBatch($batch);
            $this->displayResults($batch);
        } catch (BatchFullException $ex) {
            echo("Oops! Batch was already full.");
        } catch (SmartyException $ex) {
            echo($ex->getMessage());
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