<?php

require_once(dirname(dirname(__FILE__)) . '/src/ClientBuilder.php');
require_once(dirname(dirname(__FILE__)) . '/src/US_ZIPCode/Lookup.php');
require_once(dirname(dirname(__FILE__)) . '/src/US_ZIPCode/Result.php');
require_once(dirname(dirname(__FILE__)) . '/src/StaticCredentials.php');
require_once(dirname(dirname(__FILE__)) . '/src/SharedCredentials.php');
use SmartyStreets\PhpSdk\Exceptions\SmartyException;
use SmartyStreets\PhpSdk\Exceptions\BatchFullException;
use SmartyStreets\PhpSdk\StaticCredentials;
use SmartyStreets\PhpSdk\US_ZIPCode\Lookup;
use SmartyStreets\PhpSdk\ClientBuilder;
use SmartyStreets\PhpSdk\Batch;

$lookupExample = new UsZIPCodeMultipleLookupsExample();
$lookupExample->run();

class UsZIPCodeMultipleLookupsExample {

    public function run() {
        // $authId = 'Your SmartyStreets Auth ID here';
        // $authToken = 'Your SmartyStreets Auth Token here';

        // We recommend storing your secret keys in environment variables instead---it's safer!
        $authId = getenv('SMARTY_AUTH_ID');
        $authToken = getenv('SMARTY_AUTH_TOKEN');

        $staticCredentials = new StaticCredentials($authId, $authToken);
        $client = (new ClientBuilder($staticCredentials))->buildUsZIPCodeApiClient();
        $batch = new Batch();

        // Documentation for input fields can be found at:
        // https://smartystreets.com/docs/cloud/us-zipcode-api

        $lookup0 = new Lookup();
        $lookup0->setZIPCode("12345");  // A Lookup may have a ZIP Code, city and state, or city, state, and ZIP Code

        $lookup1 = new Lookup();
        $lookup1->setInputId("01189998819991197253"); // Optional ID from your system
        $lookup1->setCity("Phoenix");
        $lookup1->setState("Arizona");
        $lookup1->setZIPCode("01234");

        $lookup2 = new Lookup("cupertino", "CA", "95014"); // You can also set these with arguments

        try {
            $batch->add($lookup0);
            $batch->add($lookup1);
            $batch->add($lookup2);

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
            $result = $lookups[$i]->getResult();
            echo("\nLookup " . $i . ":\n");

            if ($result->getStatus() != null) {
                echo("Status: " . $result->getStatus());
                echo("Reason: " . $result->getReason());
                continue;
            }

            $cities = $result->getCities();
            echo "\n" . count($cities) . " City and State match(es):";

            foreach ($cities as $city) {
                echo("\nCity: " . $city->getCity());
                echo("\nState: " . $city->getState());
                echo("\nMailable City: " . json_encode($city->getMailableCity()));
                echo("\n");
            }

            $zipCodes = $result->getZIPCodes();
            echo "\n" . count($zipCodes) . " ZIP Code match(es):";

            foreach ($zipCodes as $zip) {
                echo("\nZIP Code: " . $zip->getZIPCode());
                echo("\nCounty: " . $zip->getCountyName());
                echo("\nLatitude: " . $zip->getLatitude());
                echo("\nLongitude: " . $zip->getLongitude());
                echo("\n");
            }
            echo("\n***********************************");
        }
    }
}