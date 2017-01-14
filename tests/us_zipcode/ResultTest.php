<?php

require_once(dirname(dirname(dirname(__FILE__))) . '/src/smartystreets/api/us_zipcode/Result.php');
use smartystreets\api\us_zipcode\Result as Result;


class ResultTest extends \PHPUnit_Framework_TestCase {
    function testIsValidReturnsTrueWhenInputIsValid() {
        $result = new Result();

        $this->assertTrue($result->isValid());
    }

    function testIsValidReturnsFalseWhenInputIsNotValid() {
        $result = new Result();
        $result->setStatus("invalid_zipcode");
        $result->setReason("invalid_reason");

        $this->assertFalse($result->isValid());
    }
}
