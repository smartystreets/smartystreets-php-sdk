<?php

namespace SmartyStreets;

include_once('Sender.php');
require_once('Exceptions/BadCredentialsException.php');
use SmartyStreets\Exceptions\BadCredentialsException;
require_once('Exceptions/BadRequestException.php');
use SmartyStreets\Exceptions\BadRequestException;
require_once('Exceptions/InternalServerErrorException.php');
use SmartyStreets\Exceptions\InternalServerErrorException;
require_once('Exceptions/PaymentRequiredException.php');
use SmartyStreets\Exceptions\PaymentRequiredException;
require_once('Exceptions/RequestEntityTooLargeException.php');
use SmartyStreets\Exceptions\RequestEntityTooLargeException;
require_once('Exceptions/ServiceUnavailableException.php');
use SmartyStreets\Exceptions\ServiceUnavailableException;
require_once('Exceptions/TooManyRequestsException.php');
use SmartyStreets\Exceptions\TooManyRequestsException;

class StatusCodeSender implements Sender {
    private $inner;

    public function __construct(Sender $inner) {
        $this->inner = $inner;
    }

    function send(Request $request) {
        $response = $this->inner->send($request);

        switch ($response->getStatusCode()) {
            case 200:
                return $response;
            case 400:
                throw new BadRequestException("Bad Request (Malformed Payload): A GET request lacked a street field or the request body of a POST request contained malformed JSON.");
            case 401:
                throw new BadCredentialsException("Unauthorized: The credentials were provided incorrectly or did not match any existing, active credentials.");
            case 402:
                throw new PaymentRequiredException("Payment Required: There is no active subscription for the account associated with the credentials submitted with the request.");
            case 413:
                throw new RequestEntityTooLargeException("Request Entity Too Large: The request body has exceeded the maximum size.");
            case 429:
                throw new TooManyRequestsException("When using public \"website key\" authentication, we restrict the number of requests coming from a given source over too short of a time.");
            case 500:
                throw new InternalServerErrorException("Internal Server Error.");
            case 503:
                throw new ServiceUnavailableException("Service Unavailable. Try again later.");
            default:
                return null;
        }
    }
}