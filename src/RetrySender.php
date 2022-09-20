<?php

namespace SmartyStreets\PhpSdk;

include_once('Sender.php');
require_once('Exceptions/TooManyRequestsException.php');
use SmartyStreets\PhpSdk\Exceptions\TooManyRequestsException;


class RetrySender implements Sender {
    const MAX_BACKOFF_DURATION = 10;
    const STATUS_TO_RETRY = [408, 429, 500, 502, 503, 504];
    private $inner,
            $maxRetries,
            $sleeper,
            $logger;

    public function __construct($maxRetries, Sleeper $sleeper, Logger $logger, Sender $inner) {
        $this->inner = $inner;
        $this->sleeper = $sleeper;
        $this->logger = $logger;
        $this->maxRetries = $maxRetries;
    }

    public function send(Request $request) {
        for ($i = 0; $i <= $this->maxRetries; $i++) {
            $response = $this->trySend($request, $i);

            if ($response != null)
            if ($response!= null && !in_array($response->getStatusCode(), self::STATUS_TO_RETRY)){
                return $response;
            }
        }
        return null;
    }

    private function trySend(Request $request, $attempt) {
        try {
            return $this->inner->send($request);
        } catch (TooManyRequestsException $ex) {
            $this->backoff(5);
        } catch (\Exception $ex) {
            if ($attempt >= $this->maxRetries)
                throw $ex;
        }

        $this->backoff($attempt);

        return null;
    }

    public function getInner() {
        return $this->inner;
    }

    public function getMaxRetries() {
        return $this->maxRetries;
    }

    private function backoff($attempt) {
        $backoffDuration = min($attempt, self::MAX_BACKOFF_DURATION);

        $this->logger->log("There was an error processing the request. Retrying in " . $backoffDuration . " seconds...");
        $this->sleeper->sleep($backoffDuration);
    }
}