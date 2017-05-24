<?php

namespace SmartyStreets\PhpSdk;

use SmartyStreets\PhpSdk\US_Autocomplete\Client as USAutoCompleteApiClient;
use SmartyStreets\PhpSdk\US_Extract\Client as USExtractApiClient;
use SmartyStreets\PhpSdk\International_Street\Client as InternationalStreetApiClient;
use SmartyStreets\PhpSdk\US_Street\Client as USStreetApiClient;
use SmartyStreets\PhpSdk\US_ZIPCode\Client as USZIPCodeApiClient;

require_once('Serializer.php');
require_once('Request.php');
require_once('NativeSerializer.php');
require_once('NativeSender.php');
require_once('StatusCodeSender.php');
require_once('SigningSender.php');
require_once('RetrySender.php');
require_once('URLPrefixSender.php');
require_once('Batch.php');
require_once('MyLogger.php');
require_once('MySleeper.php');
require_once(dirname(__FILE__) . '/US_Street/Client.php');
require_once(dirname(__FILE__) . '/US_ZIPCode/Client.php');
require_once(dirname(__FILE__) . '/US_Extract/Client.php');
require_once(dirname(__FILE__) . '/US_Autocomplete/Client.php');
require_once(dirname(__FILE__) . '/International_Street/Client.php');

/**
 * The ClientBuilder class helps you build a client object for one of the supported SmartyStreets APIs.<br>
 * You can use ClientBuilder's methods to customize settings like maximum retries or timeout duration. These methods<br>
 * are chainable, so you can usually get set up with one line of code.
 */
class ClientBuilder {
    const INTERNATIONAL_STREET_API_URL = "https://international-street.api.smartystreets.com/verify";
    const US_AUTOCOMPLETE_API_URL = "https://us-autocomplete.api.smartystreets.com/suggest";
    const US_EXTRACT_API_URL = "https://us-extract.api.smartystreets.com";
    const US_STREET_API_URL = "https://us-street.api.smartystreets.com/street-address";
    const US_ZIP_CODE_API_URL = "https://us-zipcode.api.smartystreets.com/lookup";

    private $signer,
            $serializer,
            $httpSender,
            $maxRetries,
            $maxTimeout,
            $urlPrefix,
            $proxyUrl,
            $proxyPort,
            $proxyUserPwd;

    public function __construct(Credentials $signer = null) {
        $this->serializer = new NativeSerializer();
        $this->maxRetries = 5;
        $this->maxTimeout = 10000;
        $this->signer = $signer;
    }

    /**
     * @param maxRetries The maximum number of times to retry sending the request to the API. (Default is 5)
     * @return Returns <b>this</b> to accommodate method chaining.
     */
    public function retryAtMost($maxRetries) {
        $this->maxRetries = $maxRetries;
        return $this;
    }

    /**
     * @param maxTimeout The maximum time (in milliseconds) to wait for a connection, and also to wait for <br>
     *                   the response to be read. (Default is 10000)
     * @return Returns <b>this</b> to accommodate method chaining.
     */
    public function withMaxTimeout($maxTimeout) {
        $this->maxTimeout = $maxTimeout;
        return $this;
    }

    public function withProxy($proxyUrl, $proxyPort = null, $proxyUsername = null, $proxyPassword = null) {
        $this->proxyUrl = $proxyUrl;
        $this->proxyPort = $proxyPort;

        if ($proxyUsername != null && $proxyPassword != null)
            $this->proxyUserPwd[$proxyUsername] = $proxyPassword;
        return $this;
    }

    /**
     * @param sender Default is a series of nested senders. See <b>buildSender()</b>.
     * @return Returns <b>this</b> to accommodate method chaining.
     */
    public function withSender(Sender $sender) {
        $this->httpSender = $sender;
        return $this;
    }

    /**
     * Changes the <b>Serializer</b> from the default <b>NativeSerializer</b>.
     * @param serializer An object that implements the <b>Serializer</b> interface.
     * @return Returns <b>this</b> to accommodate method chaining.
     */
    public function withSerializer(Serializer $serializer) {
        $this->serializer = $serializer;
        return $this;
    }

    /**
     * This may be useful when using a local installation of the SmartyStreets APIs.
     * @param baseUrl Defaults to the URL for the API corresponding to the <b>Client</b> object being built.
     * @return Returns <b>this</b> to accommodate method chaining.
     */
    public function withUrl($urlPrefix) {
        $this->urlPrefix = $urlPrefix;
        return $this;
    }

    public function buildUSAutocompleteApiClient() {
        $this->ensureURLPrefixNotNull(self::US_AUTOCOMPLETE_API_URL);
        return new USAutoCompleteApiClient($this->buildSender(), $this->serializer);
    }

    public function buildUSExtractApiClient() {
        $this->ensureURLPrefixNotNull(self::US_EXTRACT_API_URL);
        return new USExtractApiClient($this->buildSender(), $this->serializer);
    }

    public function buildInternationalStreetApiClient() {
        $this->ensureURLPrefixNotNull(self::INTERNATIONAL_STREET_API_URL);
        return new InternationalStreetApiClient($this->buildSender(), $this->serializer);
    }

    public function buildUsStreetApiClient() {
        $this->ensureURLPrefixNotNull(self::US_STREET_API_URL);
        return new USStreetApiClient($this->buildSender(), $this->serializer);
    }

    public function buildUsZIPCodeApiClient() {
        $this->ensureURLPrefixNotNull(self::US_ZIP_CODE_API_URL);
        return new USZIPCodeApiClient($this->buildSender(), $this->serializer);
    }

    private function buildSender() {
        if ($this->httpSender != null)
            return $this->httpSender;

        $sender = new NativeSender($this->maxTimeout, $this->proxyUrl, $this->proxyPort, $this->proxyUserPwd);

        $sender = new StatusCodeSender($sender);

        if ($this->maxRetries > 0)
            $sender = new RetrySender($this->maxRetries, new MySleeper(), new MyLogger(), $sender);

        if ($this->signer != null)
            $sender = new SigningSender($this->signer, $sender);

        $sender = new URLPrefixSender($this->urlPrefix, $sender);

        return $sender;
    }

    private function ensureURLPrefixNotNull($url) {
        if ($this->urlPrefix == null)
            $this->urlPrefix = $url;
    }
}