<?php

namespace smartystreets\api;

class Request {
    const CHARSET = "UTF-8";
    private $headers,
            $parameters,
            $baseUrl,
            $payload,
            $referer;

    public function __construct($baseUrl = null) {
        $this->headers = array();
        $this->parameters = array();
        $this->baseUrl = $baseUrl;
    }

    public function setHeader($header, $value) {
        $this->headers[$header] = $value;
    }

    public function setParameter($name, $value) {
        if ($name === null || $value === null || strlen($name) == 0)
            return;

        $this->parameters[$name] = $value;
    }

    public function getBaseUrl() {
        return $this->baseUrl;
    }

    public function getHeaders() {
        return $this->headers;
    }

    public function getParameters() {
        return $this->parameters;
    }

    public function getPayload() {
        return $this->payload;
    }

    public function setPayload($payload) {
        $this->payload = $payload;
    }

    public function setReferer($referer) {
        $this->referer = $referer;
    }

    public function getReferer() {
        return $this->referer;
    }
}