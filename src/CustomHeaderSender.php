<?php

namespace SmartyStreets\PhpSdk;

require_once(__DIR__ . '/Sender.php');

class CustomHeaderSender implements Sender
{
    private $customHeaders;
    private $appendHeaders;
    private $inner;

    public function __construct(array $customHeaders, Sender $inner, array $appendHeaders = []) {
        $this->customHeaders = $customHeaders;
        $this->inner = $inner;
        $this->appendHeaders = $appendHeaders;
    }

    public function send(Request $request) {
        foreach ($this->customHeaders as $key => $value) {
            $appendKey = $this->findAppendHeaderKey($key);
            if ($appendKey !== null) {
                $separator = $this->appendHeaders[$appendKey];
                $headers = $request->getHeaders();
                $existingKey = null;
                foreach ($headers as $hk => $hv) {
                    if (strcasecmp($hk, $key) === 0) {
                        $existingKey = $hk;
                        break;
                    }
                }
                $existing = $existingKey !== null ? $headers[$existingKey] : '';
                $headerKey = $existingKey !== null ? $existingKey : $key;
                $request->setHeader($headerKey, $existing !== '' ? $existing . $separator . $value : $value);
            } else {
                $request->setHeader($key, $value);
            }
        }
        return $this->inner->send($request);
    }

    private function findAppendHeaderKey($header) {
        foreach ($this->appendHeaders as $key => $separator) {
            if (strcasecmp($key, $header) === 0) {
                return $key;
            }
        }
        return null;
    }
}
