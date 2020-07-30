<?php

namespace SmartyStreets\PhpSdk;

include_once('Sender.php');
require_once('Exceptions/BadCredentialsException.php');
require_once('Exceptions/BadRequestException.php');
require_once('Exceptions/InternalServerErrorException.php');
require_once('Exceptions/PaymentRequiredException.php');
require_once('Exceptions/RequestEntityTooLargeException.php');
require_once('Exceptions/ServiceUnavailableException.php');
require_once('Exceptions/TooManyRequestsException.php');
require_once('Exceptions/UnprocessableEntityException.php');
require_once('Exceptions/GatewayTimeoutException.php');
use SmartyStreets\PhpSdk\Exceptions\BadCredentialsException;
use SmartyStreets\PhpSdk\Exceptions\BadRequestException;
use SmartyStreets\PhpSdk\Exceptions\InternalServerErrorException;
use SmartyStreets\PhpSdk\Exceptions\PaymentRequiredException;
use SmartyStreets\PhpSdk\Exceptions\RequestEntityTooLargeException;
use SmartyStreets\PhpSdk\Exceptions\ServiceUnavailableException;
use SmartyStreets\PhpSdk\Exceptions\SmartyException;
use SmartyStreets\PhpSdk\Exceptions\TooManyRequestsException;
use SmartyStreets\PhpSdk\Exceptions\UnprocessableEntityException;
use SmartyStreets\PhpSdk\Exceptions\GatewayTimeoutException;

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
                throw new BadRequestException("Bad Request (Malformed Payload): A GET request lacked a street field or the request body of a POST request contained malformed JSON." . $response->getStatusCode());
            case 401:
                throw new BadCredentialsException("Unauthorized: The credentials were provided incorrectly or did not match any existing, active credentials." . $response->getStatusCode());
            case 402:
                throw new PaymentRequiredException("Payment Required: There is no active subscription for the account associated with the credentials submitted with the request." . $response->getStatusCode());
            case 413:
                throw new RequestEntityTooLargeException("Request Entity Too Large: The request body has exceeded the maximum size." . $response->getStatusCode());
            case 422:
                throw new UnprocessableEntityException("GET request lacked required fields." . $response->getStatusCode());
            case 429:
                throw new TooManyRequestsException("When using public \"website key\" authentication, we restrict the number of requests coming from a given source over too short of a time." . $response->getStatusCode());
            case 500:
                throw new InternalServerErrorException("Internal Server Error." . $response->getStatusCode());
            case 503:
                throw new ServiceUnavailableException("Service Unavailable. Try again later." . $response->getStatusCode());
            case 504:
                throw new GatewayTimeoutException("The upstream data provider did not respond in a timely fashion and the request failed. A serious, yet rare occurrence indeed." . $response->getStatusCode());
            default:
                throw new SmartyException("Error sending request. Status code is: " . $response->getStatusCode());
        }
    }
}