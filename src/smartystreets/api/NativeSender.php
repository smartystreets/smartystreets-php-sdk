<?php

namespace smartystreets\api;

include_once('Sender.php');
require_once 'HTTP/Request.php';

use HttpRequest;
//require_once(\HttpRequest::);


class NativeSender implements Sender {
    private $maxTimeOut;

    public function __construct($maxTimeOut = 10000) {
        $this->maxTimeOut = $maxTimeOut;
    }

    function send(Request $smartyRequest) {
        $nativeRequest = $this->buildRequest($smartyRequest);
        $this->setHeaders($smartyRequest, $nativeRequest);

        $httpMessage = $nativeRequest->send();

        return $this->buildResponse($httpMessage);
    }

    private function buildRequest(Request $smartyRequest) {
        $url = $smartyRequest->getBaseUrl();
        $nativeRequest = new HttpRequest($url, "POST");

        $this->buildQuery($smartyRequest, $nativeRequest);
        $nativeRequest->setRawPostData($smartyRequest->getPayload());

        return $nativeRequest;
    }

    private function buildQuery(Request $smartyRequest, HttpRequest $nativeRequest) {
        foreach ($smartyRequest->getParameters() as $parameter) {
            $nativeRequest->addQueryData($parameter);
        }
    }

    private function setHeaders(Request $smartyRequest, HttpRequest $nativeRequest) {
        $nativeRequest->addHeaders($smartyRequest->getHeaders());
        $nativeRequest->setContentType('application/json');

        $nativeRequest->addHeaders(array('User-Agent' => 'smartystreets (sdk:php@' . VERSION . ')'));
        $nativeRequest->addHeaders(array('Referer' => $smartyRequest->getReferer()));
    }

    private function buildResponse(\HttpMessage $httpMessage) {
        return new Response($httpMessage->getResponseCode(), $httpMessage->getBody());
    }
}