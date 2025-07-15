<?php

namespace SmartyStreets\PhpSdk;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use SmartyStreets\PhpSdk\US_Autocomplete\Client as USAutoCompleteApiClient;
use SmartyStreets\PhpSdk\US_Autocomplete_Pro\Client as USAutoCompleteProApiClient;
use SmartyStreets\PhpSdk\US_Extract\Client as USExtractApiClient;
use SmartyStreets\PhpSdk\International_Street\Client as InternationalStreetApiClient;
use SmartyStreets\PhpSdk\International_Autocomplete\Client as InternationalAutocompleteApiClient;
use SmartyStreets\PhpSdk\US_Street\Client as USStreetApiClient;
use SmartyStreets\PhpSdk\US_ZIPCode\Client as USZIPCodeApiClient;
use SmartyStreets\PhpSdk\US_Reverse_Geo\Client as USReverseGeoApiClient;
use SmartyStreets\PhpSdk\US_Enrichment\Client as USEnrichmentApiClient;

require_once(__DIR__ . '/Serializer.php');
require_once(__DIR__ . '/Request.php');
require_once(__DIR__ . '/NativeSerializer.php');
require_once(__DIR__ . '/NativeSender.php');
require_once(__DIR__ . '/StatusCodeSender.php');
require_once(__DIR__ . '/SigningSender.php');
require_once(__DIR__ . '/LicenseSender.php');
require_once(__DIR__ . '/RetrySender.php');
require_once(__DIR__ . '/URLPrefixSender.php');
require_once(__DIR__ . '/Batch.php');
require_once(__DIR__ . '/MyLogger.php');
require_once(__DIR__ . '/MySleeper.php');
require_once(__DIR__ . '/Proxy.php');
require_once(__DIR__ . '/US_Street/Client.php');
require_once(__DIR__ . '/US_ZIPCode/Client.php');
require_once(__DIR__ . '/US_Extract/Client.php');
require_once(__DIR__ . '/US_Autocomplete_Pro/Client.php');
require_once(__DIR__ . '/International_Street/Client.php');
require_once(__DIR__ . '/International_Autocomplete/Client.php');
require_once(__DIR__ . '/US_Reverse_Geo/Client.php');
require_once(__DIR__ . '/US_Enrichment/Client.php');

/**
 * The ClientBuilder class helps you build a client object for one of the supported SmartyStreets APIs.<br>
 * You can use ClientBuilder's methods to customize settings like maximum retries or timeout duration. These methods<br>
 * are chainable, so you can usually get set up with one line of code.
 */
class ClientBuilder {
    private $httpClient;
    private $requestFactory;
    private $streamFactory;
    private $serializer;

    public function __construct(
        ClientInterface $httpClient,
        RequestFactoryInterface $requestFactory,
        StreamFactoryInterface $streamFactory,
        Serializer $serializer
    ) {
        $this->httpClient = $httpClient;
        $this->requestFactory = $requestFactory;
        $this->streamFactory = $streamFactory;
        $this->serializer = $serializer;
    }

    public function buildUsStreetApiClient() {
        return new USStreetApiClient($this->httpClient, $this->requestFactory, $this->streamFactory, $this->serializer);
    }
    public function buildUsZIPCodeApiClient() {
        return new USZIPCodeApiClient($this->httpClient, $this->requestFactory, $this->streamFactory, $this->serializer);
    }
    public function buildUsExtractApiClient() {
        return new USExtractApiClient($this->httpClient, $this->requestFactory, $this->streamFactory, $this->serializer);
    }
    public function buildUsAutocompleteProApiClient() {
        return new USAutoCompleteProApiClient($this->httpClient, $this->requestFactory, $this->streamFactory, $this->serializer);
    }
    public function buildInternationalStreetApiClient() {
        return new InternationalStreetApiClient($this->httpClient, $this->requestFactory, $this->streamFactory, $this->serializer);
    }
    public function buildInternationalAutocompleteApiClient() {
        return new InternationalAutocompleteApiClient($this->httpClient, $this->requestFactory, $this->streamFactory, $this->serializer);
    }
    public function buildUsReverseGeoApiClient() {
        return new USReverseGeoApiClient($this->httpClient, $this->requestFactory, $this->streamFactory, $this->serializer);
    }
    public function buildUsEnrichmentApiClient() {
        return new USEnrichmentApiClient($this->httpClient, $this->requestFactory, $this->streamFactory, $this->serializer);
    }
}