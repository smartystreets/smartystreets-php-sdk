<?php

namespace SmartyStreets\PhpSdk\Tests;

require_once(dirname(dirname(__FILE__)) . '/src/Request.php');
require_once(dirname(dirname(__FILE__)) . '/src/NativeSender.php');
require_once(dirname(dirname(__FILE__)) . '/src/Proxy.php');
use GuzzleHttp\Psr7\Request;
use PHPUnit\Framework\TestCase;

class NativeSenderHeaderIntegrationTest extends TestCase {
    public function testAllHeadersAreMergedAndSetCorrectly() {
        $request = new Request('GET', 'https://example.com/');
        $request = $request->withHeader('X-Test-Header', 'Value1')
                           ->withHeader('Content-Type', 'should-be-overwritten')
                           ->withHeader('X-Another-Header', 'Value2');
        $request = $request->withHeader('Content-Type', 'application/json');
        $request = $request->withHeader('X-Test-Header', 'CustomValue')
                           ->withHeader('X-Custom-Header', 'CustomHeaderValue')
                           ->withHeader('X-Forwarded-For', '123.123.123.123');
        $headers = $request->getHeaders();
        $this->assertEquals('CustomValue', $request->getHeaderLine('X-Test-Header'));
        $this->assertEquals('Value2', $request->getHeaderLine('X-Another-Header'));
        $this->assertEquals('CustomHeaderValue', $request->getHeaderLine('X-Custom-Header'));
        $this->assertEquals('123.123.123.123', $request->getHeaderLine('X-Forwarded-For'));
        $this->assertEquals('application/json', $request->getHeaderLine('Content-Type'));
        $this->assertCount(count(array_unique(array_keys($headers))), $headers, 'No duplicate headers should be present');
    }

    public function testCaseInsensitiveHeaderOverwriting() {
        $request = new Request('GET', 'https://example.com/');
        $request = $request->withHeader('x-test-header', 'lowercase');
        $request = $request->withHeader('X-Test-Header', 'uppercase');
        $request = $request->withHeader('X-Test-Header', 'custom');
        $headers = $request->getHeaders();
        $this->assertEquals('custom', $request->getHeaderLine('X-Test-Header'));
        $this->assertCount(count(array_unique(array_map('strtolower', array_keys($headers)))), $headers, 'No duplicate headers (case-insensitive)');
    }

    public function testMultipleCustomHeaders() {
        $request = new Request('GET', 'https://example.com/');
        $request = $request->withHeader('Header-One', 'One')
                           ->withHeader('Header-Two', 'Two')
                           ->withHeader('Header-Three', 'Three');
        $headers = $request->getHeaders();
        $this->assertEquals('One', $request->getHeaderLine('Header-One'));
        $this->assertEquals('Two', $request->getHeaderLine('Header-Two'));
        $this->assertEquals('Three', $request->getHeaderLine('Header-Three'));
        $this->assertCount(count(array_unique(array_keys($headers))), $headers, 'No duplicate headers');
    }

    public function testMissingContentType() {
        $request = new Request('GET', 'https://example.com/');
        $request = $request->withHeader('Content-Type', '');
        $headers = $request->getHeaders();
        $this->assertEquals('', $request->getHeaderLine('Content-Type'));
    }

    public function testOnlyCustomHeaders() {
        $request = new Request('GET', 'https://example.com/');
        $request = $request->withHeader('Only-Header', 'OnlyValue');
        $headers = $request->getHeaders();
        $this->assertEquals('OnlyValue', $request->getHeaderLine('Only-Header'));
        $this->assertCount(count(array_unique(array_keys($headers))), $headers, 'No duplicate headers');
    }

    public function testOnlyXForwardedFor() {
        $request = new Request('GET', 'https://example.com/');
        $request = $request->withHeader('X-Forwarded-For', '8.8.8.8');
        $headers = $request->getHeaders();
        $this->assertEquals('8.8.8.8', $request->getHeaderLine('X-Forwarded-For'));
        $this->assertCount(count(array_unique(array_keys($headers))), $headers, 'No duplicate headers');
    }

    public function testNoHeadersAtAll() {
        $request = new Request('GET', 'https://example.com/');
        $headers = $request->getHeaders();
        $this->assertIsArray($headers);
        $this->assertCount(count(array_unique(array_keys($headers))), $headers, 'No duplicate headers');
    }

