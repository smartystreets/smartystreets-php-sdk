<?php

namespace smartystreets\api\us_zipcode;

require_once(dirname(dirname(dirname(__FILE__))) . '/api/Sender.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/api/Serializer.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/api/Request.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/api/HttpSender.php');
require_once('Batch.php');
use smartystreets\api\Credentials;
use smartystreets\api\RetrySender;
use smartystreets\api\Sender;
use smartystreets\api\Serializer;
use smartystreets\api\Request;
use smartystreets\api\HttpSender;
use smartystreets\api\SigningSender;
use smartystreets\api\StaticCredentials;
use smartystreets\api\StatusCodeSender;

class ClientBuilder {
    private $signer,
            $serializer,
            $httpSender,
            $maxRetries,
            $maxTimeout,
            $urlPrefix;

    public function __construct(Credentials $signer = null, $authId = null, $authToken = null) {
        $this->serializer = new HttpSender(); //TODO:have it make a new HttpSender()
        $this->maxRetries = 5;
        $this->maxTimeout = 10000;
        $this->urlPrefix = "https://us-zipcode.api.smartystreets.com/lookup";

        if ($signer != null) {
            $this->signer = $signer;
        }
        else if ($authId != null && $authToken != null) {
            $this->signer = new StaticCredentials($authId, $authToken);
        }
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

    public function withUrl($urlPrefix) {
        $this->urlPrefix = $urlPrefix;
        return $this;
    }

    public function build() {
        return new Client($this->urlPrefix, $this->buildSender(), $this->serializer);
    }

    public function buildSender() {
        if ($this->httpSender != null)
            return $this->httpSender;

        $sender = new HttpSender($this->maxTimeout);

        $sender = new StatusCodeSender($sender);

        if ($this->signer != null)
            $sender = new SigningSender($this->signer, $sender);

        if ($this->maxRetries > 0)
            $sender = new RetrySender($this->maxRetries, $sender);

        return $sender;
    }

}