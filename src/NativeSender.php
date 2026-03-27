<?php

namespace SmartyStreets\PhpSdk;

include_once('Sender.php');
require_once(__DIR__ . '/Response.php');
require_once(__DIR__ . '/Version.php');
require_once(__DIR__ . '/Proxy.php');
require_once(__DIR__ . '/Exceptions/SmartyException.php');

use SmartyStreets\PhpSdk\Exceptions\SmartyException;

class NativeSender implements Sender
{
    private $maxTimeOut,
        $proxy,
        $debugMode;

    public function __construct($maxTimeOut = 10000, ?Proxy $proxy = null, $debugMode = false) {
        $this->maxTimeOut = $maxTimeOut;
        $this->proxy = $proxy;
        $this->debugMode = $debugMode;
    }

    function send(Request $smartyRequest) {
        $ch = $this->buildRequest($smartyRequest);
        $result = curl_exec($ch);

        if ($result === false) {
            $errorMessage = curl_error($ch);
            if (PHP_VERSION_ID < 80000) {
                curl_close($ch);
            }
            throw new SmartyException($errorMessage);
        }

        $headerSize = curl_getinfo( $ch , CURLINFO_HEADER_SIZE );
        $headerStr = substr( $result , 0 , $headerSize );
        $bodyStr = substr( $result , $headerSize );
        $headers = $this->headersToArray($headerStr);

        if ($this->debugMode) {
            $this->printDebugInfo($ch, $smartyRequest, $bodyStr);
        }

        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (PHP_VERSION_ID < 80000) {
            curl_close($ch);
        }

        return new Response($statusCode, $bodyStr, $headers);
    }

    private function buildRequest(Request $smartyRequest) {
        $url = $smartyRequest->getUrl();

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_ENCODING, "gzip");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $smartyRequest->getMethod());
        curl_setopt($ch, CURLOPT_POSTFIELDS, ($smartyRequest->getPayload()));
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, $this->maxTimeOut);
        if ($this->debugMode && defined("STDERR"))
            curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        if ($this->proxy != null)
            $this->setProxy($ch);

        if ($smartyRequest->getReferer() != null)
            curl_setopt($ch, CURLOPT_REFERER, $smartyRequest->getReferer());

        $smartyRequest->setHeader('Content-Type', $smartyRequest->getContentType());

        $hasUserAgent = false;
        foreach ($smartyRequest->getHeaders() as $key => $value) {
            if (strcasecmp($key, 'User-Agent') === 0) {
                $hasUserAgent = true;
                break;
            }
        }
        if (!$hasUserAgent) {
            $smartyRequest->setHeader('User-Agent', 'smartystreets (sdk:php@' . VERSION . ')');
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->getCURLOPTHeaders($smartyRequest));

        return $ch;
    }

    private function setProxy(&$ch) {
        curl_setopt($ch, CURLOPT_PROXY, $this->proxy->getAddress());

        if ($this->proxy->getCredentials() != null)
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->proxy->getCredentials());
    }

    private function getCURLOPTHeaders(Request $smartyRequest) {
        $headers = array();
        foreach ($smartyRequest->getHeaders() as $key => $value) {
            $headers[] = "$key: $value";
        }
        return $headers;
    }

    private function printDebugInfo($ch, Request $smartyRequest, $responsePayload) {
        fwrite(STDERR, "*****Request*****\r\n" . curl_getinfo($ch, CURLINFO_HEADER_OUT));
        if ($smartyRequest->getPayload() != null)
            fwrite(STDERR, "Data: " . $smartyRequest->getPayload());

        fwrite(STDERR, "\r\n\r\n*****Response*****");
        fwrite(STDERR, "\r\nStatus: " . curl_getinfo($ch, CURLINFO_HTTP_CODE));
        fwrite(STDERR, "\r\nResponse body: " . $responsePayload);
    }

    function headersToArray( $str ) {
        $headers = array();
        $headersTmpArray = explode( "\r\n" , $str );
        for ( $i = 0 ; $i < count( $headersTmpArray ) ; ++$i )
        {
            // we dont care about the two \r\n lines at the end of the headers
            if ( strlen( $headersTmpArray[$i] ) > 0 )
            {
                // the headers start with HTTP status codes, which do not contain a colon so we can filter them out too
                if ( strpos( $headersTmpArray[$i] , ":" ) )
                {
                    $headerName = substr( $headersTmpArray[$i] , 0 , strpos( $headersTmpArray[$i] , ":" ) );
                    $headerValue = substr( $headersTmpArray[$i] , strpos( $headersTmpArray[$i] , ":" )+1 );
                    $headers[$headerName] = $headerValue;
                }
            }
        }
        return $headers;
    }
}
