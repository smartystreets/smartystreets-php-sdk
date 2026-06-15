<?php

require_once(__DIR__ . '/../src/BasicAuthCredentials.php');
// require_once(__DIR__ . '/../src/SharedCredentials.php');
require_once(__DIR__ . '/../src/ClientBuilder.php');
require_once(__DIR__ . '/../src/US_Autocomplete/Lookup.php');
require_once(__DIR__ . '/../src/US_Autocomplete/Client.php');

use SmartyStreets\PhpSdk\BasicAuthCredentials;
// use SmartyStreets\PhpSdk\SharedCredentials;
use SmartyStreets\PhpSdk\ClientBuilder;
use SmartyStreets\PhpSdk\US_Autocomplete\Lookup;
use SmartyStreets\PhpSdk\US_Autocomplete\Suggestion;

// This example is for US Autocomplete (V2). It has the same name as a previous product
// which has been deprecated since 2022, which we refer to as US Autocomplete Basic.
// If you are still using US Autocomplete Basic, this SDK will not work.

$lookupExample = new USAutocompleteExample();
$lookupExample->run();

class USAutocompleteExample
{
    public function run()
    {
        // We recommend storing your secret keys in environment variables---it's safer!
        // For client-side requests (browser/mobile), use SharedCredentials:
        // $key = getenv('SMARTY_WEBSITE_KEY');
        // $hostname = getenv('SMARTY_WEBSITE_DOMAIN');
        // $credentials = new SharedCredentials($key, $hostname);

        $id = getenv('SMARTY_AUTH_ID');
        $token = getenv('SMARTY_AUTH_TOKEN');

        $credentials = new BasicAuthCredentials($id, $token);

        $client = (new ClientBuilder($credentials))
            ->buildUSAutocompleteApiClient();

        // Documentation for input fields can be found at:
        // https://www.smarty.com/docs/apis/us-autocomplete-v2/reference#http-request-input-fields

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
            $entryID = $this->displayResultsFilter($lookup);

            // Expand the secondaries of a result that has an entry_id by passing it back as the selected address.
            if ($entryID != null && strlen($entryID) > 0) {
                $lookup->setSelected($entryID);
                $client->sendLookup($lookup);
                $this->displaySecondaries($lookup);
            }
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
        $entryID = null;
        foreach($lookup->getResult() as $suggestion) {
            $this->printResults($suggestion);
            if ($suggestion->getEntryID() != null && strlen($suggestion->getEntryID()) > 0)
                $entryID = $suggestion->getEntryID();
        }
        return $entryID;
    }

    private function displaySecondaries(Lookup $lookup)
    {
        echo("\n");
        echo("*** Secondaries ***\n");
        foreach($lookup->getResult() as $suggestion)
            $this->printResults($suggestion);
    }

    private function printResults(Suggestion $suggestion)
    {
        echo($suggestion->getStreetLine() . " " . $suggestion->getCity() . ", " . $suggestion->getState() . "\n");
    }
}
