<?php

namespace SmartyStreets\PhpSdk\Exceptions;
require_once 'SmartyException.php';

class TooManyRequestsException extends SmartyException {
    var $retryAfterValue;

    public function __construct($message, $code = 0, $retryAfterValue = 0, ?Throwable $previous = null) {

        $this->retryAfterValue = $retryAfterValue;
        parent::__construct($message, $code, $previous);
    }

    function setRetryAfterValue($retryAfterValue){
        $this->retryAfterValue = $retryAfterValue;
    }
    function getRetryAfterValue(){
        return $this->retryAfterValue;
    }
}