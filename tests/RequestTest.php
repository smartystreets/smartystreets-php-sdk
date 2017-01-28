<?php

require_once(dirname(dirname(__FILE__)) . '/src/smartystreets/api/Request.php');
use smartystreets\api\Request as Request;

class RequestTest extends PHPUnit_Framework_TestCase {
    const LOCAL_HOST = "http://localhost/?";

    public function testNullNameQueryStringParameterNotAdded() {
        $this->assertQueryStringParameters(null, "value", self::LOCAL_HOST);
    }

    public function testEmptyNameQueryStringParameterNotAdded() {
        $this->assertQueryStringParameters("", "value", self::LOCAL_HOST);
    }

    public function testNullValueQueryStringParameterNotAdded() {
        $this->assertQueryStringParameters("name", null, self::LOCAL_HOST);
    }

    public function testEmptyValueQueryStringParameterIsAdded() {
        $this->assertQueryStringParameters("name", "", "http://localhost/?name=");
    }

    private function assertQueryStringParameters($name, $value, $expected) {
        $request = new Request(self::LOCAL_HOST);

        $request->setParameter($name, $value);

        $this->assertEquals($expected, $request->buildUrl());
    }

    public function testMultipleQueryStringParameters() {
        $request = new Request(self::LOCAL_HOST);

        $request->setParameter("name1", "value1");
        $request->setParameter("name2", "value2");
        $request->setParameter("name3", "value3");

        $expected = "http://localhost/?name1=value1&name2=value2&name3=value3";
        $this->assertEquals($expected, $request->buildUrl());
    }

    public function testUrlEncodingOfQueryStringParameters() {
        $request = new Request(self::LOCAL_HOST);

        $request->setParameter("name&", "value");
        $request->setParameter("name1", "other !value$");

        $expected = "http://localhost/?name%26=value&name1=other+%21value%24";

        $this->assertEquals($expected, $request->buildUrl());
    }

    public function testHeadersAddedToRequest() {
        $request = new Request(self::LOCAL_HOST);

        $request->setHeader("header1", "value1");
        $request->setHeader("header2", "value2");

        $this->assertEquals("value1", $request->getHeaders()["header1"]);
        $this->assertEquals("value2", $request->getHeaders()["header2"]);
    }

    public function testPost() {
        $request = new Request(self::LOCAL_HOST);

        $request->setPayload("bytes");
        $actualPayload = $request->getPayload();

        $this->assertEquals("bytes", $actualPayload);
    }

    public function testUrlWithoutTrailingQuestionMark() {
        $request = new Request("http://localhost/");

        $request->setParameter("name1", "value1");
        $request->setParameter("name2", "value2");
        $request->setParameter("name3", "value3");

        $expected = "http://localhost/?name1=value1&name2=value2&name3=value3";
        $this->assertEquals($expected, $request->buildUrl());
    }
}
