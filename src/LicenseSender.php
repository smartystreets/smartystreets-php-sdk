<?php

namespace SmartyStreets\PhpSdk;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class LicenseSender implements ClientInterface {
    private $licenses,
            $inner;

    public function __construct($licenses, ClientInterface $inner) {
        $this->licenses = $licenses;
        $this->inner = $inner;
    }

    public function sendRequest(RequestInterface $request): ResponseInterface {
        if (count($this->licenses) > 0) {
            $uri = $request->getUri();
            $query = $uri->getQuery();
            $licenseParam = 'license=' . urlencode(join(',', $this->licenses));
            $query = $query ? $query . '&' . $licenseParam : $licenseParam;
            $newUri = $uri->withQuery($query);
            $request = $request->withUri($newUri);
        }
        return $this->inner->sendRequest($request);
    }
}