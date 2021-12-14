<?php

require_once(dirname(dirname(__FILE__)) . '/src/SharedCredentials.php');
require_once(dirname(dirname(__FILE__)) . '/src/StaticCredentials.php');
require_once(dirname(dirname(__FILE__)) . '/src/ClientBuilder.php');
require_once(dirname(dirname(__FILE__)) . '/src/US_Autocomplete_Pro/Lookup.php');
require_once(dirname(dirname(__FILE__)) . '/src/US_Autocomplete_Pro/Client.php');

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

        // The appropriate license values to be used for your subscriptions
        // can be found on the Subscriptions page the account dashboard.
        // https://www.smartystreets.com/docs/cloud/licensing
        $client = (new ClientBuilder($credentials)) ->withLicenses(["us-autocomplete-pro-cloud"])
            ->buildUSAutocompleteProApiClient();

        // Documentation for input fields can be found at:
        // https://smartystreets.com/docs/cloud/us-autocomplete-api

        $lookup = new Lookup("1042 W Center");

        $client->sendLookup($lookup);

        echo("*** Result with no filter ***");
        echo("\n");
        foreach ($lookup->getResult() as $suggestion)
            $this->printResults($suggestion);

        $lookup->addStateFilter("CO");
        $lookup->addStateFilter("UT");
        $lookup->addCityFilter("Denver");
        $lookup->addCityFilter("Orem");
//        $lookup->addPreferState("CO");
        $lookup->setPreferRatio(3);
        $lookup->setMaxResults(5);
        $lookup->setSource("all");

        $client->sendLookup($lookup);

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