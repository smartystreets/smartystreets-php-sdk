<?php

use SmartyStreets\PhpSdk\SharedCredentials;

require_once(__DIR__ . '/../src/ClientBuilder.php');
require_once(__DIR__ . '/../src/US_Street/Lookup.php');
require_once(__DIR__ . '/../src/StaticCredentials.php');
use SmartyStreets\PhpSdk\StaticCredentials;
use SmartyStreets\PhpSdk\ClientBuilder;
use SmartyStreets\PhpSdk\US_Street\Lookup;

$lookupExample = new UsStreetComponentAnalysisExample();
$lookupExample->run();

class UsStreetComponentAnalysisExample {

    public function run() {
        // For client-side requests (browser/mobile), use this code:
        // $key = getenv('SMARTY_AUTH_WEB');
        // $referer = getenv('SMARTY_AUTH_REFERER');
        // $credentials = new SharedCredentials($key, $referer);

        // For server-to-server requests, use this code:
        $authId = getenv('SMARTY_AUTH_ID');
        $authToken = getenv('SMARTY_AUTH_TOKEN');
        $credentials = new StaticCredentials($authId, $authToken);

        $client = (new ClientBuilder($credentials))
            ->withFeatureComponentAnalysis() // To add component analysis feature you need to specify when you create the client.
            ->buildUsStreetApiClient();

        $lookup = new Lookup();
        $lookup->setStreet("1 Rosedale");
        $lookup->setSecondary("APT 2");
        $lookup->setCity("Baltimore");
        $lookup->setState("MD");
        $lookup->setZipcode("21229");
        $lookup->setMatchStrategy(Lookup::ENHANCED); // Enhanced matching is required to return component analysis results.

        try {
            $client->sendLookup($lookup);
            $this->displayResults($lookup);
        }
        catch (Exception $ex) {
            echo($ex->getMessage());
        }
    }

    public function displayResults(Lookup $lookup) {
        $results = $lookup->getResult();

        if (empty($results)) {
            return;
        }

        // Here is an example of how to access component analysis
        $firstCandidate = $results[0];
        echo("Component Analysis Results:\n");
        echo("\tPrimary Number Status: " . $firstCandidate->getAnalysis()->getComponents()->getPrimaryNumber()->getStatus());
    }
}