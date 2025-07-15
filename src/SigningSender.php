<?php

namespace SmartyStreets\PhpSdk;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class SigningSender implements ClientInterface {
    private $signer,
            $inner;

    public function __construct($signer, ClientInterface $inner) {
        $this->signer = $signer;
        $this->inner = $inner;
    }

    public function sendRequest(RequestInterface $request): ResponseInterface {
        // Assume $this->signer->sign returns a new PSR-7 request
        $signedRequest = $this->signer->sign($request);
        return $this->inner->sendRequest($signedRequest);
    }
}