<?php

namespace smartystreets\api;

class Response {
    //region [ Fields ]

    private $statusCode,
            $payload;

    //endregion

    //region [ Constructors ]

    public function __construct() {
        $argv = func_get_args();
        $i = func_num_args();
        if (method_exists($this, $f='__construct'.$i)) {
            call_user_func_array(array($this, $f), $argv);
        }
    }

    public function __construct1($argv1, $argv2) {
        $this->statusCode = $argv1;
        $this->payload = $argv2;
    }

    //endregion

    //region [ Getters ]

    public function getStatusCode() {
        return $this->statusCode;
    }

    public function getPayload() {
        return $this->payload;
    }

    //endregion

    //region [ Setters ]

    public function setStatusCode($statusCode) {
        $this->statusCode = $statusCode;
    }

    public function setPayload($payload) {
        $this->payload = $payload;
    }

    //endregion
}