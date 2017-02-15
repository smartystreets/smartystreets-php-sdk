<?php

namespace SmartyStreets\Tests\Mocks;

require_once(dirname(dirname(dirname(__FILE__))) . '/src/Sender.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/Response.php');
use SmartyStreets\Response;
use SmartyStreets\Request;
use SmartyStreets\Sender;

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