<?php

namespace SmartyStreets\PhpSdk\Tests;

require_once(dirname(dirname(__FILE__)) . '/src/Request.php');
use SmartyStreets\PhpSdk\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase {
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
        $request = new Request();
        $request->setUrlPrefix(self::LOCAL_HOST);

        $request->setParameter($name, $value);

        $this->assertEquals($expected, $request->getUrl());
    }

    public function testMultipleQueryStringParameters() {
        $request = new Request();
        $request->setUrlPrefix(self::LOCAL_HOST);

        $request->setParameter("name1", "value1");
        $request->setParameter("name2", "value2");
        $request->setParameter("name3", "value3");

        $expected = "http://localhost/?name1=value1&name2=value2&name3=value3";
        $this->assertEquals($expected, $request->getUrl());
    }

    public function testUrlEncodingOfQueryStringParameters() {
        $request = new Request();
        $request->setUrlPrefix(self::LOCAL_HOST);

        $request->setParameter("name&", "value");
        $request->setParameter("name1", "other !value$");

        $expected = "http://localhost/?name%26=value&name1=other+%21value%24";

        $this->assertEquals($expected, $request->getUrl());
    }

    public function testUrlEncodingOfUnicodeCharacters() {
    	$request = new Request();
    	        $request->setUrlPrefix(self::LOCAL_HOST);

        $request->setParameter("needs_encoding", "&foo=bar");
        $request->setParameter("unicode", "Sjömadsvägen");

        $expected = "http://localhost/?needs_encoding=%26foo%3Dbar&unicode=Sj%C3%B6madsv%C3%A4gen";

        $this->assertEquals($expected, $request->getUrl());
    }

    public function testHeadersAddedToRequest() {
        $request = new Request();
        $request->setUrlPrefix(self::LOCAL_HOST);

        $request->setHeader("header1", "value1");
        $request->setHeader("header2", "value2");

        $this->assertEquals("value1", $request->getHeaders()["header1"]);
        $this->assertEquals("value2", $request->getHeaders()["header2"]);
    }

    public function testPost() {
        $request = new Request();
        $request->setUrlPrefix(self::LOCAL_HOST);

        $request->setPayload("bytes");
        $actualPayload = $request->getPayload();

        $this->assertEquals("bytes", $actualPayload);
    }

    public function testUrlWithoutTrailingQuestionMark() {
        $request = new Request();
        $request->setUrlPrefix("http://localhost/");

        $request->setParameter("name1", "value1");
        $request->setParameter("name2", "value2");
        $request->setParameter("name3", "value3");

        $expected = "http://localhost/?name1=value1&name2=value2&name3=value3";
        $this->assertEquals($expected, $request->getUrl());
    }

    public function testBooleanValuesAndOnesAndZerosAreAppendedCorrectlyToUrl() {
        $request = new Request();
        $request->setUrlPrefix("http://localhost/");

        $request->setParameter("key1", "0");
        $request->setParameter("key2", "1");
        $request->setParameter("key3", true);
        $request->setParameter("key4", false);

        $expected = "http://localhost/?key1=0&key2=1&key3=true&key4=false";
        $this->assertEquals($expected, $request->getUrl());
    }
}
