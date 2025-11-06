<?php
require_once __DIR__ . '/../vendor/autoload.php';

use GuzzleHttp\Client as GuzzleClient;
use Http\Factory\Guzzle\RequestFactory;
use Http\Factory\Guzzle\StreamFactory;
use SmartyStreets\PhpSdk\ClientBuilder;
use SmartyStreets\PhpSdk\NativeSerializer;
use SmartyStreets\PhpSdk\International_Postal_Code\Lookup;
use Psr\Http\Message\RequestInterface;

$example = new InternationalPostalCodeExample();
$example->run();

class InternationalPostalCodeExample {
    public function run() {
        $httpClient = new GuzzleClient();
        $requestFactory = new RequestFactory();
        $streamFactory = new StreamFactory();
        $serializer = new NativeSerializer();

        $client = (new ClientBuilder($httpClient, $requestFactory, $streamFactory, $serializer))\
            ->buildInternationalPostalCodeApiClient();

        // For complete list of input fields, refer to:
        // https://smartystreets.com/docs/cloud/international-postal-code-api

        $lookup = new Lookup();
        $lookup->setInputId('ID-8675309'); // Optional ID from your system
        $lookup->setLocality('Sao Paulo');
        $lookup->setAdministrativeArea('SP');
        $lookup->setCountry('Brazil');
        $lookup->setPostalCode('02516');

        try {
            $client->sendLookup($lookup);
            $this->displayResults($lookup);
        } catch (Exception $ex) {
            echo($ex->getMessage());
        }
    }

    public function displayResults(Lookup $lookup) {
        $results = $lookup->getResults();
        if (empty($results)) {
            echo("\nNo candidates found.");
            return;
        }

        echo("Results:\n\n");

        foreach ($results as $c => $candidate) {
            echo("Candidate: $c\n");
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

        echo("OK\n");
    }

    private function display($value) {
        if ($value != null && strlen($value) > 0) {
            echo("  $value\n");
        }
    }
}

