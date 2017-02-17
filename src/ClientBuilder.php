<?php

namespace SmartyStreets;

require_once('Serializer.php');
require_once('Request.php');
require_once('NativeSerializer.php');
require_once('NativeSender.php');
require_once('StatusCodeSender.php');
require_once('SigningSender.php');
require_once('RetrySender.php');
require_once('URLPrefixSender.php');
require_once('Batch.php');
require_once(dirname(__FILE__) . '/US_Street/Client.php');
require_once(dirname(__FILE__) . '/US_ZipCode/Client.php');

class ClientBuilder {
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
            $referer;

    public function __construct(Credentials $signer = null) {
        $this->serializer = new NativeSerializer();
        $this->maxRetries = 5;
        $this->maxTimeout = 10000;
        $this->signer = $signer;
    }

    public function retryAtMost($maxRetries) {
        $this->maxRetries = $maxRetries;
        return $this;
    }

    public function withMaxTimeout($maxTimeout) {
        $this->maxTimeout = $maxTimeout;
        return $this;
    }

    public function withSender(Sender $sender) {
        $this->httpSender = $sender;
        return $this;
    }

    public function withSerializer(Serializer $serializer) {
        $this->serializer = $serializer;
        return $this;
    }

    public function withReferer($referer) {
        $this->referer = $referer;
        return $this;
    }

    public function withUrl($urlPrefix) {
        $this->urlPrefix = $urlPrefix;
        return $this;
    }

    public function buildUsStreetApiClient() {
        $this->ensureURLPrefixNotNull(self::US_STREET_API_URL);
        return new \SmartyStreets\US_Street\Client($this->buildSender(), $this->serializer, $this->referer);
    }

    public function buildUsZipCodeApiClient() {
        $this->ensureURLPrefixNotNull(self::US_ZIP_CODE_API_URL);
        return new \SmartyStreets\US_ZipCode\Client($this->buildSender(), $this->serializer, $this->referer);
    }

    public function buildSender() {
        if ($this->httpSender != null)
            return $this->httpSender;

        $sender = new NativeSender($this->maxTimeout);

        $sender = new StatusCodeSender($sender);

        if ($this->maxRetries > 0)
            $sender = new RetrySender($this->maxRetries, $sender);

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