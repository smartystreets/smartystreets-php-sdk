<?php

require_once(__DIR__ . '/../src/BasicAuthCredentials.php');
// require_once(__DIR__ . '/../src/SharedCredentials.php');
require_once(__DIR__ . '/../src/ClientBuilder.php');
require_once(__DIR__ . '/../src/US_Enrichment/Client.php');
require_once(__DIR__ . '/../src/US_Enrichment/Lookup.php');

use SmartyStreets\PhpSdk\BasicAuthCredentials;
// use SmartyStreets\PhpSdk\SharedCredentials;
use SmartyStreets\PhpSdk\ClientBuilder;
use SmartyStreets\PhpSdk\US_Enrichment\Result;
use SmartyStreets\PhpSdk\US_Enrichment\Lookup;

$lookupExample = new USEnrichmentGeoReferenceExample();
$lookupExample->run();

class USEnrichmentGeoReferenceExample
{

    public function run()
    {
        // $authId = 'Your SmartyStreets Auth ID here';
        // $authToken = 'Your SmartyStreets Auth Token here';

        // We recommend storing your secret keys in environment variables instead---it's safer!
        $authId = getenv('SMARTY_AUTH_ID');
        $authToken = getenv('SMARTY_AUTH_TOKEN');

        // For client-side requests (browser/mobile), use SharedCredentials:
        // $credentials = new SharedCredentials($key, $hostname);

        $credentials = new BasicAuthCredentials($authId, $authToken);

        $client = (new ClientBuilder($credentials))
            ->buildUsEnrichmentApiClient();

        // You can send a lookup by SmartyKey:
        // $smartyKey = "325023201";
        // $result = $client->sendGeoReferenceLookup($smartyKey);

        // Or by address using a Lookup object:
        $lookup = new Lookup();

        $lookup->setStreet("56 Union Ave");
        $lookup->setCity("Somerville");
        $lookup->setState("NJ");
        $lookup->setZipcode("08876");

        // You can also send an address in freeform:
        // $lookup->setFreeform("56 Union Ave Somerville NJ 08876");

        try {
            $result = $client->sendGeoReferenceLookup($lookup);

            if ($result != null) {
                $this->displayResult($result[0]);
            }
            else {
                echo("No results found. This means the address is likely not valid.\n");
            }
        }
        catch (Exception $ex) {
            echo($ex->getMessage());
        }
    }

    public function displayResult(Result $result)
    {
        echo("Results for input: " . $result->smartyKey . ", " . $result->dataSetName . "\n\n");

        $attrs = $result->attributes;

        echo("Census Block:\n");
        var_dump($attrs->censusBlock);

        echo("\nCensus County Division:\n");
        var_dump($attrs->censusCountyDivision);

        echo("\nCensus Tract:\n");
        var_dump($attrs->censusTract);

        echo("\nCore Based Statistical Area:\n");
        var_dump($attrs->coreBasedStatArea);

        echo("\nPlace:\n");
        var_dump($attrs->place);
    }
}
