<?php

namespace smartystreets\api;

class Request {
    const CHARSET = "UTF-8";
    private $headers,
            $parameters,
            $urlPrefix,
            $method,
            $payload;

    public function __construct($urlPrefix = null) {
        $this->method = "GET";
        $this->headers = array();
        $this->parameters = array();
        $this->urlPrefix = $urlPrefix;
    }

    public function setHeader($header, $value) {
        $this->headers[$header] = $value;
    }

    public function setParameter($name, $value) {
        if ($name === null || $value === null || strlen($name) == 0)
            return;

        $this->parameters[$name] = $value;
    }

    private static function urlEncode($value) {
        return urlencode($value);
    }

    public function getUrl() {
        $url = $this->urlPrefix;

        if (!strpos($url, "?"))
            $url .= "?";

        foreach(array_keys($this->parameters) as $key) {
            if (!$this->endsWith($url, "?"))
                $url .= "&";

            $encodedName = self::urlEncode($key);
            $encodedValue = self::urlEncode($this->parameters[$key]);
            $url .= $encodedName . "=" . $encodedValue;
        }

        return $url;
    }

    function endsWith($haystack, $needle) {
        // search forward starting from end minus needle length characters
        return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
    }

    public function getHeaders() {
        return $this->headers;
    }

    public function getMethod() {
        return $this->method;
    }

    public function getPayload() {
        return $this->payload;
    }

    public function setPayload($payload) {
        $this->method = "POST";
        $this->payload = $payload;
    }




}