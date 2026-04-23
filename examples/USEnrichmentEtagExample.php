<?php

require_once(__DIR__ . '/../src/BasicAuthCredentials.php');
require_once(__DIR__ . '/../src/ClientBuilder.php');
require_once(__DIR__ . '/../src/US_Enrichment/Client.php');
require_once(__DIR__ . '/../src/US_Enrichment/Business/Summary/Lookup.php');
require_once(__DIR__ . '/../src/US_Enrichment/Business/Detail/Lookup.php');

use SmartyStreets\PhpSdk\BasicAuthCredentials;
use SmartyStreets\PhpSdk\ClientBuilder;
use SmartyStreets\PhpSdk\Exceptions\RequestNotModifiedException;
use SmartyStreets\PhpSdk\US_Enrichment\Business\Detail\Lookup as DetailLookup;
use SmartyStreets\PhpSdk\US_Enrichment\Business\Summary\Lookup as SummaryLookup;

function display(?string $s): string {
    return ($s === null || $s === '') ? '<none>' : $s;
}

function exerciseSummaryEtag($client, string $smartyKey): ?string {
    echo "=== Business.Summary ETag round trip ===\n";

    $first = new SummaryLookup($smartyKey);
    try {
        $client->sendBusinessLookup($first);
    } catch (Exception $ex) {
        echo "  Initial Summary call failed: " . $ex->getMessage() . "\n";
        return null;
    }

    $results = $first->getResults();
    $captured = $first->getResponseEtag();
    echo "  Call 1 (no Etag): captured Etag=" . display($captured) . ", results=" . count($results) . "\n";

    if ($captured === null || $captured === '') {
        echo "  Server did not return an Etag header; skipping conditional calls.\n";
        return firstBusinessId($results);
    }

    $second = new SummaryLookup($smartyKey);
    $second->setRequestEtag($captured);
    try {
        $client->sendBusinessLookup($second);
        echo "  Call 2 (matching Etag): 200 — server did NOT honor the conditional. Results=" . count($second->getResults())
            . ", Etag=" . display($second->getResponseEtag()) . "\n";
    } catch (RequestNotModifiedException $ex) {
        echo "  Call 2 (matching Etag): 304 RequestNotModifiedException — caller treats this as cache-valid. Refreshed Etag=" . display($ex->getResponseEtag()) . "\n";
    } catch (Exception $ex) {
        echo "  Call 2 unexpected failure: " . get_class($ex) . ": " . $ex->getMessage() . "\n";
        return null;
    }

    $third = new SummaryLookup($smartyKey);
    $third->setRequestEtag($captured . "X");
    try {
        $client->sendBusinessLookup($third);
        echo "  Call 3 (mutated Etag): 200 as expected. Results=" . count($third->getResults())
            . ", Etag=" . display($third->getResponseEtag()) . "\n";
    } catch (RequestNotModifiedException $ex) {
        echo "  Call 3 (mutated Etag): 304 — UNEXPECTED. Server treated a different Etag as matching.\n";
    } catch (Exception $ex) {
        echo "  Call 3 unexpected failure: " . get_class($ex) . ": " . $ex->getMessage() . "\n";
    }

    return firstBusinessId($results);
}

function exerciseDetailEtag($client, string $businessId): void {
    echo "\n=== Business.Detail ETag round trip (businessId: {$businessId}) ===\n";

    $first = new DetailLookup($businessId);
    try {
        $client->sendBusinessDetailLookup($first);
    } catch (Exception $ex) {
        echo "  Initial Detail call failed: " . $ex->getMessage() . "\n";
        return;
    }

    $initial = $first->getResult();
    $captured = $first->getResponseEtag();
    echo "  Call 1 (no Etag): captured Etag=" . display($captured)
        . ", businessId=" . ($initial->businessId ?? '<null>') . "\n";

    if ($captured === null || $captured === '') {
        echo "  Server did not return an Etag header; skipping conditional calls.\n";
        return;
    }

    $second = new DetailLookup($businessId);
    $second->setRequestEtag($captured);
    try {
        $client->sendBusinessDetailLookup($second);
        echo "  Call 2 (matching Etag): 200 — server did NOT honor the conditional. businessId="
            . ($second->getResult()->businessId ?? '<null>') . ", Etag=" . display($second->getResponseEtag()) . "\n";
    } catch (RequestNotModifiedException $ex) {
        echo "  Call 2 (matching Etag): 304 RequestNotModifiedException — caller treats this as cache-valid. Refreshed Etag="
            . display($ex->getResponseEtag()) . "\n";
    } catch (Exception $ex) {
        echo "  Call 2 unexpected failure: " . get_class($ex) . ": " . $ex->getMessage() . "\n";
        return;
    }

    $third = new DetailLookup($businessId);
    $third->setRequestEtag($captured . "X");
    try {
        $client->sendBusinessDetailLookup($third);
        echo "  Call 3 (mutated Etag): 200 as expected. businessId="
            . ($third->getResult()->businessId ?? '<null>') . ", Etag=" . display($third->getResponseEtag()) . "\n";
    } catch (RequestNotModifiedException $ex) {
        echo "  Call 3 (mutated Etag): 304 — UNEXPECTED. Server treated a different Etag as matching.\n";
    } catch (Exception $ex) {
        echo "  Call 3 unexpected failure: " . get_class($ex) . ": " . $ex->getMessage() . "\n";
    }
}

function firstBusinessId(array $results): ?string {
    if (empty($results) || empty($results[0]->businesses)) {
        return null;
    }
    return $results[0]->businesses[0]->businessId;
}

$authId = getenv('SMARTY_AUTH_ID');
$authToken = getenv('SMARTY_AUTH_TOKEN');

$client = (new ClientBuilder(new BasicAuthCredentials($authId, $authToken)))
    ->buildUsEnrichmentApiClient();

$businessId = exerciseSummaryEtag($client, "1962995076");
if ($businessId !== null) {
    exerciseDetailEtag($client, $businessId);
}
