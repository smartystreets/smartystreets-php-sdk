<?php

namespace SmartyStreets\PhpSdk\US_Extract;

require_once(__DIR__ . '/../ArrayUtil.php');
require_once(__DIR__ . '/../Sender.php');
require_once(__DIR__ . '/../Serializer.php');
require_once(__DIR__ . '/../Request.php');
use SmartyStreets\PhpSdk\Exceptions\SmartyException;
use SmartyStreets\PhpSdk\ArrayUtil;
use SmartyStreets\PhpSdk\Sender;
use SmartyStreets\PhpSdk\Serializer;
use SmartyStreets\PhpSdk\Request;

/**
 * This client sends lookups to the SmartyStreets US Extract API, <br>
 *     and attaches the results to the Lookup objects.
 */
class Client {
    private $sender,
        $serializer;

    public function __construct(Sender $sender, ?Serializer $serializer = null) {
        $this->sender = $sender;
        $this->serializer = $serializer;
    }

    public function sendLookup(?Lookup $lookup = null) {
        if ($lookup == null || $lookup->getText() == null || strlen($lookup->getText()) == 0)
            throw new SmartyException("sendLookup() requires a Lookup with the 'text' field set");

        $request = $this->buildRequest($lookup);
        $response = $this->sender->send($request, '');

        $result = $this->serializer->deserialize($response->getPayload());
        if ($result == null)
            return;

        $lookup->setResult((new Result($result)));
    }

    private function buildRequest(Lookup $lookup) {
        $request = new Request();
        $request->setContentType("text/plain");
        $request->setPayload($lookup->getText());

        $request->setParameter('html', ArrayUtil::getStringValueOfBoolean($lookup->isHtml()));
        $request->setParameter('aggressive', ArrayUtil::getStringValueOfBoolean($lookup->isAggressive()));
        $request->setParameter('addr_line_breaks', ArrayUtil::getStringValueOfBoolean($lookup->addressesHaveLineBreaks()));
        $request->setParameter('addr_per_line', strval($lookup->getAddressesPerLine()));

        $match = strval($lookup->getMatchStrategy());
        if ($match != ""){
            $request->setParameter('match', $match);
        }

        foreach ($lookup->getCustomParamArray() as $key => $value) {
            $request->setParameter($key, $value);
        }

        return $request;
    }
}