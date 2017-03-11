<?php

namespace SmartyStreets\PhpSdk;

class Request {
    const CHARSET = "UTF-8";
    private $headers,
            $parameters,
            $urlPrefix,
            $payload,
            $referer,
            $method;

    public function __construct() {
        $this->headers = array();
        $this->parameters = array();
        $this->urlPrefix = '';
        $this->method = 'GET';
    }

    public function setHeader($header, $value) {
        $this->headers[$header] = $value;
    }

    public function setParameter($name, $value) {
        if ($name === null || $value === null || strlen($name) == 0)
            return;

        $this->parameters[$name] = $value;
    }

    public function getUrl() {
        $url = $this->urlPrefix;

        if (!strpos($url, "?"))
            $url .= "?";

        foreach(array_keys($this->parameters) as $key) {
            if (!ArrayUtil::endsWith($url, "?"))
                $url .= "&";

            $encodedName = urlencode($key);
            $encodedValue = $this->getEncodedValue($this->parameters[$key]);
            $url .= $encodedName . "=" . $encodedValue;
        }

        return $url;
    }

    private function getEncodedValue($value) {
        if (is_bool($value))
             return $this->getBooleanValue($value);
        else
            return urlencode($value);
    }

    private function getBooleanValue($value) {
        if ($value === true)
            return 'true';
        else if ($value === false)
            return 'false';
    }

    //region [ Getters ]

    public function getHeaders() {
        return $this->headers;
    }

    public function getParameters() {
        return $this->parameters;
    }

    public function getPayload() {
        return $this->payload;
    }

    public function getReferer() {
        return $this->referer;
    }

    public function getMethod() {
        return $this->method;
    }

    //endregion

    //region [ Setters ]

    public function setPayload($payload) {
        $this->method = 'POST';
        $this->payload = $payload;
    }

    public function setReferer($referer) {
        $this->referer = $referer;
    }

    public function setUrlPrefix($urlPrefix) {
        $this->urlPrefix = $urlPrefix;
    }

    //endregion
}