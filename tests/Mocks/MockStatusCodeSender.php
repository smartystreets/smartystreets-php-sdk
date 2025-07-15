<?php

namespace SmartyStreets\PhpSdk\Tests\Mocks;

require_once(dirname(dirname(dirname(__FILE__))) . '/src/Sender.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/Response.php');
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Psr7\Response;

class MockStatusCodeSender implements ClientInterface {
    private $statusCode;

    public function __construct($statusCode) {
        $this->statusCode = $statusCode;
    }

    public function sendRequest(RequestInterface $request): ResponseInterface {
        if ($this->statusCode == 0)
            return null;
        return new Response($this->statusCode);
    }
}