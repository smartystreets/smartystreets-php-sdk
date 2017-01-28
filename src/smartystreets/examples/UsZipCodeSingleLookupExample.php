<?php

namespace smartystreets\examples;

require_once(dirname(dirname(__FILE__)) . '/api/us_zipcode/ClientBuilder.php');
//require_once(dirname(dirname(__FILE__)) . '/api/us_zipcode/Client.php');
require_once(dirname(dirname(__FILE__)) . '/api/StaticCredentials.php');
use smartystreets\api\exceptions\SmartyException;
use smartystreets\api\StaticCredentials;
use smartystreets\api\us_zipcode\Lookup;
use smartystreets\api\us_zipcode\ClientBuilder;
use smartystreets\api\us_zipcode\Client;

$lookupExample = new UsZipCodeSingleLookupExample();
$lookupExample->run();

class UsZipCodeSingleLookupExample {

    public function run() {
//        $staticCredentials = new StaticCredentials($_ENV['SMARTY_AUTH_ID'], $_ENV['SMARTY_AUTH_TOKEN']);
        $staticCredentials = new StaticCredentials('auth_id', 'auth_token');
        $client = (new ClientBuilder($staticCredentials))->build();

        $lookup = new Lookup();
        $lookup->setCity("Mountain View");
        $lookup->setState("California");

        try {
            $client->sendLookup($lookup);
        }
        catch (SmartyException $ex) {
            echo($ex->getMessage());
        }
        catch (\Exception $ex) {
            echo($ex->getMessage());
        }

        $result = $lookup->getResult();
        $zipCodes = $result->getZipCodes();
        $cities = $result->getCities();

        foreach ($cities as $city) {
            echo("\nCity: " . $city->getCity());
            echo("State: " . $city->getState());
            echo("Mailable City: " . $city->getMailableCity());
        }

        foreach ($zipCodes as $zip) {
            echo("\nZIP Code: " . $zip->getZipCode());
            echo("Latitude: " . $zip->getLatitude());
            echo("Longitude: " . $zip->getLongitude());
        }
    }
}