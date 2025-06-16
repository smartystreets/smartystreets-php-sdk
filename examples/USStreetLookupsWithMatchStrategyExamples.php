<?php

require_once(__DIR__ . '/../src/ClientBuilder.php');
require_once(__DIR__ . '/../src/US_Street/Lookup.php');
require_once(__DIR__ . '/../src/StaticCredentials.php');
use SmartyStreets\PhpSdk\Exceptions\SmartyException;
use SmartyStreets\PhpSdk\Exceptions\BatchFullException;
use SmartyStreets\PhpSdk\StaticCredentials;
use SmartyStreets\PhpSdk\ClientBuilder;
use SmartyStreets\PhpSdk\US_Street\Lookup;
use SmartyStreets\PhpSdk\Batch;

$lookupExample = new USStreetLookupsWithMatchStrategyExamples();
$lookupExample->run();

class USStreetLookupsWithMatchStrategyExamples {

    public function run() {
        $staticCredentials = new StaticCredentials(getenv('SMARTY_AUTH_ID'), getenv('SMARTY_AUTH_TOKEN'));

        // The appropriate license values to be used for your subscriptions
        // can be found on the Subscriptions page the account dashboard.
        // https://www.smartystreets.com/docs/cloud/licensing
        $client = (new ClientBuilder($staticCredentials)) ->withLicenses(["us-core-cloud"])
            ->buildUsStreetApiClient();
        $batch = new Batch();

        $addressWithStrictStrategy = new Lookup();
        $addressWithStrictStrategy->setStreet("691 W 1150 S");
        $addressWithStrictStrategy->setCity("provo");
        $addressWithStrictStrategy->setState("utah");
        $addressWithStrictStrategy->setMatchStrategy(Lookup::STRICT);

        // Uncomment the below line to add a custom parameter to the API call
        // $addressWithStrictStrategy->addCustomParameter("parameter", "value");

        $addressWithInvalidStrategy = new Lookup();
        $addressWithInvalidStrategy->setStreet("693 W 1150 S");
        $addressWithInvalidStrategy->setCity("provo");
        $addressWithInvalidStrategy->setState("utah");
        $addressWithInvalidStrategy->setMatchStrategy(Lookup::INVALID);

        $addressWithEnhancedStrategy = new Lookup();
        $addressWithEnhancedStrategy->setStreet("9999 W 1150 S");
        $addressWithEnhancedStrategy->setCity("provo");
        $addressWithEnhancedStrategy->setState("utah");
        $addressWithEnhancedStrategy->setMatchStrategy(Lookup::ENHANCED);

        try {
            $batch->add($addressWithStrictStrategy);
            $batch->add($addressWithInvalidStrategy);
            $batch->add($addressWithEnhancedStrategy);

            $client->sendBatch($batch);
            $this->displayResults($batch);
        }
        catch (BatchFullException $ex) {
            echo("Oops! Batch was already full.");
        }
        catch (\Exception $ex) {
            echo($ex->getMessage());
        }
    }

    public function displayResults(Batch $batch) {
        $lookups = $batch->getAllLookups();

        for($i = 0; $i < $batch->size(); $i++) {
            $candidates = $lookups[$i]->getResult();

            if (empty($candidates)) {
                echo("\nAddress " . $i . " is invalid.\n");
                continue;
            }

            echo("\nAddress " . $i . " has at least one candidate. If the match parameter is set to STRICT, the address is valid. Otherwise, check the Analysis output fields to see if the address is valid.\n");

            foreach ($candidates as $candidate) {
                $components = $candidate->getComponents();
                $metadata = $candidate->getMetadata();

                echo("\n\nCandidate " . $candidate->getCandidateIndex() . " ");
                echo("with " . $lookups[$i]->getMatchStrategy() . " strategy");
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