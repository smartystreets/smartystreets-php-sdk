<?php

namespace SmartyStreets\PhpSdk\International_Postal_Code;

require_once(__DIR__ . '/../Exceptions/SmartyException.php');
require_once(__DIR__ . '/../Sender.php');
require_once(__DIR__ . '/../Serializer.php');
require_once(__DIR__ . '/../Request.php');
require_once(__DIR__ . '/Candidate.php');
require_once(__DIR__ . '/LanguageMode.php');
use SmartyStreets\PhpSdk\Exceptions\SmartyException;
use SmartyStreets\PhpSdk\Sender;
use SmartyStreets\PhpSdk\Serializer;
use SmartyStreets\PhpSdk\Request;

/**
 * This client sends lookups to the SmartyStreets International Postal Code API, <br>
 *     and attaches the results to the appropriate Lookup objects.
 */
class Client {
    private $sender,
            $serializer;

    public function __construct(Sender $sender, ?Serializer $serializer = null) {
        $this->sender = $sender;
        $this->serializer = $serializer;
    }

    public function sendLookup(?Lookup $lookup = null) {
        if ($lookup == null)
            throw new SmartyException("lookup cannot be nil");

        $request = $this->buildRequest($lookup);
        $response = $this->sender->send($request);

        $candidates = $this->serializer->deserialize($response->getPayload());
        if ($candidates == null)
            return;

        $this->assignResultsToLookup($lookup, $candidates);
    }

    private function buildRequest(Lookup $lookup) {
        $request = new Request();

        $request->setUrlComponents("/lookup");

        $request->setParameter("input_id", $lookup->getInputId());
        $request->setParameter("country", $lookup->getCountry());
        if ($lookup->getLanguage() != null)
            $request->setParameter("language", $lookup->getLanguage()->value);
        $request->setParameter("locality", $lookup->getLocality());
        $request->setParameter("administrative_area", $lookup->getAdministrativeArea());
        $request->setParameter("postal_code", $lookup->getPostalCode());
        if ($lookup->getMaxResults() > 0)
            $request->setParameter("max_results", strval($lookup->getMaxResults()));

        return $request;
    }

    private function assignResultsToLookup(Lookup $lookup, $candidates) {
        $result = array();

        foreach ($candidates as $c) {
            $candidate = new Candidate($c);
            $result[] = $candidate;
        }

        $lookup->setResult($result);
    }
}

