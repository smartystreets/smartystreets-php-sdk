<?php

namespace smartystreets\api;

include_once('Sender.php');
require_once('exceptions/BadCredentialsException.php');
use smartystreets\api\exceptions\BadCredentialsException;
require_once('exceptions/BadRequestException.php');
use smartystreets\api\exceptions\BadRequestException;
require_once('exceptions/InternalServerErrorException.php');
use smartystreets\api\exceptions\InternalServerErrorException;
require_once('exceptions/PaymentRequiredException.php');
use smartystreets\api\exceptions\PaymentRequiredException;
require_once('exceptions/RequestEntityTooLargeException.php');
use smartystreets\api\exceptions\RequestEntityTooLargeException;
require_once('exceptions/ServiceUnavailableException.php');
use smartystreets\api\exceptions\ServiceUnavailableException;
require_once('exceptions/TooManyRequestsException.php');
use smartystreets\api\exceptions\TooManyRequestsException;

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