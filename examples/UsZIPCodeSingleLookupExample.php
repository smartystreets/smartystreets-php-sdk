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
        $staticCredentials = new StaticCredentials(getenv('SMARTY_AUTH_ID'), getenv('SMARTY_AUTH_TOKEN'));
        $client = (new ClientBuilder($staticCredentials))->buildUsZIPCodeApiClient();

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