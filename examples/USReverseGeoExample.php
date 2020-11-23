<?php

require_once(dirname(dirname(__FILE__)) . '/src/StaticCredentials.php');
require_once(dirname(dirname(__FILE__)) . '/src/ClientBuilder.php');
require_once(dirname(dirname(__FILE__)) . '/src/US_Reverse_Geo/Lookup.php');
require_once(dirname(dirname(__FILE__)) . '/src/US_Reverse_Geo/Client.php');

use SmartyStreets\PhpSdk\StaticCredentials;
use SmartyStreets\PhpSdk\ClientBuilder;
use SmartyStreets\PhpSdk\US_Reverse_Geo\Lookup;

$lookupExample = new USReverseGeoExample();
$lookupExample->run();

class USReverseGeoExample
{

    public function run()
    {
        $authId = 'Your SmartyStreets Auth ID here';
        $authToken = 'Your SmartyStreets Auth Token here';

        // We recommend storing your secret keys in environment variables instead---it's safer!
//        $authId = getenv('SMARTY_AUTH_ID');
//        $authToken = getenv('SMARTY_AUTH_TOKEN');

        $staticCredentials = new StaticCredentials($authId, $authToken);
        $client = (new ClientBuilder($staticCredentials))->buildUsReverseGeoApiClient();

        $lookup = new Lookup(40.111111, -111.111111);

        $client->sendLookup($lookup); // The candidates are also stored in the lookup's 'result' field.

        echo("Results for input: " . $lookup->getLatitude() . ", " . $lookup->getLongitude() . "\n");

        foreach ($lookup->getResponse()->getResults() as $result) {
            $coordinate = $result->getCoordinate();
            echo("\nLatitude: " . $coordinate->getLatitude());
            echo("\nLongitude: " . $coordinate->getLongitude());

            echo("\nDistance: " . $result->getDistance());

            $address = $result->getAddress();
            echo("\nStreet: " . $address->getStreet());
            echo("\nCity: " . $address->getCity());
            echo("\nState Abbreviation: " . $address->getStateAbbreviation());
            echo("\nZIP Code: " . $address->getZIPCode());
            echo("\nLicense: " . $coordinate->getLicense());
            echo("\n");
        }
    }
}