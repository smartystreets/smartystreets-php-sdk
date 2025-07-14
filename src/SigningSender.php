<?php

namespace SmartyStreets\PhpSdk;

class SigningSender implements Sender {
    private $signer,
            $inner;

    public function __construct(Credentials $signer, Sender $inner) {
        $this->signer = $signer;
        $this->inner = $inner;
    }

    function send(Request $request) {
        $this->signer->sign($request);
        return $this->inner->send($request);
    }
}