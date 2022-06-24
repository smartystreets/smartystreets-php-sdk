<?php

require_once(dirname(dirname(__FILE__)) . '/src/ClientBuilder.php');
require_once(dirname(dirname(__FILE__)) . '/src/US_ZIPCode/Lookup.php');
require_once(dirname(dirname(__FILE__)) . '/src/US_ZIPCode/Result.php');
require_once(dirname(dirname(__FILE__)) . '/src/StaticCredentials.php');
require_once(dirname(dirname(__FILE__)) . '/src/SharedCredentials.php');
use SmartyStreets\PhpSdk\Exceptions\SmartyException;
use SmartyStreets\PhpSdk\StaticCredentials;
use SmartyStreets\PhpSdk\US_ZIPCode\Lookup;
use SmartyStreets\PhpSdk\ClientBuilder;

$lookupExample = new UsZIPCodeSingleLookupExample();
$lookupExample->run();

class UsZIPCodeSingleLookupExample {

    public function run() {
        // $authId = 'Your SmartyStreets Auth ID here';
        // $authToken = 'Your SmartyStreets Auth Token here';

        // We recommend storing your secret keys in environment variables instead---it's safer!
        $authId = getenv('SMARTY_AUTH_ID');
        $authToken = getenv('SMARTY_AUTH_TOKEN');

        $staticCredentials = new StaticCredentials($authId, $authToken);
        $client = (new ClientBuilder($staticCredentials))->buildUsZIPCodeApiClient();

        // Documentation for input fields can be found at:
        // https://smartystreets.com/docs/cloud/us-zipcode-api

        $lookup = new Lookup();
        $lookup->setInputId("dfc33cb6-829e-4fea-aa1b-b6d6580f0817"); // Optional ID from you system
        $lookup->setCity("Mountain View");
        $lookup->setState("California");

        try {
            $client->sendLookup($lookup);
            $this->displayResults($lookup);
        }
        catch (SmartyException $ex) {
            echo($ex->getMessage());
        }
        catch (\Exception $ex) {
            echo($ex->getMessage());
        }
    }

    public function displayResults(Lookup $lookup) {
        $result = $lookup->getResult();
        $zipCodes = $result->getZIPCodes();
        $cities = $result->getCities();

        foreach ($cities as $city) {
            echo("\nCity: " . $city->getCity());
            echo("\nState: " . $city->getState());
            echo("\nMailable City: " . json_encode($city->getMailableCity()));
        }

        foreach ($zipCodes as $zip) {
            echo("\n\nZIP Code: " . $zip->getZIPCode());
            echo("\nLatitude: " . $zip->getLatitude());
            echo("\nLongitude: " . $zip->getLongitude());
        }
    }
}