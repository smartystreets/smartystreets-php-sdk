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
        $body = (string)$response->getBody();
        $errorDetail = '';
        if ($status >= 400) {
            $responseJSON = json_decode($body, true);
            if (is_array($responseJSON)) {
                if (isset($responseJSON['errors']) && is_array($responseJSON['errors'])) {
                    foreach ($responseJSON['errors'] as $error) {
                        $errorDetail .= isset($error['message']) ? $error['message'] . ' ' : '';
                    }
                } elseif (isset($responseJSON['error'])) {
                    $errorDetail .= $responseJSON['error'] . ' ';
                } elseif (isset($responseJSON['message'])) {
                    $errorDetail .= $responseJSON['message'] . ' ';
                }
            }
        }
        switch ($status) {
            case 200:
                return $response;
            case 400:
                throw new BadRequestException("Bad Request: $errorDetail", $status);
            case 401:
                throw new BadCredentialsException("Unauthorized: $errorDetail", $status);
            case 402:
                throw new PaymentRequiredException("Payment Required: $errorDetail", $status);
            case 408:
                throw new RequestTimeoutException("Request timeout error: $errorDetail", $status);
            case 413:
                throw new RequestEntityTooLargeException("Request Entity Too Large: $errorDetail", $status);
            case 422:
                throw new UnprocessableEntityException("Unprocessable Entity: $errorDetail", $status);
            case 429:
                throw new TooManyRequestsException("Too Many Requests: $errorDetail", $status);
            case 500:
                throw new InternalServerErrorException("Internal Server Error: $errorDetail", $status);
            case 502:
                throw new BadGatewayException("Bad Gateway error: $errorDetail", $status);
            case 503:
                throw new ServiceUnavailableException("Service Unavailable: $errorDetail", $status);
            case 504:
                throw new GatewayTimeoutException("Gateway Timeout: $errorDetail", $status);
            default:
                throw new SmartyException("Error sending request. Status code is: $status $errorDetail", $status);
        }
    }
}