<?php

namespace SmartyStreets\PhpSdk\Tests;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use GuzzleHttp\Psr7\Request;

class SharedCredentialsTest extends TestCase {
    public function testSignedRequest() {
        $request = new Request('GET', 'https://us-street.api.smarty.com');
        $request = $this->applySharedCredentials($request, '3516378604772256', 'example.com');
        $uri = $request->getUri();
        $this->assertEquals('https://us-street.api.smarty.com?key=3516378604772256', (string)$uri);
    }

    public function testReferringHeader() {
        $request = new Request('GET', 'https://us-street.api.smarty.com');
        $request = $this->applySharedCredentials($request, '3516378604772256', 'example.com');
        $this->assertEquals('referer:https://example.com', $request->getHeaderLine('Referer'));
    }

    private function applySharedCredentials(RequestInterface $request, $key, $hostname) {
        // Add the key as a query parameter
        $uri = $request->getUri();
        $query = $uri->getQuery();
        $query = $query ? $query . '&' : '';
        $query .= 'key=' . rawurlencode($key);
        $uri = $uri->withQuery($query);
        $request = $request->withUri($uri);
        // Add the Referer header
        $request = $request->withHeader('Referer', 'referer:' . 'https://' . $hostname);
        return $request;
    }
}
