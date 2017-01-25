<?php

namespace smartystreets\api;

include_once('Sender.php');

class HttpSender implements Sender {

    private $maxTimeOut;

    public function __construct($maxTimeOut = null) {
        if ($maxTimeOut == null)
            $this->maxTimeOut = 10000;
        else
            $this->maxTimeOut = $maxTimeOut;
    }

    function send(Request $request) {
        return new Response("", ""); // TODO: implement
    }

}