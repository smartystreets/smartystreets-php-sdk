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

$lookupExample = new USEnrichmentSecondaryExample();
$lookupExample->run();

class USEnrichmentSecondaryExample
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

        // Or by address using a Lookup object:
        $lookup = new Lookup();

        $lookup->setStreet("56 Union Ave");
        $lookup->setCity("Somerville");
        $lookup->setState("NJ");
        $lookup->setZipcode("08876");

        // You can also send an address in freeform:
        // $lookup->setFreeform("56 Union Ave Somerville NJ 08876");

        // --- Secondary Lookup (full list of secondary addresses) ---
        echo("=== Secondary Lookup ===\n\n");
        try {
            // By SmartyKey: $result = $client->sendSecondaryLookup($smartyKey);
            $result = $client->sendSecondaryLookup($lookup);

            if ($result != null) {
                $this->displaySecondaryResult($result[0]);
            }
            else {
                echo("No results found. This means the address is likely not valid.\n");
            }
        }
        catch (Exception $ex) {
            echo($ex->getMessage());
        }

        // --- Secondary Count Lookup (just the count of secondary addresses) ---
        echo("\n=== Secondary Count Lookup ===\n\n");
        try {
            // By SmartyKey: $result = $client->sendSecondaryCountLookup($smartyKey);
            $result = $client->sendSecondaryCountLookup($lookup);

            if ($result != null) {
                $this->displaySecondaryCountResult($result[0]);
            }
            else {
                echo("No results found. This means the address is likely not valid.\n");
            }
        }
        catch (Exception $ex) {
            echo($ex->getMessage());
        }
    }

    public function displaySecondaryResult(Result $result)
    {
        echo("SmartyKey: " . $result->smartyKey . "\n\n");

        echo("Root Address:\n");
        var_dump($result->rootAddress);

        echo("\nAliases:\n");
        var_dump($result->aliases);

        echo("\nSecondaries:\n");
        var_dump($result->secondaries);
    }

    public function displaySecondaryCountResult(Result $result)
    {
        echo("SmartyKey: " . $result->smartyKey . "\n");
        echo("Count: " . $result->count . "\n");
    }
}
