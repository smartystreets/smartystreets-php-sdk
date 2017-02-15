<?php

namespace SmartyStreets\Tests\Mocks;

require_once(dirname(dirname(dirname(__FILE__))) . '/src/Sender.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/Response.php');
use SmartyStreets\Sender;
use SmartyStreets\Response;
use SmartyStreets\Request;

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