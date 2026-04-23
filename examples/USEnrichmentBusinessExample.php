<?php

require_once(__DIR__ . '/../src/BasicAuthCredentials.php');
require_once(__DIR__ . '/../src/ClientBuilder.php');
require_once(__DIR__ . '/../src/US_Enrichment/Client.php');
require_once(__DIR__ . '/../src/US_Enrichment/Business/Summary/Lookup.php');
require_once(__DIR__ . '/../src/US_Enrichment/Business/Detail/Lookup.php');

use SmartyStreets\PhpSdk\BasicAuthCredentials;
use SmartyStreets\PhpSdk\ClientBuilder;

$authId = getenv('SMARTY_AUTH_ID');
$authToken = getenv('SMARTY_AUTH_TOKEN');

$client = (new ClientBuilder(new BasicAuthCredentials($authId, $authToken)))
    ->buildUsEnrichmentApiClient();

$smartyKey = "1962995076";

try {
    $summaryResults = $client->sendBusinessLookup($smartyKey);
} catch (Exception $ex) {
    echo $ex->getMessage() . "\n";
    exit(1);
}

if (empty($summaryResults)) {
    echo "No response returned for SmartyKey {$smartyKey}\n";
    exit(0);
}

$summary = $summaryResults[0];
if (empty($summary->businesses)) {
    echo "SmartyKey {$smartyKey} has no business tenants\n";
    exit(0);
}

echo "Summary results for SmartyKey: {$smartyKey}\n";
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
