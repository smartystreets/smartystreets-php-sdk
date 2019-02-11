<?php

namespace SmartyStreets\PhpSdk\Tests\IntegrationTests;

require_once(dirname(dirname(dirname(__FILE__))) . '/src/ClientBuilder.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_ZIPCode/Lookup.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_ZIPCode/Result.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_Street/Lookup.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_Extract/Lookup.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_Autocomplete/Lookup.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/International_Street/Lookup.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/StaticCredentials.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/SharedCredentials.php');
use SmartyStreets\PhpSdk\StaticCredentials;
use SmartyStreets\PhpSdk\US_ZIPCode\Lookup as USZIPCodeLookup;
use SmartyStreets\PhpSdk\US_Street\Lookup as USStreetLookup;
use SmartyStreets\PhpSdk\US_Extract\Lookup as USExtractLookup;
use SmartyStreets\PhpSdk\US_Autocomplete\Lookup as USAutocompleteLookup;
use SmartyStreets\PhpSdk\International_Street\Lookup as InternationStreetLookup;
use SmartyStreets\PhpSdk\ClientBuilder;

$apiTest = new IntegrationTests();
$apiTest->runAllApiIntegrationTests();

class IntegrationTests {

    public function runAllApiIntegrationTests() {
        $credentials = new StaticCredentials(getenv('SMARTY_AUTH_ID'), getenv('SMARTY_AUTH_TOKEN'));

        print("\n");
        $this->testInternationalStreetRequestReturnsWithCorrectNumberOfResults($credentials);
        $this->testUSAutocompleteRequestReturnsWithCorrectNumberOfResults($credentials);
        $this->testUSExtractRequestReturnsWithCorrectNumberOfResults($credentials);
        $this->testUSStreetRequestReturnsWithCorrectNumberOfResults($credentials);
        $this->testUSZIPCodeRequestReturnsWithCorrectNumberOfResults($credentials);
        $this->testGetsResultsViaProxy($credentials);
    }

    public function testInternationalStreetRequestReturnsWithCorrectNumberOfResults(StaticCredentials $credentials) {
        $client = (new ClientBuilder($credentials))->withUrl(getenv('SMARTY_URL_INTERNATIONAL_STREET'))->retryAtMost(0)->buildInternationalStreetApiClient();
        $lookup = new InternationStreetLookup();
        $lookup->setFreeformInput("Rua Padre Antonio D'Angelo 121 Casa Verde, Sao Paulo", "Brazil");

        try {
            $client->sendLookup($lookup);
        }
        catch (\Exception $ex) {}

        $candidates = count($lookup->getResult());
        $this->assertResults("International_Street", $candidates, 1);
    }

    public function testUSAutocompleteRequestReturnsWithCorrectNumberOfResults(StaticCredentials $credentials) {
        $client = (new ClientBuilder($credentials))->withUrl(getenv('SMARTY_URL_US_AUTOCOMPLETE'))->retryAtMost(0)->buildUSAutocompleteApiClient();
        $lookup = new USAutocompleteLookup("4770 Lincoln Ave O");
        $lookup->addStateFilter("IL");

        try {
            $client->sendLookup($lookup);
        }
        catch (\Exception $ex) {}

        $suggestions = count($lookup->getResult());
        $this->assertResults("US_Autocomplete", $suggestions, 9);
    }

    public function testUSExtractRequestReturnsWithCorrectNumberOfResults(StaticCredentials $credentials) {
        $client = (new ClientBuilder($credentials))->withUrl(getenv('SMARTY_URL_US_EXTRACT'))->retryAtMost(0)->buildUSExtractApiClient();
        $text = "Here is some text.\r\nMy address is 3785 Las Vegs Av." .
            "\r\nLos Vegas, Nevada." .
            "\r\nMeet me at 1 Rosedale Baltimore Maryland, not at 123 Phony Street, Boise Idaho.";

        $lookup = new USExtractLookup($text);

        try {
            $client->sendLookup($lookup);
        }
        catch (\Exception $ex) {}

        $addresses = count($lookup->getResult()->getAddresses());
        $this->assertResults("US_Extract", $addresses, 3);
    }

    public function testUSStreetRequestReturnsWithCorrectNumberOfResults(StaticCredentials $credentials) {
        $client = (new ClientBuilder($credentials))->withUrl(getenv('SMARTY_URL_US_STREET'))->retryAtMost(0)->buildUsStreetApiClient();
        $lookup = new USStreetLookup("1 Rosedale, Baltimore, Maryland");
        $lookup->setMaxCandidates(10);

        try {
            $client->sendLookup($lookup);
        }
        catch(\Exception $ex) {}

        $candidates = count($lookup->getResult());
        $this->assertResults("US_Street", $candidates, 2);
    }

    public function testUSZIPCodeRequestReturnsWithCorrectNumberOfResults(StaticCredentials $credentials) {
        $client = (new ClientBuilder($credentials))->withUrl(getenv('SMARTY_URL_US_ZIP'))->retryAtMost(0)->buildUsZIPCodeApiClient();
        $lookup = new USZIPCodeLookup(null, null, "38852");

        try {
            $client->sendLookup($lookup);
        }
        catch(\Exception $ex) {}

        $citiesAmount = count($lookup->getResult()->getCities());
        $this->assertResults("US_ZIPCode", $citiesAmount, 7);
    }

    public function testGetsResultsViaProxy(StaticCredentials $credentials) {
        $client = (new ClientBuilder($credentials))->withUrl(getenv('SMARTY_URL_US_ZIP'))->retryAtMost(0)->viaProxy("http://localhost:8080", "username", "password")->buildUsZIPCodeApiClient();
        $lookup = new USZIPCodeLookup(null, null, "38852");

        try {
            $client->sendLookup($lookup);
        }
        catch(\Exception $ex) {}

        $citiesAmount = 0;
        if ($lookup->getResult()->getCities() != null)
            $citiesAmount = count($lookup->getResult()->getCities());

        $this->assertResults("WITH_PROXY", $citiesAmount, 7);
    }

    private function assertResults($apiType, $actualResultCount, $expectedResultCount) {
        if ($actualResultCount == $expectedResultCount)
            print($apiType . " - OK\n");
        else
            print($apiType . " - FAILED (Expected: " . $expectedResultCount . ", Actual: " . $actualResultCount . ")\n");
    }
}