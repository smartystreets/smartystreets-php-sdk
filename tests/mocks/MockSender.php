<?php

namespace mocks;

require_once(dirname(dirname(dirname(__FILE__))) . '/src/smartystreets/api/Sender.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/smartystreets/api/Response.php');
use smartystreets\api\Response;
use smartystreets\api\Request;
use smartystreets\api\Sender as Sender;

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