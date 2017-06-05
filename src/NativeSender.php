<?php

namespace SmartyStreets\PhpSdk;

include_once('Sender.php');
require_once('Response.php');
require_once('Version.php');
use SmartyStreets\PhpSdk\Exceptions\SmartyException;

class NativeSender implements Sender {
    private $maxTimeOut,
            $proxyAddress,
            $proxyUserPwd;

    public function __construct($maxTimeOut = 10000, $proxyAddress, $proxyUserPwd = null) {
        $this->maxTimeOut = $maxTimeOut;
        $this->proxyAddress = $proxyAddress;
        $this->proxyUserPwd = $proxyUserPwd;
    }

    function send(Request $smartyRequest) {
        $ch = $this->buildRequest($smartyRequest);
        $this->setHeaders($smartyRequest, $ch);
        $payload = curl_exec($ch);

        $connectCode = curl_getinfo($ch, CURLINFO_HTTP_CONNECTCODE);
        if ($payload === FALSE && $connectCode != 200) {
            $errorMessage = curl_error($ch);
            curl_close($ch);
            throw new SmartyException($errorMessage);
        }

        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return new Response($statusCode, $payload);
    }

    private function buildRequest(Request $smartyRequest) {
        $url = $smartyRequest->getUrl();

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $smartyRequest->getMethod());
        curl_setopt($ch, CURLOPT_POSTFIELDS, ($smartyRequest->getPayload()));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->setHeaders($smartyRequest));
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, $this->maxTimeOut);
        curl_setopt($ch, CURLOPT_USERAGENT, 'smartystreets (sdk:php@' . VERSION . ')');

        if ($this->proxyAddress != null)
            $this->setProxy($ch);

        if ($smartyRequest->getReferer() != null)
            curl_setopt($ch, CURLOPT_REFERER, $smartyRequest->getReferer());

        return $ch;
    }

    private function setProxy(&$ch) {
        curl_setopt($ch, CURLOPT_PROXY, $this->proxyAddress);

        if ($this->proxyUserPwd != null)
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->proxyUserPwd);
    }

    private function setHeaders(Request $smartyRequest) {
        $headers = array();

        foreach (array_keys($smartyRequest->getHeaders()) as $key) {
            $headers[$key] = $smartyRequest->getHeaders()[$key];
        }

        $headers[] = 'Content-Type: ' . $smartyRequest->getContentType();

        return $headers;
    }
}