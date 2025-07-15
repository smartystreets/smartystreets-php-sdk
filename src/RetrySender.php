<?php

namespace SmartyStreets\PhpSdk;

include_once('Sender.php');
require_once(__DIR__ . '/Exceptions/TooManyRequestsException.php');

use SmartyStreets\PhpSdk\Exceptions\BadGatewayException;
use SmartyStreets\PhpSdk\Exceptions\GatewayTimeoutException;
use SmartyStreets\PhpSdk\Exceptions\InternalServerErrorException;
use SmartyStreets\PhpSdk\Exceptions\MustRetryException;
use SmartyStreets\PhpSdk\Exceptions\RequestTimeoutException;
use SmartyStreets\PhpSdk\Exceptions\ServiceUnavailableException;
use SmartyStreets\PhpSdk\Exceptions\TooManyRequestsException;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;


class RetrySender implements ClientInterface
{
    const MAX_BACKOFF_DURATION = 10;
    const STATUS_TOO_MANY_REQUESTS = 429;
    const STATUS_TO_RETRY = [408, 429, 500, 502, 503, 504];


    private $inner,
        $maxRetries,
        $sleeper,
        $logger;

    public function __construct($maxRetries, $sleeper, $logger, ClientInterface $inner)
    {
        $this->inner = $inner;
        $this->sleeper = $sleeper;
        $this->logger = $logger;
        $this->maxRetries = $maxRetries;
    }

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        for ($i = 0; $i <= $this->maxRetries; $i++) {
            $response = $this->trySend($request, $i);
            if ($response !== null && !in_array($response->getStatusCode(), self::STATUS_TO_RETRY)) {
                return $response;
            }
        }
        throw new \RuntimeException('Max retries exceeded');
    }

    private function trySend(RequestInterface $request, $attempt)
    {
        try {
            return $this->inner->sendRequest($request);
        } catch (\Psr\Http\Client\ClientExceptionInterface $ex) {
            // Optionally, map specific exceptions to retry logic
            $this->backoff(self::MAX_BACKOFF_DURATION);
            if ($attempt < $this->maxRetries) {
                return null;
            } else {
                throw $ex;
            }
        } catch (\Exception $ex) {
            $this->backoff(self::MAX_BACKOFF_DURATION);
            if ($attempt < $this->maxRetries) {
                return null;
            } else {
                throw $ex;
            }
        }
        return null;
    }

    public function getInner()
    {
        return $this->inner;
    }

    public function getMaxRetries()
    {
        return $this->maxRetries;
    }

    private function backoff($backoffDuration)
    {
        $this->logger->log("There was an error processing the request. Retrying in " . $backoffDuration . " seconds...");
        $this->sleeper->sleep($backoffDuration);
    }
}