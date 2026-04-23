<?php

namespace SmartyStreets\PhpSdk\Exceptions;
require_once 'SmartyException.php';

class RequestNotModifiedException extends SmartyException {
    private ?string $responseEtag;

    public function __construct($message = "", $code = 0, ?\Throwable $previous = null, ?string $responseEtag = null) {
        parent::__construct($message, $code, $previous);
        $this->responseEtag = $responseEtag;
    }

    public function getResponseEtag(): ?string {
        return $this->responseEtag;
    }
}
