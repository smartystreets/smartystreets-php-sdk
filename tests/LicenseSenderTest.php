<?php

namespace SmartyStreets\PhpSdk\Tests;

require_once(dirname(dirname(__FILE__)) . '/src/Request.php');
require_once(dirname(dirname(__FILE__)) . '/src/Response.php');
require_once(dirname(dirname(__FILE__)) . '/src/LicenseSender.php');
require_once('Mocks/MockSender.php');
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;
use SmartyStreets\PhpSdk\LicenseSender;
use SmartyStreets\PhpSdk\Tests\Mocks\MockSender;
use PHPUnit\Framework\TestCase;

class LicenseSenderTest extends TestCase {
    public function testLicensesSetOnQuery() {
        $request = new Request('GET', 'https://example.com/');
        $licenses = ["one","two","three"];
        $inner = new MockSender(new \GuzzleHttp\Psr7\Response(123));
        $sender = new LicenseSender($licenses, $inner);
        $sender->sendRequest($request);
        $sentRequest = $inner->getRequest();
        $uri = $sentRequest->getUri();
        $this->assertStringContainsString("license=one%2Ctwo%2Cthree", (string)$uri);
    }

    public function testLicenseNotSet() {
        $request = new Request('GET', 'https://example.com/');
        $inner = new MockSender(new \GuzzleHttp\Psr7\Response(123));
        $sender = new LicenseSender([], $inner);
        $sender->sendRequest($request);
        $sentRequest = $inner->getRequest();
        $uri = $sentRequest->getUri();
        $this->assertStringNotContainsString("license=", (string)$uri);
    }
}