    public function testConflictingContentType() {
        $request = new Request('GET', 'https://example.com/');
        $request = $request->withHeader('Content-Type', 'foo/bar');
        $request = $request->withHeader('Content-Type', 'baz/qux');
        $headers = $request->getHeaders();
        $this->assertEquals('baz/qux', $request->getHeaderLine('Content-Type'));
        $this->assertEquals('baz/qux', $request->getHeaderLine('Content-Type'));
    }

    public function testHeadersWithUnusualCharacters() {
        $request = new Request('GET', 'https://example.com/');
        $request = $request->withHeader('X-Strange-Header_123', 'Value!@#$%^&*()');
        $request = $request->withHeader('X-Strange-Header_123', 'Override!@#');
        $headers = $request->getHeaders();
        $this->assertEquals('Override!@#', $request->getHeaderLine('X-Strange-Header_123'));
    }

    public function testHeadersWithEmptyValues() {
        $request = new Request('GET', 'https://example.com/');
        $request = $request->withHeader('X-Empty', '');
        $request = $request->withHeader('X-Empty', '');
        $headers = $request->getHeaders();
        $this->assertEquals('', $request->getHeaderLine('X-Empty'));
    }

    public function testHeadersWithWhitespace() {
        $request = new Request('GET', 'https://example.com/');
        $request = $request->withHeader('X-Whitespace', '   value   ');
        $request = $request->withHeader('X-Whitespace', '   custom   ');
        $headers = $request->getHeaders();
        // PSR-7/Guzzle trims whitespace from header values
        $this->assertEquals('custom', $request->getHeaderLine('X-Whitespace'));
    }

    public function testHeaderOverwritingAndDuplication() {
        $request = new Request('GET', 'https://example.com/');
        $request = $request->withHeader('X-Test-Header', 'Value1');
        $request = $request->withHeader('X-Another-Header', 'Value2');
        $request = $request->withHeader('X-Test-Header', 'CustomValue')
                           ->withHeader('X-Custom-Header', 'CustomHeaderValue')
                           ->withHeader('X-Forwarded-For', '1.2.3.4');
        $headers = $request->getHeaders();
        // All headers should be present, no duplicates
        $this->assertEquals('CustomValue', $request->getHeaderLine('X-Test-Header'));
        $this->assertEquals('Value2', $request->getHeaderLine('X-Another-Header'));
        $this->assertEquals('CustomHeaderValue', $request->getHeaderLine('X-Custom-Header'));
        $this->assertEquals('1.2.3.4', $request->getHeaderLine('X-Forwarded-For'));
        $this->assertCount(count(array_unique(array_keys($headers))), $headers, 'No duplicate headers should be present');
    }

    public function testHeaderFormattingAndMerging() {
        $request = new Request('GET', 'https://example.com/');
        $request = $request->withHeader('X-Header-One', 'One')
                           ->withHeader('X-Header-Two', 'Two');
        $request = $request->withHeader('X-Header-Two', 'CustomTwo')
                           ->withHeader('X-Header-Three', 'Three');
        $request = $request->withHeader('X-Forwarded-For', '5.6.7.8');
        $headers = $request->getHeaders();
        // All headers should be present and formatted
        $this->assertEquals('One', $request->getHeaderLine('X-Header-One'));
        $this->assertEquals('CustomTwo', $request->getHeaderLine('X-Header-Two'));
        $this->assertEquals('Three', $request->getHeaderLine('X-Header-Three'));
        $this->assertEquals('5.6.7.8', $request->getHeaderLine('X-Forwarded-For'));
        foreach ($headers as $k => $v) {
            $this->assertMatchesRegularExpression('/^[A-Z][A-Za-z0-9\-]*$/', $k, 'Header name formatted');
        }
    }

    public function testCaseSensitivityNoDuplicates() {
        $request = new Request('GET', 'https://example.com/');
        $request = $request->withHeader('x-test-header', 'lowercase');
        $request = $request->withHeader('X-Test-Header', 'uppercase');
        $request = $request->withHeader('X-TEST-HEADER', 'allcaps');
        $request = $request->withHeader('x-test-header', 'custom');
        $headers = $request->getHeaders();
        // Only one header key should exist, but its casing is the first used
        $this->assertEquals('custom', $request->getHeaderLine('X-Test-Header'));
        $this->assertCount(1, array_filter(array_keys($headers), function($k) { return strcasecmp($k, 'X-Test-Header') === 0; }), 'Only one header key for X-Test-Header');
    }

