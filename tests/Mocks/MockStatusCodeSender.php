<?php

namespace SmartyStreets\PhpSdk\Tests\Mocks;

require_once(dirname(dirname(dirname(__FILE__))) . '/src/Sender.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/Response.php');
use SmartyStreets\PhpSdk\Response;
use SmartyStreets\PhpSdk\Request;
use SmartyStreets\PhpSdk\Sender;

class MockStatusCodeSender implements Sender {
    private $statusCode,
    $body,
    $headers;

    public function __construct($statusCode, $body = null, $headers = null) {
        $this->statusCode = $statusCode;
        $this->body = $body;
        $this->headers = $headers;
    }

    function send(Request $request) {
        if ($this->statusCode == 0)
            return null;

        return new Response($this->statusCode, $this->body, $this->headers);
    }
}