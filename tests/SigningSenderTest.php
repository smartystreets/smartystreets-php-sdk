<?php

namespace SmartyStreets\PhpSdk\Tests;

require_once('Mocks/MockSender.php');
require_once(dirname(dirname(__FILE__)) . '/src/Request.php');
require_once(dirname(dirname(__FILE__)) . '/src/Response.php');
require_once(dirname(dirname(__FILE__)) . '/src/StaticCredentials.php');
require_once(dirname(dirname(__FILE__)) . '/src/SigningSender.php');
use SmartyStreets\PhpSdk\Tests\Mocks\MockSender;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Client\ClientInterface;
use SmartyStreets\PhpSdk\StaticCredentials;
use SmartyStreets\PhpSdk\SigningSender;
use PHPUnit\Framework\TestCase;

class SigningSenderTest extends TestCase {

    public function testSigningOfRequest() {
        $signer = new class {
            public function sign(RequestInterface $request): RequestInterface {
                // Add auth-id and auth-token as query params
                $uri = $request->getUri();
                $query = $uri->getQuery();
                $query .= ($query ? '&' : '') . 'auth-id=id&auth-token=secret';
                $newUri = $uri->withQuery($query);
                return $request->withUri($newUri);
            }
        };
        $mockSender = new MockSender(new \GuzzleHttp\Psr7\Response());
        $sender = new SigningSender($signer, $mockSender);
        $request = new Request('GET', 'http://localhost/');
        $sender->sendRequest($request);
        $actualRequest = $mockSender->getRequest();
        $this->assertEquals("http://localhost/?auth-id=id&auth-token=secret", (string)$actualRequest->getUri());
    }

    public function testResponseReturnedCorrectly() {
        $signer = new class {
            public function sign(RequestInterface $request): RequestInterface {
                return $request;
            }
        };
        $expectedResponse = new \GuzzleHttp\Psr7\Response(200);
        $mockSender = new MockSender($expectedResponse);
        $sender = new SigningSender($signer, $mockSender);
        $actualResponse = $sender->sendRequest(new Request('GET', 'https://example.com/'));
        $this->assertEquals($expectedResponse, $actualResponse);
    }
}
