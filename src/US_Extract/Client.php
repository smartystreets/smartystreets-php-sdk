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
        $this->sendLookupWithAuth($lookup, null, null);
    }

    /**
     * Sends a lookup with per-request credentials.
     * If authId and authToken are both non-empty, they will be used for this request
     * instead of the client-level credentials. This is useful for multi-tenant scenarios
     * where different requests require different credentials.
     *
     * @param lookup Lookup
     * @param authId string|null Per-request auth ID
     * @param authToken string|null Per-request auth token
     * @throws SmartyException
     * @throws IOException
     */
    public function sendLookupWithAuth(?Lookup $lookup = null, $authId = null, $authToken = null) {
        if ($lookup == null || $lookup->getText() == null || strlen($lookup->getText()) == 0)
            throw new SmartyException("sendLookup() requires a Lookup with the 'text' field set");

        $request = $this->buildRequest($lookup);

        if (!empty($authId) && !empty($authToken)) {
            $request->setBasicAuth($authId, $authToken);
        }

        $response = $this->sender->send($request);

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