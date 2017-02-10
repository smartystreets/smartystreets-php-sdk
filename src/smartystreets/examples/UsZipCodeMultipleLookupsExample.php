<?php

namespace smartystreets\examples;

require_once(dirname(dirname(__FILE__)) . '/api/us_zipcode/ClientBuilder.php');
require_once(dirname(dirname(__FILE__)) . '/api/us_zipcode/Lookup.php');
require_once(dirname(dirname(__FILE__)) . '/api/us_zipcode/Result.php');
require_once(dirname(dirname(__FILE__)) . '/api/StaticCredentials.php');
require_once(dirname(dirname(__FILE__)) . '/api/SharedCredentials.php');
use smartystreets\api\exceptions\SmartyException;
use smartystreets\api\StaticCredentials;
use smartystreets\api\us_zipcode\Batch;
use smartystreets\api\us_zipcode\Lookup;
use smartystreets\api\us_zipcode\ClientBuilder;

$lookupExample = new UsZipCodeMultipleLookupsExample();
$lookupExample->run();

class UsZipCodeMultipleLookupsExample {

    public function run() {
        $staticCredentials = new StaticCredentials(getenv('SMARTY_AUTH_ID'), getenv('SMARTY_AUTH_TOKEN'));
        $client = (new ClientBuilder($staticCredentials))->build();
        $batch = new Batch();

        $lookup0 = new Lookup();
        $lookup0->setZipCode("12345");  // A Lookup may have a ZIP Code, city and state, or city, state, and ZIP Code

        $lookup1 = new Lookup();
        $lookup1->setCity("Phoenix");
        $lookup1->setState("Arizona");

        $lookup2 = new Lookup("cupertino", "CA", "95014"); // You can also set these with arguments

        try {
            $batch->add($lookup0);
            $batch->add($lookup1);
            $batch->add($lookup2);

            $client->sendBatch($batch);
            $this->displayResults($batch);
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
//            echo("\n");
            echo "\n" . count($cities) . " City and State match(es):";

            foreach ($cities as $city) {
                echo("\nCity: " . $city->getCity());
                echo("\nState: " . $city->getState());
                echo("\nMailable City: " . json_encode($city->getMailableCity()));
                echo("\n");
            }

            $zipCodes = $result->getZipCodes();
            echo "\n" . count($zipCodes) . " ZIP Code match(es):";

            foreach ($zipCodes as $zip) {
                echo("\nZIP Code: " . $zip->getZipCode());
                echo("\nCounty: " . $zip->getCountyName());
                echo("\nLatitude: " . $zip->getLatitude());
                echo("\nLongitude: " . $zip->getLongitude());
                echo("\n");
            }
            echo("\n***********************************");
        }
    }
}