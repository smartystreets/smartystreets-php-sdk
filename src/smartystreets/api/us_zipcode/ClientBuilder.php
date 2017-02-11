<?php

namespace smartystreets\api\us_zipcode;

//foreach (glob(dirname(dirname(dirname(__FILE__))) . '/api/*.php') as $filename) {
//    include $filename;
//}
require_once(dirname(dirname(dirname(__FILE__))) . '/api/Serializer.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/api/Request.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/api/NativeSerializer.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/api/NativeSender.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/api/StatusCodeSender.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/api/SigningSender.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/api/RetrySender.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/api/Batch.php');
require_once('Client.php');
require_once('Lookup.php');
use smartystreets\api\Credentials;
use smartystreets\api\NativeSender;
use smartystreets\api\RetrySender;
use smartystreets\api\Sender;
use smartystreets\api\Serializer;
use smartystreets\api\SigningSender;
use smartystreets\api\StatusCodeSender;
use smartystreets\api\NativeSerializer;

class ClientBuilder { //TODO: try and make a parent ClientBuilder for both us_street and us_zipcode
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
        $this->urlPrefix = "https://us-zipcode.api.smartystreets.com/lookup";
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

    public function build() {
        return new Client($this->urlPrefix, $this->buildSender(), $this->serializer, $this->referer);
    }

    public function buildSender() {
        if ($this->httpSender != null)
            return $this->httpSender;

        $sender = new NativeSender($this->maxTimeout);

        $sender = new StatusCodeSender($sender);

        if ($this->signer != null)
            $sender = new SigningSender($this->signer, $sender);

        if ($this->maxRetries > 0)
            $sender = new RetrySender($this->maxRetries, $sender);

        return $sender;
    }

}