<?php

namespace SmartyStreets\PhpSdk;

include_once('Sender.php');

class RetrySender implements Sender {
    private $inner,
            $maxRetries;

    public function __construct($maxRetries, Sender $inner) {
        $this->inner = $inner;
        $this->maxRetries = $maxRetries;
    }

    public function send(Request $request) {
        for ($i = 0; $i <= $this->maxRetries; $i++) {
            $response = $this->trySend($request, $i);

            if ($response != null)
                return $response;
        }
        return null;
    }

    private function trySend(Request $request, $attempt) {
        try {
            return $this->inner->send($request);
        } catch (\Exception $ex) {
            if ($attempt >= $this->maxRetries)
                throw $ex;
        }

        return null;
    }

    public function getInner() {
        return $this->inner;
    }

    public function getMaxRetries() {
        return $this->maxRetries;
    }
}