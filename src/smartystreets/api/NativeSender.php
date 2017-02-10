<?php

namespace smartystreets\api;

include_once('Sender.php');
require_once('Response.php');

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

        return $this->buildResponse($statusCode, $response);
    }

    private function buildRequest(Request $smartyRequest) {
        $url = $smartyRequest->getUrl();

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, ($smartyRequest->getPayload()));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->setHeaders($smartyRequest));

        return $ch;
    }

    private function setHeaders(Request $smartyRequest) {
        $headers = array();

        foreach (array_keys($smartyRequest->getHeaders()) as $key) {
            $headers[$key] = $smartyRequest->getHeaders()[$key];
        }

        $headers[] = 'Content-Type: application/json';
//        $headers['User-Agent'] = 'smartystreets (sdk:php@' . VERSION . ')'; //TODO: get VERSION working
        if ($smartyRequest->getReferer() != null)
            $headers['Referer'] = $smartyRequest->getReferer();

        return $headers;
    }

    private function buildResponse($statusCode, $response) {
        return new Response($statusCode, $response);
    }
}