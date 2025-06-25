<?php

require_once(__DIR__ . '/../src/SharedCredentials.php');
require_once(__DIR__ . '/../src/StaticCredentials.php');
require_once(__DIR__ . '/../src/ClientBuilder.php');
require_once(__DIR__ . '/../src/US_Autocomplete_Pro/Lookup.php');
require_once(__DIR__ . '/../src/US_Autocomplete_Pro/Client.php');

use SmartyStreets\PhpSdk\SharedCredentials;
use SmartyStreets\PhpSdk\StaticCredentials;
use SmartyStreets\PhpSdk\ClientBuilder;
use SmartyStreets\PhpSdk\US_Autocomplete_Pro\Lookup;
use SmartyStreets\PhpSdk\US_Autocomplete_Pro\Suggestion;

$lookupExample = new USAutocompleteProExample();
$lookupExample->run();

class USAutocompleteProExample
{
    public function run()
    {
        // We recommend storing your secret keys in environment variables---it's safer!
//        $key = getenv('SMARTY_WEBSITE_KEY');
//        $hostname = getenv('SMARTY_WEBSITE_DOMAIN');

//        $credentials = new SharedCredentials($key, $hostname);

        $id = getenv('SMARTY_AUTH_ID');
        $token = getenv('SMARTY_AUTH_TOKEN');

        $credentials = new StaticCredentials($id, $token);

        $client = (new ClientBuilder($credentials))
            ->buildUSAutocompleteProApiClient();

        // Documentation for input fields can be found at:
        // https://smartystreets.com/docs/cloud/us-autocomplete-api

        $lookup = new Lookup("1042 W Center");
        try {
            $client->sendLookup($lookup);
            $this->displayResultsNoFilter($lookup);

            $lookup->addCityFilter("Denver,Aurora,CO");
            $lookup->addCityFilter("Orem,UT");
//          $lookup->addPreferState("CO");
            $lookup->setPreferRatio(3);
            $lookup->setMaxResults(5);
            $lookup->setSource("all");

            // Uncomment the below line to add a custom parameter to the API call
            // $lookup->addCustomParameter("parameter", "value");

            $client->sendLookup($lookup);
            $this->displayResultsFilter($lookup);
        }
        catch (\Exception $ex) {
            echo($ex->getMessage());
        }
    }

    private function displayResultsNoFilter(Lookup $lookup)
    {
        echo("*** Result with no filter ***");
        echo("\n");
        foreach ($lookup->getResult() as $suggestion)
            $this->printResults($suggestion);
    }

    private function displayResultsFilter(Lookup $lookup)
    {
        echo("\n");
        echo("*** Result with some filters ***\n");
        foreach($lookup->getResult() as $suggestion)
            $this->printResults($suggestion);
    }

    private function printResults(Suggestion $suggestion)
    {
        echo($suggestion->getStreetLine() . " " . $suggestion->getCity() . ", " . $suggestion->getState() . "\n");
    }
}