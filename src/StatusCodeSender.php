<?php

namespace SmartyStreets\PhpSdk;

include_once('Sender.php');
require_once(__DIR__ . '/HeaderUtil.php');
require_once(__DIR__ . '/Exceptions/BadCredentialsException.php');
require_once(__DIR__ . '/Exceptions/BadGatewayException.php');
require_once(__DIR__ . '/Exceptions/BadRequestException.php');
require_once(__DIR__ . '/Exceptions/ForbiddenException.php');
require_once(__DIR__ . '/Exceptions/InternalServerErrorException.php');
require_once(__DIR__ . '/Exceptions/PaymentRequiredException.php');
require_once(__DIR__ . '/Exceptions/RequestEntityTooLargeException.php');
require_once(__DIR__ . '/Exceptions/RequestNotModifiedException.php');
require_once(__DIR__ . '/Exceptions/RequestTimeoutException.php');
require_once(__DIR__ . '/Exceptions/ServiceUnavailableException.php');
require_once(__DIR__ . '/Exceptions/TooManyRequestsException.php');
require_once(__DIR__ . '/Exceptions/UnprocessableEntityException.php');
require_once(__DIR__ . '/Exceptions/GatewayTimeoutException.php');

use SmartyStreets\PhpSdk\Exceptions\BadCredentialsException;
use SmartyStreets\PhpSdk\Exceptions\BadGatewayException;
use SmartyStreets\PhpSdk\Exceptions\BadRequestException;
use SmartyStreets\PhpSdk\Exceptions\ForbiddenException;
use SmartyStreets\PhpSdk\Exceptions\InternalServerErrorException;
use SmartyStreets\PhpSdk\Exceptions\PaymentRequiredException;
use SmartyStreets\PhpSdk\Exceptions\RequestEntityTooLargeException;
use SmartyStreets\PhpSdk\Exceptions\RequestNotModifiedException;
use SmartyStreets\PhpSdk\Exceptions\RequestTimeoutException;
use SmartyStreets\PhpSdk\Exceptions\ServiceUnavailableException;
use SmartyStreets\PhpSdk\Exceptions\SmartyException;
use SmartyStreets\PhpSdk\Exceptions\TooManyRequestsException;
use SmartyStreets\PhpSdk\Exceptions\UnprocessableEntityException;
use SmartyStreets\PhpSdk\Exceptions\GatewayTimeoutException;


const DEFAULT_BACKOFF_DURATION = 10;

class StatusCodeSender implements Sender
{
    private $inner;

    public function __construct(Sender $inner)
    {
        $this->inner = $inner;
    }

    function messageFrom(Response $response, String $fallback)
    {
        $payload = $response->getPayload();
        $body = $payload === null ? '' : trim($payload);

        if ($body !== '') {
            $responseJSON = json_decode($payload, true, 10);

            if (isset($responseJSON['errors'])) {
                $errorMessage = '';
                foreach ($responseJSON['errors'] as $error) {
                    $errorMessage .= isset($error['message']) ? $error['message'] . ' ' : '';
                }

                $errorMessage = trim($errorMessage);
                if ($errorMessage !== '') {
                    return $errorMessage;
                }
            }
        }

        return trim($fallback . ' Body: ' . $body);
    }

    function send(Request $request)
    {
        $response = $this->inner->send($request);

        switch ($response->getStatusCode()) {
            case 200:
            case 304:
                return $response;
            case 400:
                throw new BadRequestException($this->messageFrom($response, "Bad Request (Malformed Payload): A GET request lacked a required field or the request body of a POST request contained malformed JSON."), $response->getStatusCode());
            case 401:
                throw new BadCredentialsException($this->messageFrom($response, "Unauthorized: The credentials were provided incorrectly or did not match any existing, active credentials."), $response->getStatusCode());
            case 402:
                throw new PaymentRequiredException($this->messageFrom($response, "Payment Required: There is no active subscription for the account associated with the credentials submitted with the request."), $response->getStatusCode());
            case 403:
                throw new ForbiddenException($this->messageFrom($response, "Forbidden: The request contained valid data and was understood by the server, but the server is refusing action."), $response->getStatusCode());
            case 408:
                throw new RequestTimeoutException($this->messageFrom($response, "Request timeout error."), $response->getStatusCode());
            case 413:
                throw new RequestEntityTooLargeException($this->messageFrom($response, "Request Entity Too Large: The request body has exceeded the maximum size."), $response->getStatusCode());
            case 422:
                throw new UnprocessableEntityException($this->messageFrom($response, "GET request lacked required fields."), $response->getStatusCode());
            case 429:
                $retryAfterValue = DEFAULT_BACKOFF_DURATION;
                if (isset($response->getHeaders()['retry-after'])){
                    $retryAfterValue = intval($response->getHeaders()['retry-after']);
                }

                throw new TooManyRequestsException($this->messageFrom($response, "Too Many Requests: The rate limit for your account has been exceeded."), $response->getStatusCode(), $retryAfterValue);
            case 500:
                throw new InternalServerErrorException($this->messageFrom($response, "Internal Server Error."), $response->getStatusCode());
            case 502:
                throw new BadGatewayException($this->messageFrom($response, "Bad Gateway error."), $response->getStatusCode());
            case 503:
                throw new ServiceUnavailableException($this->messageFrom($response, "Service Unavailable. Try again later."), $response->getStatusCode());
            case 504:
                throw new GatewayTimeoutException($this->messageFrom($response, "The upstream data provider did not respond in a timely fashion and the request failed. A serious, yet rare occurrence indeed."), $response->getStatusCode());
            default:
                throw new SmartyException($this->messageFrom($response, "The server returned an unexpected HTTP status code: " . $response->getStatusCode()), $response->getStatusCode());
        }
    }
}