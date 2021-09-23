<?php

require_once(dirname(dirname(__FILE__)) . '/src/SharedCredentials.php');
require_once(dirname(dirname(__FILE__)) . '/src/ClientBuilder.php');
require_once(dirname(dirname(__FILE__)) . '/src/US_Autocomplete_Pro/Lookup.php');
require_once(dirname(dirname(__FILE__)) . '/src/US_Autocomplete_Pro/Client.php');

use SmartyStreets\PhpSdk\SharedCredentials;
use SmartyStreets\PhpSdk\ClientBuilder;
use SmartyStreets\PhpSdk\US_Autocomplete_Pro\Lookup;
use SmartyStreets\PhpSdk\US_Autocomplete_Pro\Suggestion;

$lookupExample = new USAutocompleteProExample();
$lookupExample->run();

class USAutocompleteProExample
{
    public function run()
    {
        $key = 'Your SmartyStreets website key here';
        $hostname = 'Your SmartyStreets website domain here';

        // We recommend storing your secret keys in environment variables instead---it's safer!
//        $key = getenv('SMARTY_WEBSITE_KEY');
//        $hostname = getenv('SMARTY_WEBSITE_DOMAIN');

        $sharedCredentials = new SharedCredentials($key, $hostname);

        // The appropriate license values to be used for your subscriptions
        // can be found on the Subscriptions page the account dashboard.
        // https://www.smartystreets.com/docs/cloud/licensing
        $client = (new ClientBuilder($sharedCredentials)) ->withLicenses(["us-autocomplete-pro-cloud"])
            ->buildUSAutocompleteProApiClient();

        // Documentation for input fields can be found at:
        // https://smartystreets.com/docs/cloud/us-autocomplete-api

        $lookup = new Lookup("4770 Lincoln Ave O");

        $client->sendLookup($lookup);

        echo("*** Result with no filter ***");
        echo("\n");
        foreach ($lookup->getResult() as $suggestion)
            $this->printResults($suggestion);

        $lookup->addCityFilter("Ogden");
        $lookup->addStateFilter("IL");
        $lookup->addPreferCity("Ogden");
        $lookup->addPreferState("IL");
        $lookup->setPreferRatio(100);
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