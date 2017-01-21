<?php

namespace mocks;

require_once(dirname(dirname(dirname(__FILE__))) . '/src/smartystreets/api/Sender.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/smartystreets/api/Response.php');
use smartystreets\api\Response;
use smartystreets\api\Request;
use smartystreets\api\Sender as Sender;

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