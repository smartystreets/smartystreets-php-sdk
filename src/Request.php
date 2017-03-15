<?php

namespace SmartyStreets\PhpSdk;

require_once('ArrayUtil.php');

class Request {
    const CHARSET = "UTF-8";
    private $headers,
            $parameters,
            $urlPrefix,
            $payload,
            $referer,
            $method,
            $contentType;

    public function __construct() {
        $this->headers = array();
        $this->parameters = array();
        $this->urlPrefix = '';
        $this->method = 'GET';
        $this->contentType = 'application/json';

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
            $encodedValue = ArrayUtil::getEncodedValue($this->parameters[$key]);
            $url .= $encodedName . "=" . $encodedValue;
        }

        return $url;
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

    public function getContentType() {
        return $this->contentType;
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

    public function setContentType($contentType) {
        $this->contentType = $contentType;
    }

    //endregion
}