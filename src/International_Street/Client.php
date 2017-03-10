<?php

namespace SmartyStreets\PhpSdk\International_Street;

require_once(dirname(dirname(__FILE__)) . '/Exceptions/UnprocessableEntityException.php');
require_once(dirname(dirname(__FILE__)) . '/Sender.php');
require_once(dirname(dirname(__FILE__)) . '/Serializer.php');
require_once(dirname(dirname(__FILE__)) . '/Request.php');
require_once(dirname(dirname(__FILE__)) . '/Batch.php');
require_once('Candidate.php');

use SmartyStreets\PhpSdk\Exceptions\UnprocessableEntityException;
use SmartyStreets\PhpSdk\Sender;
use SmartyStreets\PhpSdk\Serializer;
use SmartyStreets\PhpSdk\Request;

class Client {
    private $sender,
            $serializer,
            $referer;

    public function __construct(Sender $sender, Serializer $serializer = null, $referer = null) {
        $this->sender = $sender;
        $this->serializer = $serializer;
        $this->referer = $referer;
    }

    public function sendLookup(Lookup $lookup) {
        $this->ensureEnoughInfo($lookup);
        $request = $this->buildRequest($lookup);

        $response = $this->sender->send($request);

        $candidates = $this->serializer->deserialize($response->getPayload());
        if ($candidates == null)
            $candidates = array();

        $this->assignResultsToLookups($lookup, $candidates);
    }

    private function buildRequest(Lookup $lookup) {
        $request = new Request();

        $request->setParameter("country", $lookup->getCountry());
        $request->setParameter("geocode", $lookup->getGeocode());
        if ($lookup->getLanguage() != null)
            $request->setParameter("language", $lookup->getLanguage()->getName());
        $request->setParameter("freeform", $lookup->getFreeform());
        $request->setParameter("address1", $lookup->getAddress1());
        $request->setParameter("address2", $lookup->getAddress2());
        $request->setParameter("address3", $lookup->getAddress3());
        $request->setParameter("address4", $lookup->getAddress4());
        $request->setParameter("organization", $lookup->getOrganization());
        $request->setParameter("locality", $lookup->getLocality());
        $request->setParameter("administrative_area", $lookup->getAdministrativeArea());
        $request->setParameter("postal_code", $lookup->getPostalCode());
        $request->setReferer($this->referer);

        return $request;
    }

    private function ensureEnoughInfo(Lookup $lookup) {
        if ($lookup->missingCountry())
            throw new UnprocessableEntityException("Country field is required.");

        if ($lookup->hasFreeform())
            return;

        if ($lookup->missingAddress1())
            throw new UnprocessableEntityException("Either freeform or address1 is required.");

        if ($lookup->hasPostalCode())
            return;

        if ($lookup->missingLocalityOrAdministrativeArea())
            throw new UnprocessableEntityException("Insufficient information: One or more required fields were not set on the lookup.");
    }

    private function assignResultsToLookups(Lookup $lookup, $candidates) {
        foreach ($candidates as $c) {
            $candidate = new Candidate($c);
            $lookup->setResult($candidate);
        }
    }
}