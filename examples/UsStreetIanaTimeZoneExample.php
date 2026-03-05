<?php

require_once(__DIR__ . '/../src/ClientBuilder.php');
require_once(__DIR__ . '/../src/US_Street/Lookup.php');
require_once(__DIR__ . '/../src/BasicAuthCredentials.php');
// require_once(__DIR__ . '/../src/SharedCredentials.php');
use SmartyStreets\PhpSdk\BasicAuthCredentials;
// use SmartyStreets\PhpSdk\SharedCredentials;
use SmartyStreets\PhpSdk\ClientBuilder;
use SmartyStreets\PhpSdk\US_Street\Lookup;

$lookupExample = new UsStreetIanaTimeZoneExample();
$lookupExample->run();

class UsStreetIanaTimeZoneExample {

    public function run() {
        // For client-side requests (browser/mobile), use SharedCredentials:
        // $key = getenv('SMARTY_AUTH_WEB');
        // $referer = getenv('SMARTY_AUTH_REFERER');
        // $credentials = new SharedCredentials($key, $referer);

        // For server-to-server requests, use BasicAuthCredentials:
        $authId = getenv('SMARTY_AUTH_ID');
        $authToken = getenv('SMARTY_AUTH_TOKEN');
        $credentials = new BasicAuthCredentials($authId, $authToken);

        $client = (new ClientBuilder($credentials))
            ->withFeatureIanaTimeZone()
            ->buildUsStreetApiClient();

        $lookup = new Lookup();
        $lookup->setStreet("1 Rosedale");
        $lookup->setSecondary("APT 2");
        $lookup->setCity("Baltimore");
        $lookup->setState("MD");
        $lookup->setZipcode("21229");
        $lookup->setMatchStrategy(Lookup::ENHANCED);

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

        $firstCandidate = $results[0];
        $metadata = $firstCandidate->getMetadata();

        echo("Legacy Timezone Fields:\n");
        echo("\tTime Zone: " . $metadata->getTimeZone() . "\n");
        echo("\tUTC Offset: " . $metadata->getUtcOffset() . "\n");
        echo("\tObeys DST: " . ($metadata->obeysDst() ? "true" : "false") . "\n");

        echo("\nIANA Timezone Fields:\n");
        echo("\tIANA Time Zone: " . $metadata->getIanaTimeZone() . "\n");
        echo("\tIANA UTC Offset: " . $metadata->getIanaUtcOffset() . "\n");
        echo("\tObeys IANA DST: " . ($metadata->obeysIanaDst() ? "true" : "false") . "\n");
    }
}
