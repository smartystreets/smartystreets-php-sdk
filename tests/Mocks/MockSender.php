<?php

namespace SmartyStreets\PhpSdk\Tests\Mocks;

require_once(dirname(dirname(dirname(__FILE__))) . '/src/Sender.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/Response.php');
use SmartyStreets\PhpSdk\Response;
use SmartyStreets\PhpSdk\Request;
use SmartyStreets\PhpSdk\Sender;

class MockSender implements Sender {
    private $response,
            $request;

    public function __construct(Response $response) {
        $this->response = $response;
    }

    function send(Request $request) {
        $this->request = $request;
        return $this->response;
    }

    public function getRequest() {
        return $this->request;
    }
}