<?php

namespace SmartyStreets\PhpSdk\Tests;

require_once(dirname(dirname(__FILE__)) . '/src/Request.php');
require_once(dirname(dirname(__FILE__)) . '/src/Response.php');
require_once(dirname(dirname(__FILE__)) . '/src/LicenseSender.php');
require_once('Mocks/MockSender.php');
use SmartyStreets\PhpSdk\Request;
use SmartyStreets\PhpSdk\Response;
use SmartyStreets\PhpSdk\LicenseSender;
use SmartyStreets\PhpSdk\Tests\Mocks\MockSender;
use PHPUnit\Framework\TestCase;

class LicenseSenderTest extends TestCase {
    public function testLicensesSetOnQuery() {
        $request = new Request();
        $licenses = ["one","two","three"];
        $inner = new MockSender(new Response(123, null));
        $sender = new LicenseSender($licenses, $inner);

        $sender->send($request);

        $this->assertEquals("one,two,three", $request->getParameters()["license"]);
    }

    public function testLicenseNotSet() {
        $request = new Request();
        $inner = new MockSender(new Response(123, null));
        $sender = new LicenseSender([], $inner);

        $sender->send($request);

        $this->assertEquals(0, count($request->getParameters()));
    }
}