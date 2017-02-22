<?php

namespace SmartyStreets\PhpSdk;

include_once('Sender.php');
require_once('Response.php');
require_once('Version.php');

class NativeSender implements Sender {
    private $maxTimeOut;

    public function __construct($maxTimeOut = 10000) {
        $this->maxTimeOut = $maxTimeOut;
    }

    function send(Request $smartyRequest) {
        $ch = $this->buildRequest($smartyRequest);
        $this->setHeaders($smartyRequest, $ch);

        $response = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return new Response($statusCode, $response);
    }

    private function buildRequest(Request $smartyRequest) {
        $url = $smartyRequest->getUrl();

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, ($smartyRequest->getPayload()));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->setHeaders($smartyRequest));
        curl_setopt($ch, CURLOPT_USERAGENT, 'smartystreets (sdk:php@' . VERSION . ')');

        if ($smartyRequest->getReferer() != null)
            curl_setopt($ch, CURLOPT_REFERER, $smartyRequest->getReferer());

        return $ch;
    }

    private function setHeaders(Request $smartyRequest) {
        $headers = array();

        foreach (array_keys($smartyRequest->getHeaders()) as $key) {
            $headers[$key] = $smartyRequest->getHeaders()[$key];
        }

        $headers[] = 'Content-Type: application/json';

        return $headers;
    }
}