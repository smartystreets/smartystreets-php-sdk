<?php

require_once(dirname(dirname(__FILE__)) . '/src/StaticCredentials.php');
require_once(dirname(dirname(__FILE__)) . '/src/ClientBuilder.php');
require_once(dirname(dirname(__FILE__)) . '/src/US_Enrichment/Client.php');

use SmartyStreets\PhpSdk\StaticCredentials;
use SmartyStreets\PhpSdk\ClientBuilder;
use SmartyStreets\PhpSdk\US_Enrichment\Result;

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
        
        $smartyKey = "1682393594";

        try {
            $result = $client->sendPropertyPrincipalLookup($smartyKey);
            $this->displayResult($result[0]);
        }
        catch (Exception $ex) {
            echo($ex->getMessage());
        }
    }

    public function displayResult(Result $result)
    {
        echo("Results for input: " . $result->smartyKey . ", " . $result->dataSetName . "," . $result->dataSubsetName . "\n");

        var_dump($result->attributes);
    }
}