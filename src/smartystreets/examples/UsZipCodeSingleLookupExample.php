<?php

namespace smartystreets\examples;

require_once(dirname(dirname(__FILE__)) . '/api/ClientBuilder.php');
require_once(dirname(dirname(__FILE__)) . '/api/us_zipcode/Lookup.php');
require_once(dirname(dirname(__FILE__)) . '/api/us_zipcode/Result.php');
require_once(dirname(dirname(__FILE__)) . '/api/StaticCredentials.php');
require_once(dirname(dirname(__FILE__)) . '/api/SharedCredentials.php');
use smartystreets\api\exceptions\SmartyException;
use smartystreets\api\StaticCredentials;
use smartystreets\api\us_zipcode\Lookup;
use smartystreets\api\ClientBuilder;

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