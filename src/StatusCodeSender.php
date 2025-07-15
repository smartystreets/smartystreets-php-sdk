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

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class StatusCodeSender implements ClientInterface
{
    private $inner;

    public function __construct(ClientInterface $inner)
    {
        $this->inner = $inner;
    }

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $response = $this->inner->sendRequest($request);
        $status = $response->getStatusCode();
        switch ($status) {
            case 200:
                return $response;
            case 400:
                throw new BadRequestException("Bad Request (Malformed Payload): A GET request lacked a street field or the request body of a POST request contained malformed JSON.", $status);
            case 401:
                throw new BadCredentialsException("Unauthorized: The credentials were provided incorrectly or did not match any existing, active credentials.", $status);
            case 402:
                throw new PaymentRequiredException("Payment Required: There is no active subscription for the account associated with the credentials submitted with the request.", $status);
            case 408:
                throw new RequestTimeoutException("Request timeout error.", $status);
            case 413:
                throw new RequestEntityTooLargeException("Request Entity Too Large: The request body has exceeded the maximum size.", $status);
            case 422:
                throw new UnprocessableEntityException("GET request lacked required fields.", $status);
            case 429:
                $responseJSON = json_decode((string)$response->getBody(), true, 10);
                if (! isset($responseJSON['errors'])) {
                    throw new TooManyRequestsException("The rate limit for the plan associated with this subscription has been exceeded. To see plans with higher rate limits, visit our pricing page.", $status);
                }
                $errorMessage = '';
                foreach($responseJSON['errors'] as $error){
                    $errorMessage .= isset($error['message']) ? $error['message'].' ': '';
                }
                $tooManyRequests = new TooManyRequestsException($errorMessage, $status);
                // No setHeader on PSR-7, so just throw
                throw $tooManyRequests;
            case 500:
                throw new InternalServerErrorException("Internal Server Error.", $status);
            case 502:
                throw new BadGatewayException("Bad Gateway error.", $status);
            case 503:
                throw new ServiceUnavailableException("Service Unavailable. Try again later.", $status);
            case 504:
                throw new GatewayTimeoutException("The upstream data provider did not respond in a timely fashion and the request failed. A serious, yet rare occurrence indeed.", $status);
            default:
                throw new SmartyException("Error sending request. Status code is: ", $status);
        }
    }
}