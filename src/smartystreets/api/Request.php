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

    private static function urlEncode($value) {
        return urlencode($value);
    }

    public function getUrl() {
        $url = $this->baseUrl;

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

    //endregion

    //region [ Setters ]

    public function setPayload($payload) {
        $this->payload = $payload;
    }

    public function setReferer($referer) {
        $this->referer = $referer;
    }

    //endregion
}