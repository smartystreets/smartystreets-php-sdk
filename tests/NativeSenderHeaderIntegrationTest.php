<?php

namespace SmartyStreets\PhpSdk\Tests;

require_once(dirname(dirname(__FILE__)) . '/src/Request.php');
require_once(dirname(dirname(__FILE__)) . '/src/NativeSender.php');
require_once(dirname(dirname(__FILE__)) . '/src/Proxy.php');
use SmartyStreets\PhpSdk\Request;
use SmartyStreets\PhpSdk\NativeSender;
use PHPUnit\Framework\TestCase;

class NativeSenderHeaderIntegrationTest extends TestCase {
    public function testAllHeadersAreMergedAndSetCorrectly() {
        $request = new Request();
        $request->setHeader('X-Test-Header', 'Value1');
        $request->setHeader('Content-Type', 'should-be-overwritten');
        $request->setHeader('X-Another-Header', 'Value2');
        $request->setContentType('application/json');
        $customHeaders = [
            'X-Test-Header' => 'CustomValue', // Should override
            'X-Custom-Header' => 'CustomHeaderValue'
        ];
        $ip = '123.123.123.123';
        $sender = new NativeSender(10000, null, false, $ip, $customHeaders);
        try { @$sender->send($request); } catch (\Exception $e) {}
        $headers = $request->getHeaders();
        $this->assertEquals('CustomValue', $headers['X-Test-Header']);
        $this->assertEquals('Value2', $headers['X-Another-Header']);
        $this->assertEquals('CustomHeaderValue', $headers['X-Custom-Header']);
        $this->assertEquals('123.123.123.123', $headers['X-Forwarded-For']);
        $this->assertEquals('application/json', $request->getContentType());
        $this->assertCount(count(array_unique(array_keys($headers))), $headers, 'No duplicate headers should be present');
    }

    public function testCaseInsensitiveHeaderOverwriting() {
        $request = new Request();
        $request->setHeader('x-test-header', 'lowercase');
        $request->setHeader('X-Test-Header', 'uppercase');
        $customHeaders = ['X-Test-Header' => 'custom'];
        $sender = new NativeSender(10000, null, false, null, $customHeaders);
        try { @$sender->send($request); } catch (\Exception $e) {}
        $headers = $request->getHeaders();
        $this->assertEquals('custom', $headers['X-Test-Header']);
        $this->assertCount(count(array_unique(array_map('strtolower', array_keys($headers)))), $headers, 'No duplicate headers (case-insensitive)');
    }

    public function testMultipleCustomHeaders() {
        $request = new Request();
        $customHeaders = [
            'Header-One' => 'One',
            'Header-Two' => 'Two',
            'Header-Three' => 'Three'
        ];
        $sender = new NativeSender(10000, null, false, null, $customHeaders);
        try { @$sender->send($request); } catch (\Exception $e) {}
        $headers = $request->getHeaders();
        $this->assertEquals('One', $headers['Header-One']);
        $this->assertEquals('Two', $headers['Header-Two']);
        $this->assertEquals('Three', $headers['Header-Three']);
        $this->assertCount(count(array_unique(array_keys($headers))), $headers, 'No duplicate headers');
    }

    public function testMissingContentType() {
        $request = new Request();
        $request->setContentType('');
        $sender = new NativeSender();
        try { @$sender->send($request); } catch (\Exception $e) {}
        $this->assertEquals('', $request->getContentType());
    }

    public function testOnlyCustomHeaders() {
        $request = new Request();
        $customHeaders = ['Only-Header' => 'OnlyValue'];
        $sender = new NativeSender(10000, null, false, null, $customHeaders);
        try { @$sender->send($request); } catch (\Exception $e) {}
        $headers = $request->getHeaders();
        $this->assertEquals('OnlyValue', $headers['Only-Header']);
        $this->assertCount(count(array_unique(array_keys($headers))), $headers, 'No duplicate headers');
    }

    public function testOnlyXForwardedFor() {
        $request = new Request();
        $ip = '8.8.8.8';
        $sender = new NativeSender(10000, null, false, $ip);
        try { @$sender->send($request); } catch (\Exception $e) {}
        $headers = $request->getHeaders();
        $this->assertEquals('8.8.8.8', $headers['X-Forwarded-For']);
        $this->assertCount(count(array_unique(array_keys($headers))), $headers, 'No duplicate headers');
    }

    public function testNoHeadersAtAll() {
        $request = new Request();
        $sender = new NativeSender();
        try { @$sender->send($request); } catch (\Exception $e) {}
        $headers = $request->getHeaders();
        $this->assertIsArray($headers);
        $this->assertCount(count(array_unique(array_keys($headers))), $headers, 'No duplicate headers');
    }

