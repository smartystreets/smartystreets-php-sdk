<?php

namespace smartystreets\examples;

require_once(dirname(dirname(__FILE__)) . '/api/ClientBuilder.php');
require_once(dirname(dirname(__FILE__)) . '/api/us_street/Lookup.php');
require_once(dirname(dirname(__FILE__)) . '/api/StaticCredentials.php');
use smartystreets\api\StaticCredentials;

use smartystreets\api\ClientBuilder;
use smartystreets\api\exceptions\SmartyException;
use smartystreets\api\us_street\Lookup;

$lookupExample = new UsStreetSingleAddressExample();
$lookupExample->run();

class UsStreetSingleAddressExample {

    public function run() {
        $staticCredentials = new StaticCredentials(getenv('SMARTY_AUTH_ID'), getenv('SMARTY_AUTH_TOKEN'));
        $client = (new ClientBuilder($staticCredentials))->buildStreetClient();

        $lookup = new Lookup();
        $lookup->setStreet("1600 Amphitheatre Pkwy");
        $lookup->setCity("Mountain View");
        $lookup->setState("CA");

        try {
            $client->sendLookup($lookup);
            $this->displayResults($lookup);
        }
        catch (SmartyException $ex) {
            echo($ex->getMessage());
        }
        catch (\Exception $ex) {
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

        echo("\nAddress is valid. (There is at least one candidate)\n");
        echo("\nZIP Code: " . $firstCandidate->getComponents()->getZipCode());
        echo("\nCounty: " . $firstCandidate->getMetadata()->getCountyName());
        echo("\nLatitude: " . $firstCandidate->getMetadata()->getLatitude());
        echo("\nLongitude: " . $firstCandidate->getMetadata()->getLongitude());
    }
}