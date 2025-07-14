<?php

namespace SmartyStreets\PhpSdk;

class LicenseSender implements Sender {
    private $licenses,
            $inner;

    public function __construct($licenses, Sender $inner) {
        $this->licenses = $licenses;
        $this->inner = $inner;
    }

    public function send(Request $request) {
        if (count($this->licenses) > 0) {
            $request->setParameter("license", join(",", $this->licenses));
        }
        return $this->inner->send($request);
    }
}