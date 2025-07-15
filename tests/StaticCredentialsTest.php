<?php

namespace SmartyStreets\PhpSdk\Tests;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use GuzzleHttp\Psr7\Request;

class StaticCredentialsTest extends TestCase {
    public function testStandardCredentials() {
        $request = new Request('GET', 'https://us-street.api.smarty.com');
        $request = $this->applyStaticCredentials($request, 'f83280df-s83d-f82j-d829-kd02l9tis7ek', 'S9Djk63k2Ilj67vN82Km');
        $uri = $request->getUri();
        $this->assertEquals('https://us-street.api.smarty.com?auth-id=f83280df-s83d-f82j-d829-kd02l9tis7ek&auth-token=S9Djk63k2Ilj67vN82Km', (string)$uri);
    }

    public function testUrlEncoding() {
        $request = new Request('GET', 'https://us-street.api.smarty.com');
        $request = $this->applyStaticCredentials($request, "as3\$d8+56d9", "d8j#ds'dfe2");
        $uri = $request->getUri();
        $this->assertEquals('https://us-street.api.smarty.com?auth-id=as3%24d8%2B56d9&auth-token=d8j%23ds%27dfe2', (string)$uri);
    }

    private function applyStaticCredentials(RequestInterface $request, $id, $token) {
        // Add the auth-id and auth-token as query parameters
        $uri = $request->getUri();
        $query = $uri->getQuery();
        $query = $query ? $query . '&' : '';
        $query .= 'auth-id=' . rawurlencode($id) . '&auth-token=' . rawurlencode($token);
        $uri = $uri->withQuery($query);
        return $request->withUri($uri);
    }
}
