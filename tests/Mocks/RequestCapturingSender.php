<?php

namespace SmartyStreets\PhpSdk\Tests\Mocks;

require_once(dirname(dirname(dirname(__FILE__))) . '/src/Sender.php');
use SmartyStreets\PhpSdk\Sender;
use SmartyStreets\PhpSdk\Request;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Psr7\Response;

class RequestCapturingSender implements ClientInterface {
    private $request;

    public function __construct() { }

    public function sendRequest(RequestInterface $request): ResponseInterface {
        $this->request = $request;
        return new Response(200, [], '[]');
    }

    public function getRequest() {
        return $this->request;
    }
}