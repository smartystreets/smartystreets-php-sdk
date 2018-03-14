<?php

namespace SmartyStreets\PhpSdk;

include_once('Logger.php');

/**
 * Log adapter for a PSR-3 compatible logging channel, such as Monolog.
 *
 * @package SmartyStreets\PhpSdk
 */
class Psr3Logger implements Logger
{
    private $logger;

    function __construct(\Psr\Log\LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    function log($message)
    {
        $this->logger->info($message);
    }
}
