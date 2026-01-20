<?php

require_once(__DIR__ . '/../src/ArrayUtil.php');
require_once(__DIR__ . '/../src/BasicAuthCredentials.php');
require_once(__DIR__ . '/../src/ClientBuilder.php');
require_once(__DIR__ . '/../src/US_Extract/Lookup.php');
require_once(__DIR__ . '/../src/US_Extract/Client.php');
use SmartyStreets\PhpSdk\BasicAuthCredentials;
use SmartyStreets\PhpSdk\ClientBuilder;
use SmartyStreets\PhpSdk\US_Extract\Lookup;
use SmartyStreets\PhpSdk\ArrayUtil;

$lookupExample = new USExtractExample();
$lookupExample->run();

class USExtractExample {
    public function run() {
        // $authId = 'Your SmartyStreets Auth ID here';
        // $authToken = 'Your SmartyStreets Auth Token here';

        // We recommend storing your secret keys in environment variables instead---it's safer!
       $authId = getenv('SMARTY_AUTH_ID');
       $authToken = getenv('SMARTY_AUTH_TOKEN');

        $credentials = new BasicAuthCredentials($authId, $authToken);
        $client = (new ClientBuilder($credentials))->buildUSExtractApiClient();
        $text = "Here is some text.\r\nMy address is 3785 Las Vegs Av." .
            "\r\nLos Vegas, Nevada." .
            "\r\nMeet me at 1 Rosedale Baltimore Maryland, not at 123 Phony Street, Boise Idaho.";

        // Documentation regarding input fields can be found at:
        // https://smartystreets.com/docs/cloud/us-extract-api

        $lookup = new Lookup($text);
        $lookup->isAggressive();
        $lookup->setAddressesHaveLineBreaks(false);
        $lookup->setAddressesPerLine(2);

        // Uncomment the below line to add a custom parameter to the API call
        // $lookup->addCustomParameter("parameter", "value");
        try {
            $client->sendLookup($lookup);
            $this->displayResults($lookup);
        }
        catch (\Exception $ex) {
            echo($ex->getMessage());
        }
    }

    public function displayResults(Lookup $lookup)
    {
        $result = $lookup->getResult();
        $metadata = $result->getMetadata();
        print('Found ' . $metadata->getAddressCount() . " addresses.\n");
        print($metadata->getVerifiedCount() . " of them were valid.\n\n");

        $addresses = $result->getAddresses();

        print("Addresses: \n**********************\n");
        foreach ($addresses as $address) {
            print("\n\"" . $address->getText() . "\"\n");
            print("\nVerified? " . ArrayUtil::getStringValueOfBoolean($address->isVerified()));
            if (count($address->getCandidates()) > 0) {
                print("\nMatches:");

                foreach ($address->getCandidates() as $candidate) {
                    print("\n" . $candidate->getDeliveryLine1());
                    print("\n" . $candidate->getLastLine() . "\n");
                }
            } else print("\n");

            print("**********************\n");
        }
    }
}