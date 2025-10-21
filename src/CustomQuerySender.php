<?php

namespace SmartyStreets\PhpSdk;

include_once('Sender.php');

class CustomQuerySender implements Sender {
    private $queries,
            $inner;

    public function __construct($queries, Sender $inner) {
        $this->queries = $queries;
        $this->inner = $inner;
    }

    public function send(Request $request) {
        foreach ($this->queries as $key => $value) {
            $request->setParameter($key, $value);
        }
        return $this->inner->send($request);
    }
}