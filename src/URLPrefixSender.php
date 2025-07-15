<?php

namespace SmartyStreets\PhpSdk;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Psr7\Uri;

class URLPrefixSender implements ClientInterface {
    private $urlPrefix,
            $inner;

    public function __construct($urlPrefix, ClientInterface $inner) {
        $this->urlPrefix = $urlPrefix;
        $this->inner = $inner;
    }

    public function sendRequest(RequestInterface $request): ResponseInterface {
        // Parse the prefix and request URIs
        $prefix = $this->urlPrefix;
        $requestUri = (string)$request->getUri();
        // If the request URI is absolute, use it as is
        if (parse_url($requestUri, PHP_URL_SCHEME)) {
            $newUri = $requestUri;
        } else {
            // Combine prefix and request path
            $newUri = rtrim($prefix, '/') . '/' . ltrim($request->getUri()->getPath(), '/');
            $query = $request->getUri()->getQuery();
            if ($query) {
                $newUri .= '?' . $query;
            }
        }
        $newRequest = $request->withUri(new Uri($newUri));
        return $this->inner->sendRequest($newRequest);
    }
}