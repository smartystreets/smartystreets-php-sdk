<?php

require_once(dirname(dirname(__FILE__)) . '/src/ClientBuilder.php');
require_once(dirname(dirname(__FILE__)) . '/src/US_Street/Lookup.php');
require_once(dirname(dirname(__FILE__)) . '/src/StaticCredentials.php');
use SmartyStreets\PhpSdk\Exceptions\SmartyException;
use SmartyStreets\PhpSdk\StaticCredentials;
use SmartyStreets\PhpSdk\ClientBuilder;
use SmartyStreets\PhpSdk\US_Street\Lookup;

$lookupExample = new UsStreetSingleAddressExample();
$lookupExample->run();

class UsStreetSingleAddressExample {

    public function run() {
       // $authId = 'Your SmartyStreets Auth ID here';
       // $authToken = 'Your SmartyStreets Auth Token here';

        // We recommend storing your secret keys in environment variables instead---it's safer!
       $authId = getenv('SMARTY_AUTH_ID');
       $authToken = getenv('SMARTY_AUTH_TOKEN');

        $staticCredentials = new StaticCredentials($authId, $authToken);

        // The appropriate license values to be used for your subscriptions
        // can be found on the Subscriptions page the account dashboard.
        // https://www.smartystreets.com/docs/cloud/licensing
        $client = (new ClientBuilder($staticCredentials)) ->withLicenses(["us-core-cloud"])
//                        ->viaProxy("http://localhost:8080", "username", "password") // uncomment this line to point to the specified proxy.
                        ->buildUsStreetApiClient();

        // Documentation for input fields can be found at:
        // https://smartystreets.com/docs/cloud/us-street-api

        $lookup = new Lookup();
        $lookup->setInputId("24601"); // Optional ID from your system
        $lookup->setAddressee("John Doe");
        $lookup->setStreet("1600 Amphitheatre Pkwy");
        $lookup->setStreet2("closet under the stairs");
        $lookup->setSecondary("APT 2");
        $lookup->setUrbanization("");  // Only applies to Puerto Rico addresses
        $lookup->setCity("Mountain View");
        $lookup->setState("CA");
        $lookup->setZipcode("21229");
        $lookup->setMaxCandidates(3);
        $lookup->setMatchStrategy(Lookup::INVALID); // "invalid" is the most permissive match,
                                                                 // this will always return at least one result even if the address is invalid.
                                                                 // Refer to the documentation for additional MatchStrategy options.

        try {
            $client->sendLookup($lookup);
            $this->displayResults($lookup);
        }
        catch (SmartyException $ex) {
            echo($ex->getMessage());
        }
        catch (Exception $ex) {
            echo($ex->getMessage());
        }
    }

    public function displayResults(Lookup $lookup) {
        $results = $lookup->getResult();

        if (empty($results)) {
            echo("\nNo candidates. This means the address is not valid.");
            return;
        }

        $firstCandidate = $results[0];

        echo("\nThere is at least one candidate. If the match parameter is set to STRICT, the address is valid. Otherwise, check the Analysis output fields to see if the address is valid.\n");
        echo("\nZIP Code: " . $firstCandidate->getComponents()->getZIPCode());
        echo("\nCounty: " . $firstCandidate->getMetadata()->getCountyName());
        echo("\nLatitude: " . $firstCandidate->getMetadata()->getLatitude());
        echo("\nLongitude: " . $firstCandidate->getMetadata()->getLongitude());
    }
}