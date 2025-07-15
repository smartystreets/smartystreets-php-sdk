<?php

namespace SmartyStreets\PhpSdk\Tests\Mocks;

require_once(dirname(dirname(dirname(__FILE__))) . '/src/Sender.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/Response.php');
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class MockSender implements ClientInterface {
    private $response,
            $request;

    public function __construct(ResponseInterface $response) {
        $this->response = $response;
    }

    public function sendRequest(RequestInterface $request): ResponseInterface {
        $this->request = $request;
        return $this->response;
    }

    public function getRequest() {
        return $this->request;
    }
}