<?php

namespace SmartyStreets\PhpSdk\US_Reverse_Geo;

require_once(__DIR__ . '/../Exceptions/UnprocessableEntityException.php');
require_once(__DIR__ . '/../Sender.php');
require_once(__DIR__ . '/../Serializer.php');
require_once(__DIR__ . '/../Request.php');
require_once(__DIR__ . '/../Batch.php');
require_once(__DIR__ . '/Response.php');
use SmartyStreets\PhpSdk\Sender;
use SmartyStreets\PhpSdk\Serializer;
use SmartyStreets\PhpSdk\Request;

/**
 * This client sends lookups to the SmartyStreets US Reverse Geocoding API, <br>
 *     and attaches the results to the appropriate Lookup objects.
 */
class Client {
    private $sender,
            $serializer;

    public function __construct(Sender $sender, ?Serializer $serializer = null) {
        $this->sender = $sender;
        $this->serializer = $serializer;
    }

    public function sendLookup(Lookup $lookup) {
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
    public function sendLookupWithAuth(Lookup $lookup, $authId = null, $authToken = null) {
        $request = $this->buildRequest($lookup);

        if (!empty($authId) && !empty($authToken)) {
            $request->setBasicAuth($authId, $authToken);
        }

        $response = $this->sender->send($request);

        $lookupResponse = new Response($this->serializer->deserialize($response->getPayload()));

        $lookup->setResponse($lookupResponse);
    }


    private function buildRequest(Lookup $lookup) {
        $request = new Request();

        $request->setUrlComponents("/lookup");

        $request->setParameter("latitude", $lookup->getLatitude());
        $request->setParameter("longitude", $lookup->getLongitude());
        $request->setParameter("source", $lookup->getSource());

        foreach ($lookup->getCustomParamArray() as $key => $value) {
            $request->setParameter($key, $value);
        }

        return $request;
    }
}