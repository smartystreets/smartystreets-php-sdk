<?php

require_once(dirname(dirname(__FILE__)) . '/src/ArrayUtil.php');
require_once(dirname(dirname(__FILE__)) . '/src/StaticCredentials.php');
require_once(dirname(dirname(__FILE__)) . '/src/ClientBuilder.php');
require_once(dirname(dirname(__FILE__)) . '/src/US_Extract/Lookup.php');
require_once(dirname(dirname(__FILE__)) . '/src/US_Extract/Client.php');
use SmartyStreets\PhpSdk\StaticCredentials;
use SmartyStreets\PhpSdk\ClientBuilder;
use SmartyStreets\PhpSdk\US_Extract\Lookup;
use SmartyStreets\PhpSdk\ArrayUtil;

$lookupExample = new USExtractExample();
$lookupExample->run();

class USExtractExample {
    public function run() {
        // We recommend storing your secret keys in environment variables.
        $staticCredentials = new StaticCredentials(getenv('SMARTY_AUTH_ID'), getenv('SMARTY_AUTH_TOKEN'));
        $client = (new ClientBuilder($staticCredentials))->buildUSExtractApiClient();
        $text = "Here is some text.\r\nMy address is 3785 Las Vegs Av." .
            "\r\nLos Vegas, Nevada." .
            "\r\nMeet me at 1 Rosedale Baltimore Maryland, not at 123 Phony Street, Boise Idaho.";

        $lookup = new Lookup($text);

        $client->sendLookup($lookup);

        $result = $lookup->getResult();
        $metadata = $result->getMetadata();
        print('Found ' . $metadata->getAddressCount() . " addresses.\n");
        print($metadata->getVerifiedCount() . " of them were valid.\n\n");

        $addresses = $result->getAddresses();

        print("Addresses: \n**********************\n");
        foreach($addresses as $address) {
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