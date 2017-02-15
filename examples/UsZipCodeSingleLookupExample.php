<?php

require_once(dirname(dirname(__FILE__)) . '/src/ClientBuilder.php');
require_once(dirname(dirname(__FILE__)) . '/src/us_zipcode/Lookup.php');
require_once(dirname(dirname(__FILE__)) . '/src/us_zipcode/Result.php');
require_once(dirname(dirname(__FILE__)) . '/src/StaticCredentials.php');
require_once(dirname(dirname(__FILE__)) . '/src/SharedCredentials.php');
use SmartyStreets\Exceptions\SmartyException;
use SmartyStreets\StaticCredentials;
use SmartyStreets\US_ZipCode\Lookup;
use SmartyStreets\ClientBuilder;

$lookupExample = new UsZipCodeSingleLookupExample();
$lookupExample->run();

class UsZipCodeSingleLookupExample {

    public function run() {
        $staticCredentials = new StaticCredentials(getenv('SMARTY_AUTH_ID'), getenv('SMARTY_AUTH_TOKEN'));
        $client = (new ClientBuilder($staticCredentials))->buildZipCodeClient();

        $lookup = new Lookup();
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
        $zipCodes = $result->getZipCodes();
        $cities = $result->getCities();

        foreach ($cities as $city) {
            echo("\nCity: " . $city->getCity());
            echo("\nState: " . $city->getState());
            echo("\nMailable City: " . json_encode($city->getMailableCity()));
        }

        foreach ($zipCodes as $zip) {
            echo("\n\nZIP Code: " . $zip->getZipCode());
            echo("\nLatitude: " . $zip->getLatitude());
            echo("\nLongitude: " . $zip->getLongitude());
        }
    }
}