<?php

require_once(dirname(dirname(__FILE__)) . '/src/StaticCredentials.php');
require_once(dirname(dirname(__FILE__)) . '/src/ClientBuilder.php');
require_once(dirname(dirname(__FILE__)) . '/src/International_Street/Lookup.php');
require_once(dirname(dirname(__FILE__)) . '/src/International_Street/Client.php');
use SmartyStreets\PhpSdk\StaticCredentials;
use SmartyStreets\PhpSdk\ClientBuilder;
use SmartyStreets\PhpSdk\International_Street\Lookup;

$lookupExample = new InternationalExample();
$lookupExample->run();

class InternationalExample {

    public function run() {
       // $authId = 'Your SmartyStreets Auth ID here';
       // $authToken = 'Your SmartyStreets Auth Token here';

        // We recommend storing your secret keys in environment variables instead---it's safer!
       $authId = getenv('SMARTY_AUTH_ID');
       $authToken = getenv('SMARTY_AUTH_TOKEN');

        $staticCredentials = new StaticCredentials($authId, $authToken);

        // The appropriate license values to be used for your subscriptions
        // can be found on the Subscriptions page the account dashboard.
        // https://www.smartystreets.com/docs/cloud/licensing
        $client = (new ClientBuilder($staticCredentials)) ->withLicenses(["international-global-plus-cloud"])
            ->buildInternationalStreetApiClient();

        // Documentation for input fields can be found at:
        // https://smartystreets.com/docs/cloud/international-street-api

        $lookup = new Lookup();
        $lookup->setInputId("ID-8675309");
        $lookup->setGeocode(true); // Must be expressly set to get latitude and longitude.
        $lookup->setOrganization("John Doe");
        $lookup->setAddress1("Rua Padre Antonio D'Angelo 121");
        $lookup->setAddress2("Casa Verde");
        $lookup->setLocality("Sao Paulo");
        $lookup->setAdministrativeArea("SP");
        $lookup->setCountry("Brazil");
        $lookup->setPostalCode("02516-050");

        $client->sendLookup($lookup); // The candidates are also stored in the lookup's 'result' field.

        $firstCandidate = $lookup->getResult()[0];

        echo("Address is " . $firstCandidate->getAnalysis()->getVerificationStatus());
        echo("\nAddress precision: " . $firstCandidate->getAnalysis()->getAddressPrecision() . "\n");

        echo("\nFirst Line: " . $firstCandidate->getAddress1());
        echo("\nSecond Line: " . $firstCandidate->getAddress2());
        echo("\nThird Line: " . $firstCandidate->getAddress3());
        echo("\nFourth Line: " . $firstCandidate->getAddress4());

        $metadata = $firstCandidate->getMetadata();
        echo("\nAddress Format: " . $metadata->getAddressFormat());
        echo("\nLatitude: " . $metadata->getLatitude());
        echo("\nLongitude: " . $metadata->getLongitude());
    }
}