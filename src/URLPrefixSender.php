<?php

namespace SmartyStreets\PhpSdk;

include_once('Sender.php');

class URLPrefixSender implements Sender {
    private $urlPrefix,
            $inner;

    public function __construct($urlPrefix, Sender $inner) {
        $this->urlPrefix = $urlPrefix;
        $this->inner = $inner;
    }

    function send(Request $request) {
        $request->setUrlPrefix($this->urlPrefix);
        return $this->inner->send($request);
    }
}