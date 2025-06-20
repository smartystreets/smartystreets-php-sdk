<?php

namespace SmartyStreets\PhpSdk;

include_once('Sender.php');
require_once(__DIR__ . '/Exceptions/BadCredentialsException.php');
require_once(__DIR__ . '/Exceptions/BadRequestException.php');
require_once(__DIR__ . '/Exceptions/InternalServerErrorException.php');
require_once(__DIR__ . '/Exceptions/PaymentRequiredException.php');
require_once(__DIR__ . '/Exceptions/RequestEntityTooLargeException.php');
require_once(__DIR__ . '/Exceptions/ServiceUnavailableException.php');
require_once(__DIR__ . '/Exceptions/TooManyRequestsException.php');
require_once(__DIR__ . '/Exceptions/UnprocessableEntityException.php');
require_once(__DIR__ . '/Exceptions/GatewayTimeoutException.php');

use SmartyStreets\PhpSdk\Exceptions\BadCredentialsException;
use SmartyStreets\PhpSdk\Exceptions\BadGatewayException;
use SmartyStreets\PhpSdk\Exceptions\BadRequestException;
use SmartyStreets\PhpSdk\Exceptions\InternalServerErrorException;
use SmartyStreets\PhpSdk\Exceptions\PaymentRequiredException;
use SmartyStreets\PhpSdk\Exceptions\RequestEntityTooLargeException;
use SmartyStreets\PhpSdk\Exceptions\RequestTimeoutException;
use SmartyStreets\PhpSdk\Exceptions\ServiceUnavailableException;
use SmartyStreets\PhpSdk\Exceptions\SmartyException;
use SmartyStreets\PhpSdk\Exceptions\TooManyRequestsException;
use SmartyStreets\PhpSdk\Exceptions\UnprocessableEntityException;
use SmartyStreets\PhpSdk\Exceptions\GatewayTimeoutException;

class StatusCodeSender implements Sender
{
    private $inner;

    public function __construct(Sender $inner)
    {
        $this->inner = $inner;
    }

    function send(Request $request)
    {
        $response = $this->inner->send($request);

        switch ($response->getStatusCode()) {
            case 200:
                return $response;
            case 400:
                throw new BadRequestException("Bad Request (Malformed Payload): A GET request lacked a street field or the request body of a POST request contained malformed JSON.", $response->getStatusCode());
            case 401:
                throw new BadCredentialsException("Unauthorized: The credentials were provided incorrectly or did not match any existing, active credentials.", $response->getStatusCode());
            case 402:
                throw new PaymentRequiredException("Payment Required: There is no active subscription for the account associated with the credentials submitted with the request.", $response->getStatusCode());
            case 408:
                throw new RequestTimeoutException("Request timeout error.", $response->getStatusCode());
            case 413:
                throw new RequestEntityTooLargeException("Request Entity Too Large: The request body has exceeded the maximum size.", $response->getStatusCode());
            case 422:
                throw new UnprocessableEntityException("GET request lacked required fields.", $response->getStatusCode());
            case 429:
                $responseJSON = json_decode($response->getPayload(), true, 10);

                if (! isset($responseJSON['errors'])) {
                    throw new TooManyRequestsException("The rate limit for the plan associated with this subscription has been exceeded. To see plans with higher rate limits, visit our pricing page.", $response->getStatusCode());
                }
                $errorMessage = '';
                foreach($responseJSON['errors'] as $error){
                    $errorMessage .= isset($error['message']) ? $error['message'].' ': '';
                }
                $tooManyRequests = new TooManyRequestsException($errorMessage, $response->getStatusCode());
                $tooManyRequests->setHeader($response->getHeaders());
                throw $tooManyRequests;
            case 500:
                throw new InternalServerErrorException("Internal Server Error.", $response->getStatusCode());
            case 502:
                throw new BadGatewayException("Bad Gateway error.", $response->getStatusCode());
            case 503:
                throw new ServiceUnavailableException("Service Unavailable. Try again later.", $response->getStatusCode());
            case 504:
                throw new GatewayTimeoutException("The upstream data provider did not respond in a timely fashion and the request failed. A serious, yet rare occurrence indeed.", $response->getStatusCode());
            default:
                throw new SmartyException("Error sending request. Status code is: ", $response->getStatusCode());
        }
    }
}