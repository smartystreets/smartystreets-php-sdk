<?php

namespace mocks;

require_once(dirname(dirname(dirname(__FILE__))) . '/src/smartystreets/api/Sender.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/smartystreets/api/Response.php');
use smartystreets\api\Sender;
use smartystreets\api\Response;
use smartystreets\api\Request;

class RequestCapturingSender implements Sender {
    private $request;

    public function __construct() { }

    public function send(Request $request) {
        $this->request = $request;

        return new Response(200, "[]");
    }

    public function getRequest() {
        return $this->request;
    }

}