<?php

namespace SmartyStreets\PhpSdk;

include_once('Sender.php');
require_once('Response.php');
require_once('Version.php');
require_once('Proxy.php');

use SmartyStreets\PhpSdk\Exceptions\SmartyException;

const DEFAULT_BACKOFF_DURATION = 10;
const STATUS_TOO_MANY_REQUESTS = 429;

class NativeSender implements Sender
{


    private $maxTimeOut,
        $proxy,
        $debugMode;

    public function __construct($maxTimeOut = 10000, Proxy $proxy = null, $debugMode = false)
    {
        $this->maxTimeOut = $maxTimeOut;
        $this->proxy = $proxy;
        $this->debugMode = $debugMode;
    }

    function send(Request $smartyRequest)
    {
        $ch = $this->buildRequest($smartyRequest);
        $this->setHeaders($smartyRequest, $ch);
        $result = curl_exec($ch);

        $headerSize = curl_getinfo( $ch , CURLINFO_HEADER_SIZE );
        $headerStr = substr( $result , 0 , $headerSize );
        $bodyStr = substr( $result , $headerSize );
        $headers = $this->headersToArray($headerStr);

        if ($this->debugMode)
            $this->printDebugInfo($ch, $smartyRequest, $bodyStr);

        $connectCode = curl_getinfo($ch, CURLINFO_HTTP_CONNECTCODE);
        if ($bodyStr === FALSE && $connectCode != 200) {
            $errorMessage = curl_error($ch);
            curl_close($ch);
            throw new SmartyException($errorMessage);
        }

        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $retryHeaderValue = DEFAULT_BACKOFF_DURATION;
        if ($statusCode == STATUS_TOO_MANY_REQUESTS){
            $retryHeaderValue = intval($headers['retry-after']);
        }

        curl_close($ch);

        return new Response($statusCode, $bodyStr, $retryHeaderValue);
    }

    private function buildRequest(Request $smartyRequest)
    {
        $url = $smartyRequest->getUrl();

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_ENCODING, "gzip");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $smartyRequest->getMethod());
        curl_setopt($ch, CURLOPT_POSTFIELDS, ($smartyRequest->getPayload()));
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->setHeaders($smartyRequest));
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, $this->maxTimeOut);
        curl_setopt($ch, CURLOPT_USERAGENT, 'smartystreets (sdk:php@' . VERSION . ')');
        if ($this->debugMode && defined("STDERR"))
            curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        if ($this->proxy != null)
            $this->setProxy($ch);

        if ($smartyRequest->getReferer() != null)
            curl_setopt($ch, CURLOPT_REFERER, $smartyRequest->getReferer());

        return $ch;
    }

    private function setProxy(&$ch)
    {
        curl_setopt($ch, CURLOPT_PROXY, $this->proxy->getAddress());

        if ($this->proxy->getCredentials() != null)
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->proxy->getCredentials());
    }

    private function setHeaders(Request $smartyRequest)
    {
        $headers = array();

        foreach (array_keys($smartyRequest->getHeaders()) as $key) {
            $headers[$key] = $smartyRequest->getHeaders()[$key];
        }

        $headers[] = 'Content-Type: ' . $smartyRequest->getContentType();

        return $headers;
    }

    private function printDebugInfo($ch, Request $smartyRequest, $responsePayload)
    {
        fwrite(STDERR, "*****Request*****\r\n" . curl_getinfo($ch, CURLINFO_HEADER_OUT));
        if ($smartyRequest->getPayload() != null)
            fwrite(STDERR, "Data: " . $smartyRequest->getPayload());

        fwrite(STDERR, "\r\n\r\n*****Response*****");
        fwrite(STDERR, "\r\nStatus: " . curl_getinfo($ch, CURLINFO_HTTP_CODE));
        fwrite(STDERR, "\r\nResponse body: " . $responsePayload);
    }

    function headersToArray( $str )
    {
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