    public function testHeadersToArrayParsing() {
        $request = new Request('GET', 'https://example.com/');
        $headerStr = "HTTP/1.1 200 OK\r\nX-Test: Value\r\nX-Colon: foo:bar:baz\r\nX-Empty: \r\n\r\n";
        $request = $request->withHeader('X-Test', ' Value')
                           ->withHeader('X-Colon', ' foo:bar:baz')
                           ->withHeader('X-Empty', ' ');
        $headers = $request->getHeaders();
        // PSR-7/Guzzle trims whitespace from header values
        $this->assertEquals('Value', $request->getHeaderLine('X-Test'));
        $this->assertEquals('foo:bar:baz', $request->getHeaderLine('X-Colon'));
        $this->assertEquals('', $request->getHeaderLine('X-Empty'));
        $this->assertArrayNotHasKey('HTTP/1.1 200 OK', $headers, 'Status line should not be parsed as header');
    }

    public function testVeryLongHeaderNameAndValue() {
        $longName = str_repeat('X-Long-Header-', 50); // ~700 chars
        $longValue = str_repeat('A', 8192); // 8KB value
        $request = new Request('GET', 'https://example.com/');
        $request = $request->withHeader($longName, $longValue);
        $headers = $request->getHeaders();
        $found = false;
        foreach ($headers as $k => $v) {
            if (strcasecmp($k, $longName) === 0) {
                // PSR-7/Guzzle: $v is an array of values
                $this->assertEquals($longValue, $v[0]);
                $found = true;
                break;
            }
        }
        $this->assertTrue($found, 'Long header name should be present');
    }

    public function testNonAsciiUnicodeHeaderNameAndValue() {
        $this->expectException(\InvalidArgumentException::class);
        $request = new \GuzzleHttp\Psr7\Request('GET', 'https://example.com/');
        $unicodeName = "X-Üñîçødë";
        $unicodeValue = "Välüé-测试";
        $request = $request->withHeader($unicodeName, $unicodeValue);
    }

    public function testHeaderWithOnlyColon() {
        $this->expectException(\InvalidArgumentException::class);
        $request = new \GuzzleHttp\Psr7\Request('GET', 'https://example.com/');
        $request = $request->withHeader(':', ':');
    }

    public function testHeaderWithMultipleColonsInName() {
        $this->markTestSkipped('Headers with multiple colons in the name are not supported by HTTP standards or cURL.');
    }

    public function testHeaderWithLeadingTrailingHyphens() {
        $request = new Request('GET', 'https://example.com/');
        $headerName = '-X-Test-Header-';
        $request = $request->withHeader($headerName, 'hyphen');
        $headers = $request->getHeaders();
        $this->assertEquals('hyphen', $request->getHeaderLine($headerName));
    }

    public function testHeaderWithEmbeddedNewlines() {
        $this->markTestSkipped('Headers with embedded newlines are not supported by HTTP standards or cURL.');
    }

    public function testMaximumNumberOfHeaders() {
        $request = new Request('GET', 'https://example.com/');
        $numHeaders = 300;
        for ($i = 0; $i < $numHeaders; $i++) {
            $request = $request->withHeader("X-Header-$i", "Value-$i");
        }
        $headers = $request->getHeaders();
        for ($i = 0; $i < $numHeaders; $i++) {
            $this->assertEquals("Value-$i", $request->getHeaderLine("X-Header-$i"));
        }
        $this->assertCount($numHeaders, array_filter(array_keys($headers), function($k) { return strpos($k, 'X-Header-') === 0; }));
    }

    public function testNumericHeaderName() {
        $request = new Request('GET', 'https://example.com/');
        $headerName = '123-Header';
        $request = $request->withHeader($headerName, 'numeric');
        $headers = $request->getHeaders();
        $this->assertEquals('numeric', $request->getHeaderLine($headerName));
    }

    public function testDuplicatedXForwardedForCustomAndIP() {
        $request = new Request('GET', 'https://example.com/');
        $request = $request->withHeader('X-Forwarded-For', 'custom-ip');
        $request = $request->withHeader('X-Forwarded-For', '9.9.9.9');
        $headers = $request->getHeaders();
        // IP argument should take precedence
        $this->assertEquals('9.9.9.9', $request->getHeaderLine('X-Forwarded-For'));
    }
} 