<?php

require_once(__DIR__ . '/../src/ClientBuilder.php');
require_once(__DIR__ . '/../src/US_Street/Lookup.php');
require_once(__DIR__ . '/../src/BasicAuthCredentials.php');
// require_once(__DIR__ . '/../src/SharedCredentials.php');
use SmartyStreets\PhpSdk\Exceptions\SmartyException;
use SmartyStreets\PhpSdk\Exceptions\BatchFullException;
use SmartyStreets\PhpSdk\BasicAuthCredentials;
// use SmartyStreets\PhpSdk\SharedCredentials;
use SmartyStreets\PhpSdk\ClientBuilder;
use SmartyStreets\PhpSdk\US_Street\Lookup;
use SmartyStreets\PhpSdk\Batch;

$lookupExample = new USStreetLookupsWithMatchStrategyExamples();
$lookupExample->run();

class USStreetLookupsWithMatchStrategyExamples {

    public function run() {
        // For client-side requests (browser/mobile), use SharedCredentials:
        // $credentials = new SharedCredentials($key, $hostname);

        $credentials = new BasicAuthCredentials(getenv('SMARTY_AUTH_ID'), getenv('SMARTY_AUTH_TOKEN'));

        $client = (new ClientBuilder($credentials))
            ->buildUsStreetApiClient();

        // Each address is run through all three match strategies so you can compare how
        // 'strict', 'enhanced', and 'invalid' each handle a valid, an invalid, and an
        // ambiguous address.
        //   - strict:   only returns candidates that are valid, mailable addresses.
        //   - enhanced: returns a more comprehensive dataset (requires a US Core or Rooftop license).
        //   - invalid:  most permissive; always returns at least one candidate (a best-guess standardization).
        // Documentation for input fields: https://smartystreets.com/docs/cloud/us-street-api
        $addresses = [
            ["valid (real, deliverable)",    "1600 Amphitheatre Pkwy", "Mountain View", "CA", "94043"],
            ["invalid (no such address)",    "9999 W 1150 S",          "Provo",         "UT", "84601"],
            ["ambiguous (missing ZIP/unit)", "1 Rosedale St",          "Baltimore",     "MD", ""],
        ];
        $strategies = [Lookup::STRICT, Lookup::ENHANCED, Lookup::INVALID];

        $batch = new Batch();
        $cases = []; // parallel metadata for each lookup, in the order they are added to the batch

        foreach ($addresses as [$label, $street, $city, $state, $zipcode]) {
            foreach ($strategies as $strategy) {
                $lookup = new Lookup();
                $lookup->setStreet($street);
                $lookup->setCity($city);
                $lookup->setState($state);
                $lookup->setZipcode($zipcode);
                $lookup->setMatchStrategy($strategy);
                $lookup->setMaxCandidates(10); // allow ambiguous addresses to return more than one match
                $batch->add($lookup);
                $cases[] = [$label, "$street, $city, $state", $strategy];
            }
        }

        try {
            $client->sendBatch($batch);
        }
        catch (BatchFullException $ex) {
            echo("Oops! Batch was already full.");
            return;
        }
        catch (\Exception $ex) {
            echo($ex->getMessage());
            return;
        }

        $this->displayResults($batch, $cases);
    }

    public function displayResults(Batch $batch, array $cases) {
        $lookups = $batch->getAllLookups();
        $lastAddress = null;

        for ($i = 0; $i < $batch->size(); $i++) {
            [$label, $addressDisplay, $strategy] = $cases[$i];

            if ($addressDisplay !== $lastAddress) {
                echo("\n" . str_repeat("=", 70) . "\n");
                echo(" Address: $addressDisplay  [$label]\n");
                echo(str_repeat("=", 70) . "\n");
                $lastAddress = $addressDisplay;
            }

            $candidates = $lookups[$i]->getResult();
            echo("\n--- '$strategy' strategy ---\n");

            if (empty($candidates)) {
                echo("  0 candidates - no match returned under this strategy.\n");
                continue;
            }

            echo("  " . count($candidates) . " candidate(s):\n");
            foreach ($candidates as $candidate) {
                echo("    [" . $candidate->getCandidateIndex() . "] " . $candidate->getDeliveryLine1() . "  " . $candidate->getLastLine() . "\n");
            }
        }
        echo("\n");
    }
}
