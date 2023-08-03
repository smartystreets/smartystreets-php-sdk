<?php

namespace SmartyStreets\PhpSdk;

include_once('Sender.php');
require_once('Exceptions/TooManyRequestsException.php');

use SmartyStreets\PhpSdk\Exceptions\BadGatewayException;
use SmartyStreets\PhpSdk\Exceptions\GatewayTimeoutException;
use SmartyStreets\PhpSdk\Exceptions\InternalServerErrorException;
use SmartyStreets\PhpSdk\Exceptions\MustRetryException;
use SmartyStreets\PhpSdk\Exceptions\RequestTimeoutException;
use SmartyStreets\PhpSdk\Exceptions\ServiceUnavailableException;
use SmartyStreets\PhpSdk\Exceptions\TooManyRequestsException;


class RetrySender implements Sender
{
    const MAX_BACKOFF_DURATION = 10;
    const STATUS_TOO_MANY_REQUESTS = 429;
    const STATUS_TO_RETRY = [408, 429, 500, 502, 503, 504];


    private $inner,
        $maxRetries,
        $sleeper,
        $logger;

    public function __construct($maxRetries, Sleeper $sleeper, Logger $logger, Sender $inner)
    {
        $this->inner = $inner;
        $this->sleeper = $sleeper;
        $this->logger = $logger;
        $this->maxRetries = $maxRetries;
    }

    public function send(Request $request)
    {
        for ($i = 0; $i <= $this->maxRetries; $i++) {
            $response = $this->trySend($request, $i);

            if ($response!= null && !in_array($response->getStatusCode(), self::STATUS_TO_RETRY)){
                return $response;
            }
        }
        return null;
    }

    private function trySend(Request $request, $attempt)
    {
        try {
            return $this->inner->send($request);
        } catch (TooManyRequestsException $ex) {
            $this->backoff($ex->getHeader());
            return null;
        } catch (\Exception $ex) {
            if (($ex instanceof MustRetryException || $ex instanceof InternalServerErrorException || $ex instanceof ServiceUnavailableException || $ex instanceof GatewayTimeoutException || $ex instanceof RequestTimeoutException || $ex instanceof BadGatewayException) && $attempt < $this->maxRetries) {
                $this->backoff(self::MAX_BACKOFF_DURATION);
            } else {
                echo $ex->getCode() . "\n";
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