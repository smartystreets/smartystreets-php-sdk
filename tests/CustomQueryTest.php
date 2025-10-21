<?php

namespace SmartyStreets\PhpSdk\Tests;

require_once(dirname(dirname(__FILE__)) . '/src/Request.php');
require_once(dirname(dirname(__FILE__)) . '/src/Response.php');
require_once(dirname(dirname(__FILE__)) . '/src/NativeSender.php');
require_once(dirname(dirname(__FILE__)) . '/src/Proxy.php');
require_once(dirname(dirname(__FILE__)) . '/src/Exceptions/SmartyException.php');
require_once('Mocks/MockSender.php');
require_once(dirname(dirname(__FILE__)) . '/src/CustomQuerySender.php');

use SmartyStreets\PhpSdk\Proxy;
use SmartyStreets\PhpSdk\Request;
use SmartyStreets\PhpSdk\Response;
use SmartyStreets\PhpSdk\NativeSender;
use SmartyStreets\PhpSdk\Tests\Mocks\MockSender;
use SmartyStreets\PhpSdk\Exceptions\SmartyException;
use PHPUnit\Framework\TestCase;
use SmartyStreets\PhpSdk\CustomQuerySender;

class CustomQueryTest extends TestCase {
    public function testNativeSetOnQuery() {
        $request = new Request();
        $sender = new NativeSender(10000, null, false, null, ["Header" => "Custom"]);
        
        $queries = [
            "test" => "this",
            "custom" => "exists",
        ];
        $querySender = new CustomQuerySender($queries, $sender);
        try {
        $querySender->send($request);
        } catch (SmartyException $ex) {
        }

        $this->assertEquals("this", $request->getParameters()["test"]);
        $this->assertEquals("exists", $request->getParameters()["custom"]);
    }
}