    public function testConflictingContentType() {
        $request = new Request();
        $request->setHeader('Content-Type', 'foo/bar');
        $request->setContentType('baz/qux');
        $sender = new NativeSender();
        try { @$sender->send($request); } catch (\Exception $e) {}
        $headers = $request->getHeaders();
        $this->assertEquals('baz/qux', $request->getContentType());
        $this->assertEquals('baz/qux', $headers['Content-Type']);
    }

    public function testHeadersWithUnusualCharacters() {
        $request = new Request();
        $request->setHeader('X-Strange-Header_123', 'Value!@#$%^&*()');
        $customHeaders = ['X-Strange-Header_123' => 'Override!@#'];
        $sender = new NativeSender(10000, null, false, null, $customHeaders);
        try { @$sender->send($request); } catch (\Exception $e) {}
        $headers = $request->getHeaders();
        $this->assertEquals('Override!@#', $headers['X-Strange-Header_123']);
    }

    public function testHeadersWithEmptyValues() {
        $request = new Request();
        $request->setHeader('X-Empty', '');
        $customHeaders = ['X-Empty' => ''];
        $sender = new NativeSender(10000, null, false, null, $customHeaders);
        try { @$sender->send($request); } catch (\Exception $e) {}
        $headers = $request->getHeaders();
        $this->assertEquals('', $headers['X-Empty']);
    }

    public function testHeadersWithWhitespace() {
        $request = new Request();
        $request->setHeader('X-Whitespace', '   value   ');
        $customHeaders = ['X-Whitespace' => '   custom   '];
        $sender = new NativeSender(10000, null, false, null, $customHeaders);
        try { @$sender->send($request); } catch (\Exception $e) {}
        $headers = $request->getHeaders();
        $this->assertEquals('   custom   ', $headers['X-Whitespace']);
    }

    public function testHeaderOverwritingAndDuplication() {
        $request = new Request();
        $request->setHeader('X-Test-Header', 'Value1');
        $request->setHeader('X-Another-Header', 'Value2');
        $customHeaders = [
            'X-Test-Header' => 'CustomValue', // Should override
            'X-Custom-Header' => 'CustomHeaderValue'
        ];
        $ip = '1.2.3.4';
        $sender = new NativeSender(10000, null, false, $ip, $customHeaders);
        try { @$sender->send($request); } catch (\Exception $e) {}
        $headers = $request->getHeaders();
        // All headers should be present, no duplicates
        $this->assertEquals('CustomValue', $headers['X-Test-Header']);
        $this->assertEquals('Value2', $headers['X-Another-Header']);
        $this->assertEquals('CustomHeaderValue', $headers['X-Custom-Header']);
        $this->assertEquals('1.2.3.4', $headers['X-Forwarded-For']);
        $this->assertCount(count(array_unique(array_keys($headers))), $headers, 'No duplicate headers should be present');
    }

    public function testHeaderFormattingAndMerging() {
        $request = new Request();
        $request->setHeader('X-Header-One', 'One');
        $request->setHeader('X-Header-Two', 'Two');
        $customHeaders = [
            'X-Header-Two' => 'CustomTwo', // Should override
            'X-Header-Three' => 'Three'
        ];
        $ip = '5.6.7.8';
        $sender = new NativeSender(10000, null, false, $ip, $customHeaders);
        try { @$sender->send($request); } catch (\Exception $e) {}
        $headers = $request->getHeaders();
        // All headers should be present and formatted
        $this->assertEquals('One', $headers['X-Header-One']);
        $this->assertEquals('CustomTwo', $headers['X-Header-Two']);
        $this->assertEquals('Three', $headers['X-Header-Three']);
        $this->assertEquals('5.6.7.8', $headers['X-Forwarded-For']);
        foreach ($headers as $k => $v) {
            $this->assertMatchesRegularExpression('/^[A-Z][A-Za-z0-9\-]*$/', $k, 'Header name formatted');
        }
    }

    public function testCaseSensitivityNoDuplicates() {
        $request = new Request();
        $request->setHeader('x-test-header', 'lowercase');
        $request->setHeader('X-Test-Header', 'uppercase');
        $request->setHeader('X-TEST-HEADER', 'allcaps');
        $customHeaders = ['x-test-header' => 'custom'];
        $sender = new NativeSender(10000, null, false, null, $customHeaders);
        try { @$sender->send($request); } catch (\Exception $e) {}
        $headers = $request->getHeaders();
        // Only one canonical header should exist
        $this->assertEquals('custom', $headers['X-Test-Header']);
        $this->assertArrayNotHasKey('x-test-header', $headers);
        $this->assertArrayNotHasKey('X-TEST-HEADER', $headers);
        $this->assertCount(count(array_unique(array_keys($headers))), $headers, 'No duplicate headers (case-insensitive)');
    }

