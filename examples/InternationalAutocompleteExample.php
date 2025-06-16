<?php

require_once(__DIR__ . '/../src/StaticCredentials.php');
require_once(__DIR__ . '/../src/ClientBuilder.php');
require_once(__DIR__ . '/../src/International_Autocomplete/Lookup.php');
require_once(__DIR__ . '/../src/International_Autocomplete/Client.php');
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
        $client = (new ClientBuilder($staticCredentials)) ->withLicenses(["international-autocomplete-v2-cloud"])
            ->buildInternationalAutocompleteApiClient();

        // Documentation for input fields can be found at:
        // https://smartystreets.com/docs/cloud/international-street-api

        $lookup = new Lookup("Louis");
        $lookup->setCountry("FRA");
        $lookup->setLocality("Paris");

        // Uncomment the below line to add a custom parameter to the API call
        // $lookup->addCustomParameter("parameter", "value");

        try {
            $client->sendLookup($lookup); // The candidates are also stored in the lookup's 'result' field.
            foreach ($lookup->getResult() as $candidate) {
                if ($candidate->getStreet() != null) {
                    echo($candidate->getStreet() . " " . $candidate->getLocality() . " " . $candidate->getCountryISO3() . "\n");
                } else {
                    echo($candidate->getEntries() . " " . $candidate->getAddressText() . " " . $candidate->getAddressID() . "\n");
                }
            };
        }
        catch (\Exception $ex) {
            echo($ex->getMessage());
        }

    }
}