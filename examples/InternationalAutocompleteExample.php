<?php

require_once(dirname(dirname(__FILE__)) . '/src/StaticCredentials.php');
require_once(dirname(dirname(__FILE__)) . '/src/ClientBuilder.php');
require_once(dirname(dirname(__FILE__)) . '/src/International_Autocomplete/Lookup.php');
require_once(dirname(dirname(__FILE__)) . '/src/International_Autocomplete/Client.php');
use SmartyStreets\PhpSdk\StaticCredentials;
use SmartyStreets\PhpSdk\ClientBuilder;
use SmartyStreets\PhpSdk\International_Autocomplete\Lookup;

$lookupExample = new InternationalAutocompleteExample();
$lookupExample->run();

class InternationalAutocompleteExample {

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
        $client = (new ClientBuilder($staticCredentials)) ->withLicenses(["international-autocomplete-cloud"])
            ->buildInternationalAutocompleteApiClient();

        // Documentation for input fields can be found at:
        // https://smartystreets.com/docs/cloud/international-street-api

        $lookup = new Lookup("Louis");
        $lookup->setCountry("FRA");
        $lookup->setLocality("Paris");

        $client->sendLookup($lookup); // The candidates are also stored in the lookup's 'result' field.

        foreach ($lookup->getResult() as $candidate) {
            echo($candidate->getStreet() . " " . $candidate->getLocality() . " " . $candidate->getCountryISO3() . "\n");
        };

    }
}