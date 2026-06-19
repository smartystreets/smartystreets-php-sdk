<?php

require_once(__DIR__ . '/../src/BasicAuthCredentials.php');
require_once(__DIR__ . '/../src/ClientBuilder.php');
require_once(__DIR__ . '/../src/US_Enrichment/Client.php');
require_once(__DIR__ . '/../src/US_Enrichment/Business/Summary/Lookup.php');
require_once(__DIR__ . '/../src/US_Enrichment/Business/Detail/Lookup.php');

use SmartyStreets\PhpSdk\BasicAuthCredentials;
use SmartyStreets\PhpSdk\ClientBuilder;
use SmartyStreets\PhpSdk\US_Enrichment\Business\Summary\Lookup as SummaryLookup;

$authId = getenv('SMARTY_AUTH_ID');
$authToken = getenv('SMARTY_AUTH_TOKEN');

$client = (new ClientBuilder(new BasicAuthCredentials($authId, $authToken)))
    ->buildUsEnrichmentApiClient();

$lookup = new SummaryLookup();
$lookup->setBusinessName("delta air");
$lookup->setCity("atlanta");

try {
    $summaryResults = $client->sendBusinessLookup($lookup);
} catch (Exception $ex) {
    echo $ex->getMessage() . "\n";
    exit(1);
}

if (empty($summaryResults)) {
    echo "No response returned for business-name search\n";
    exit(0);
}

$summary = $summaryResults[0];
if (empty($summary->businesses)) {
    echo "No matching businesses found\n";
    exit(0);
}

echo "Summary results for businessName: {$lookup->getBusinessName()}\n";
foreach ($summary->businesses as $biz) {
    echo "  - {$biz->companyName} (ID: {$biz->businessId})\n";
}

$first = $summary->businesses[0];
echo "\nFetching details for business: {$first->companyName} (ID: {$first->businessId})\n";

try {
    $detail = $client->sendBusinessDetailLookup($first->businessId);
} catch (Exception $ex) {
    echo $ex->getMessage() . "\n";
    exit(1);
}

if ($detail === null) {
    echo "\nNo detail result returned\n";
    exit(0);
}

echo "\nDetail result:\n";
echo "  smartyKey:   {$detail->smartyKey}\n";
echo "  dataSetName: {$detail->dataSetName}\n";
echo "  businessId:  {$detail->businessId}\n";
if ($detail->attributes !== null) {
    foreach ($detail->attributes as $name => $value) {
        if ($value === null || $value === '') {
            continue;
        }
        echo "  {$name}: {$value}\n";
    }
}
