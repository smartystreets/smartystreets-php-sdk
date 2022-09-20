<?php

namespace SmartyStreets\PhpSdk\Exceptions;
require_once 'SmartyException.php';

class TooManyRequestsException extends SmartyException {
    var $header;
    function setHeader($header){
        $this->header = $header;
    }
    function getHeader(){
        return $this->header;
    }
}