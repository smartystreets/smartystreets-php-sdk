<?php

namespace mocks;

require_once(dirname(dirname(dirname(__FILE__))) . '/src/smartystreets/api/Sender.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/smartystreets/api/Response.php');
use smartystreets\api\Response;
use smartystreets\api\Request;
use smartystreets\api\Sender;

class MockCrashingSender implements Sender {
    const STATUS_CODE = 200;
    private $sendCount = 0;

    public function __construct() { }

    function send(Request $request) {
        $this->sendCount++;

        if (strpos($request->getUrl(), "RetryThreeTimes") !== false) {
            if ($this->sendCount <= 3) {
                throw new \Exception("You need to retry");
            }
        }

        if (strpos($request->getUrl(), "RetryMaxTimes") !== false)
            throw new \Exception("Retrying won't help");

        return new Response(self::STATUS_CODE, "");
    }

    public function getSendCount() {
        return $this->sendCount;
    }


}