<?php

require_once(__DIR__ . '/../src/BasicAuthCredentials.php');
require_once(__DIR__ . '/../src/ClientBuilder.php');
require_once(__DIR__ . '/../src/US_Reverse_Geo/Lookup.php');
require_once(__DIR__ . '/../src/US_Reverse_Geo/Client.php');

use SmartyStreets\PhpSdk\BasicAuthCredentials;
use SmartyStreets\PhpSdk\ClientBuilder;
use SmartyStreets\PhpSdk\US_Reverse_Geo\Lookup;

$lookupExample = new USReverseGeoExample();
$lookupExample->run();

class USReverseGeoExample
{

    public function run()
    {
        // $authId = 'Your SmartyStreets Auth ID here';
        // $authToken = 'Your SmartyStreets Auth Token here';

        // We recommend storing your secret keys in environment variables instead---it's safer!
       $authId = getenv('SMARTY_AUTH_ID');
       $authToken = getenv('SMARTY_AUTH_TOKEN');

        $credentials = new BasicAuthCredentials($authId, $authToken);

        $client = (new ClientBuilder($credentials))
            ->buildUsReverseGeoApiClient();

        $lookup = new Lookup(40.111111, -111.111111);

        // Uncomment the below line to add a custom parameter to the API call
        // $lookup->addCustomParameter("parameter", "value");

        try {
            $client->sendLookup($lookup);
            $this->displayResults($lookup);
        }
        catch (Exception $ex) {
            echo($ex->getMessage());
        }
    }

    public function displayResults(Lookup $lookup)
    {
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
            echo("\nSmartykey: " . $address->getSmartykey());
            echo("\n");
        }
    }
}