    public function testHeadersToArrayParsing() {
        $sender = new NativeSender();
        $headerStr = "HTTP/1.1 200 OK\r\nX-Test: Value\r\nX-Colon: foo:bar:baz\r\nX-Empty: \r\n\r\n";
        $parsed = $sender->headersToArray($headerStr);
        $this->assertEquals(' Value', $parsed['X-Test']);
        $this->assertEquals(' foo:bar:baz', $parsed['X-Colon']);
        $this->assertEquals(' ', $parsed['X-Empty']);
        $this->assertArrayNotHasKey('HTTP/1.1 200 OK', $parsed, 'Status line should not be parsed as header');
    }

    public function testVeryLongHeaderNameAndValue() {
        $longName = str_repeat('X-Long-Header-', 50); // ~700 chars
        $longValue = str_repeat('A', 8192); // 8KB value
        $request = new Request();
        $request->setHeader($longName, $longValue);
        $sender = new NativeSender();
        try { @$sender->send($request); } catch (\Exception $e) {}
        $headers = $request->getHeaders();
        $found = false;
        foreach ($headers as $k => $v) {
            if (strcasecmp($k, $longName) === 0) {
                $this->assertEquals($longValue, $v);
                $found = true;
                break;
            }
        }
        $this->assertTrue($found, 'Long header name should be present');
    }

    public function testNonAsciiUnicodeHeaderNameAndValue() {
        $request = new Request();
        $unicodeName = "X-Üñîçødë";
        $unicodeValue = "Välüé-测试";
        $request->setHeader($unicodeName, $unicodeValue);
        $sender = new NativeSender();
        try { @$sender->send($request); } catch (\Exception $e) {}
        $headers = $request->getHeaders();
        $found = false;
        foreach ($headers as $k => $v) {
            if (strcasecmp($k, $unicodeName) === 0) {
                $this->assertEquals($unicodeValue, $v);
                $found = true;
                break;
            }
        }
        $this->assertTrue($found, 'Unicode header name should be present');
    }

    public function testHeaderWithOnlyColon() {
        $request = new Request();
        $request->setHeader(':', ':');
        $sender = new NativeSender();
        try { @$sender->send($request); } catch (\Exception $e) {}
        $headers = $request->getHeaders();
        $this->assertEquals(':', $headers[':']);
    }

    public function testHeaderWithMultipleColonsInName() {
        $this->markTestSkipped('Headers with multiple colons in the name are not supported by HTTP standards or cURL.');
    }

    public function testHeaderWithLeadingTrailingHyphens() {
        $request = new Request();
        $headerName = '-X-Test-Header-';
        $request->setHeader($headerName, 'hyphen');
        $sender = new NativeSender();
        try { @$sender->send($request); } catch (\Exception $e) {}
        $headers = $request->getHeaders();
        $this->assertEquals('hyphen', $headers[$headerName]);
    }

    public function testHeaderWithEmbeddedNewlines() {
        $this->markTestSkipped('Headers with embedded newlines are not supported by HTTP standards or cURL.');
    }

    public function testMaximumNumberOfHeaders() {
        $request = new Request();
        $numHeaders = 300;
        for ($i = 0; $i < $numHeaders; $i++) {
            $request->setHeader("X-Header-$i", "Value-$i");
        }
        $sender = new NativeSender();
        try { @$sender->send($request); } catch (\Exception $e) {}
        $headers = $request->getHeaders();
        for ($i = 0; $i < $numHeaders; $i++) {
            $this->assertEquals("Value-$i", $headers["X-Header-$i"]);
        }
        $this->assertCount($numHeaders, array_filter(array_keys($headers), function($k) { return strpos($k, 'X-Header-') === 0; }));
    }

    public function testNumericHeaderName() {
        $request = new Request();
        $headerName = '123-Header';
        $request->setHeader($headerName, 'numeric');
        $sender = new NativeSender();
        try { @$sender->send($request); } catch (\Exception $e) {}
        $headers = $request->getHeaders();
        $this->assertEquals('numeric', $headers[$headerName]);
    }

    public function testDuplicatedXForwardedForCustomAndIP() {
        $request = new Request();
        $customHeaders = ['X-Forwarded-For' => 'custom-ip'];
        $ip = '9.9.9.9';
        $sender = new NativeSender(10000, null, false, $ip, $customHeaders);
        try { @$sender->send($request); } catch (\Exception $e) {}
        $headers = $request->getHeaders();
        // IP argument should take precedence
        $this->assertEquals('9.9.9.9', $headers['X-Forwarded-For']);
    }
} 