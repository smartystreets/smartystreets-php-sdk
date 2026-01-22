<?php

require_once(__DIR__ . '/../src/BasicAuthCredentials.php');
// require_once(__DIR__ . '/../src/SharedCredentials.php');
require_once(__DIR__ . '/../src/ClientBuilder.php');
require_once(__DIR__ . '/../src/International_Postal_Code/Lookup.php');
require_once(__DIR__ . '/../src/International_Postal_Code/Client.php');
use SmartyStreets\PhpSdk\BasicAuthCredentials;
// use SmartyStreets\PhpSdk\SharedCredentials;
use SmartyStreets\PhpSdk\ClientBuilder;
use SmartyStreets\PhpSdk\International_Postal_Code\Lookup;

$lookupExample = new InternationalPostalCodeExample();
$lookupExample->run();

class InternationalPostalCodeExample {

    public function run() {
       // $authId = 'Your SmartyStreets Auth ID here';
       // $authToken = 'Your SmartyStreets Auth Token here';

        // We recommend storing your secret keys in environment variables instead---it's safer!
       $authId = getenv('SMARTY_AUTH_ID');
       $authToken = getenv('SMARTY_AUTH_TOKEN');

        // For client-side requests (browser/mobile), use SharedCredentials:
        // $credentials = new SharedCredentials($key, $hostname);

        $credentials = new BasicAuthCredentials($authId, $authToken);

        $client = (new ClientBuilder($credentials))
            ->buildInternationalPostalCodeApiClient();

        // Documentation for input fields can be found at:
        // https://smartystreets.com/docs/cloud/international-postal-code-api

        $lookup = new Lookup();
        $lookup->setInputId("ID-8675309");
        $lookup->setLocality("Sao Paulo");
        $lookup->setAdministrativeArea("SP");
        $lookup->setCountry("Brazil");
        $lookup->setPostalCode("02516");

        try {
            $client->sendLookup($lookup); // The candidates are also stored in the lookup's 'result' field.
            $this->displayResults($lookup);
        }
        catch (\Exception $ex) {
            echo($ex->getMessage());
        }
    }

    public function displayResults(Lookup $lookup) {
        $results = $lookup->getResult();

        echo("Results:\n");
        echo("\n");

        foreach ($results as $c => $candidate) {
            echo("Candidate: " . $c . "\n");
            $this->display($candidate->getInputId());
            $this->display($candidate->getCountryIso3());
            $this->display($candidate->getLocality());
            $this->display($candidate->getDependentLocality());
            $this->display($candidate->getDoubleDependentLocality());
            $this->display($candidate->getSubAdministrativeArea());
            $this->display($candidate->getAdministrativeArea());
            $this->display($candidate->getSuperAdministrativeArea());
            $this->display($candidate->getPostalCodeShort());
            echo("\n");
        }
    }

    private function display($value) {
        if ($value != null && strlen($value) > 0) {
            echo("  " . $value . "\n");
        }
    }
}
