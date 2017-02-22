<?php

namespace SmartyStreets\PhpSdk\Tests\Mocks;

require_once(dirname(dirname(dirname(__FILE__))) . '/src/Sender.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/Response.php');
use SmartyStreets\PhpSdk\Response;
use SmartyStreets\PhpSdk\Request;
use SmartyStreets\PhpSdk\Sender;

class MockStatusCodeSender implements Sender {
    private $statusCode;

    public function __construct($statusCode) {
        $this->statusCode = $statusCode;
    }

    function send(Request $request) {
        if ($this->statusCode == 0)
            return null;

        return new Response($this->statusCode, "");
    }
}