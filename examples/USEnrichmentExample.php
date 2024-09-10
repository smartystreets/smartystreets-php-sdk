<?php

require_once(dirname(dirname(__FILE__)) . '/src/StaticCredentials.php');
require_once(dirname(dirname(__FILE__)) . '/src/ClientBuilder.php');
require_once(dirname(dirname(__FILE__)) . '/src/US_Enrichment/Client.php');
require_once(dirname(dirname(__FILE__)) . '/src/US_Enrichment/Lookup.php');

use SmartyStreets\PhpSdk\StaticCredentials;
use SmartyStreets\PhpSdk\ClientBuilder;
use SmartyStreets\PhpSdk\US_Enrichment\Result;
use SmartyStreets\PhpSdk\US_Enrichment\Lookup;

$lookupExample = new USEnrichmentExample();
$lookupExample->run();

class USEnrichmentExample
{

    public function run()
    {
        // $authId = 'Your SmartyStreets Auth ID here';
        // $authToken = 'Your SmartyStreets Auth Token here';

        // We recommend storing your secret keys in environment variables instead---it's safer!
        $authId = getenv('SMARTY_AUTH_ID');
        $authToken = getenv('SMARTY_AUTH_TOKEN');

        $staticCredentials = new StaticCredentials($authId, $authToken);

        // The appropriate license values to be used for your subscriptions
        // can be found on the Subscriptions page the account dashboard.
        // https://www.smartystreets.com/docs/cloud/licensing
        $client = (new ClientBuilder($staticCredentials)) ->withLicenses(["us-property-data-principal-cloud"])
            ->buildUsEnrichmentApiClient();
        
        $smartyKey = "325023201";

        $lookup = new Lookup();
        
        $lookup->setStreet("56 Union Ave");
        $lookup->setCity("Somerville");
        $lookup->setState("NJ");
        $lookup->setZipcode("08876");
        
        // You can also send an address in freeform by uncommenting the line below
        // $lookup->setFreeform("56 Union Ave Somerville NJ 08876");

        try {
            // Call the API with only a smarty key using the line below
            $result = $client->sendPropertyPrincipalLookup($smartyKey);

            // Or call the API with an address using the lookup object with the commented line below
            // $result = $client->sendPropertyPrincipalLookup($lookup);

            if ($result != null) {
                $this->displayResult($result[0]);
            }
            else {
                echo("No results found. This means the Smartykey is likely not valid.");
            }
        }
        catch (Exception $ex) {
            echo($ex->getMessage());
        }
    }

    public function displayResult(Result $result)
    {
        if ($result->dataSubsetName == 'principal' || $result->dataSubsetName == 'financial' || $result->dataSetName == 'geo-reference'){
            echo("Results for input: " . $result->smartyKey . ", " . $result->dataSetName . "," . $result->dataSubsetName . "\n");

            var_dump($result->attributes);
        }
        else if ($result->dataSetName == 'secondary') {
            if ($result->dataSubsetName == 'count') {
                echo("smarty_key: " . $result->smartyKey . "\n" . "count: " . $result->count);
                return;
            }
            var_dump($result);
        }
    }
}