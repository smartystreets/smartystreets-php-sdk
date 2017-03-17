<?php

namespace SmartyStreets\PhpSdk\Tests\IntegrationTests;

require_once(dirname(dirname(dirname(__FILE__))) . '/src/ClientBuilder.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_ZIPCode/Lookup.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_ZIPCode/Result.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/StaticCredentials.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/SharedCredentials.php');
use SmartyStreets\PhpSdk\StaticCredentials;
use SmartyStreets\PhpSdk\US_ZIPCode\Lookup;
use SmartyStreets\PhpSdk\ClientBuilder;

$apiTest = new IntegrationTests();
$apiTest->runAllApiIntegrationTests();

class IntegrationTests {

//    public function
    public function runAllApiIntegrationTests() {
        $credentials = new StaticCredentials(getenv('SMARTY_AUTH_ID'), getenv('SMARTY_AUTH_TOKEN'));

        print("\n");
//        $this->testInternationalStreetRequestReturnsWithCorrectNumberOfResults($credentials);
//        $this->testUSAutocompleteRequestReturnsWithCorrectNumberOfResults($credentials);
//        $this->testUSExtractRequestReturnsWithCorrectNumberOfResults($credentials);
//        $this->testUSStreetRequestReturnsWithCorrectNumberOfResults($credentials);
        $this->testUSZIPCodeRequestReturnsWithCorrectNumberOfResults($credentials);
    }

    public function testInternationalStreetRequestReturnsWithCorrectNumberOfResults(StaticCredentials $credentials) {
        //"Rua Padre Antonio D'Angelo 121 Casa Verde, Sao Paulo", "Brazil"
    }

    public function testUSAutocompleteRequestReturnsWithCorrectNumberOfResults(StaticCredentials $credentials) {
        //123 Main
    }

    public function testUSExtractRequestReturnsWithCorrectNumberOfResults(StaticCredentials $credentials) {
        //same one from example
    }

    public function testUSStreetRequestReturnsWithCorrectNumberOfResults(StaticCredentials $credentials) {
        //3214 N University Ave. Provo, UT 84604
        //1 Rosedale Ave. Baltimore Maryland
    }

    public function testUSZIPCodeRequestReturnsWithCorrectNumberOfResults(StaticCredentials $credentials) {
        $client = (new ClientBuilder($credentials))->retryAtMost(0)->buildUsZIPCodeApiClient();
        $lookup = new Lookup(null, null, "84601");

        try {
            $client->sendLookup($lookup);
        }
        catch(\Exception $ex) {}

        $citiesAmount = count($lookup->getResult()->getCities());
        $this->assertResults("US_ZIPCode", $citiesAmount, 1);
    }

    private function assertResults($apiType, $actualResultCount, $expectedResultCount) {
        if ($actualResultCount == $expectedResultCount)
            print($apiType . " - OK\n");
        else
            print($apiType . " - FAILED\n");
    }
}