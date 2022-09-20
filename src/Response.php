<?php

namespace SmartyStreets\PhpSdk;

class Response
{
    //region [ Fields ]

    private $statusCode,
        $payload,
        $headers;

    //endregion

    //region [ Constructors ]

    public function __construct($statusCode, $payload, $headers)
    {
        $this->statusCode = $statusCode;
        $this->payload = $payload;
        $this->headers = $headers;
    }

    //endregion

    //region [ Getters ]

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function getHeaders(){
        return $this->headers;
    }

    public function getPayload()
    {
        return $this->payload;
    }

    //endregion

    //region [ Setters ]

    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
    }

    public function setPayload($payload)
    {
        $this->payload = $payload;
    }

    //endregion
}