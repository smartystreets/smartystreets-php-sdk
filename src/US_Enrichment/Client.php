<?php

namespace SmartyStreets\PhpSdk\US_Enrichment;

require_once(__DIR__ . '/../Exceptions/SmartyException.php');
require_once(__DIR__ . '/../Exceptions/UnprocessableEntityException.php');
require_once(__DIR__ . '/../HeaderUtil.php');
require_once(__DIR__ . '/../Sender.php');
require_once(__DIR__ . '/../Serializer.php');
require_once(__DIR__ . '/../Request.php');
require_once(__DIR__ . '/EnrichmentLookupBase.php');
require_once(__DIR__ . '/Lookup.php');
require_once(__DIR__ . '/Result.php');
require_once(__DIR__ . '/Business/Summary/Lookup.php');
require_once(__DIR__ . '/Business/Detail/Lookup.php');

use SmartyStreets\PhpSdk\Exceptions\SmartyException;
use SmartyStreets\PhpSdk\HeaderUtil;
use SmartyStreets\PhpSdk\Request;
use SmartyStreets\PhpSdk\Sender;
use SmartyStreets\PhpSdk\Serializer;
use SmartyStreets\PhpSdk\US_Enrichment\Business\Detail\Lookup as BusinessDetailLookup;
use SmartyStreets\PhpSdk\US_Enrichment\Business\Summary\Lookup as BusinessSummaryLookup;

class Client {
    private Sender $sender;
    private ?Serializer $serializer;

    public function __construct(Sender $sender, ?Serializer $serializer = null) {
        $this->sender = $sender;
        $this->serializer = $serializer;
    }

    public function sendPropertyPrincipalLookup($principalLookup) {
        return $this->sendDatasetLookup($principalLookup, 'property', 'principal');
    }

    public function sendGeoReferenceLookup($geoReferenceLookup) {
        return $this->sendDatasetLookup($geoReferenceLookup, 'geo-reference', null);
    }

    public function sendRiskLookup($riskLookup) {
        return $this->sendDatasetLookup($riskLookup, 'risk', null);
    }

    public function sendSecondaryLookup($secondaryLookup) {
        return $this->sendDatasetLookup($secondaryLookup, 'secondary', null);
    }

    public function sendSecondaryCountLookup($secondaryCountLookup) {
        return $this->sendDatasetLookup($secondaryCountLookup, 'secondary', 'count');
    }

    public function sendGenericLookup($genericLookup, string $dataSetName, ?string $dataSubsetName) {
        return $this->sendDatasetLookup($genericLookup, $dataSetName, $dataSubsetName);
    }

    /**
     * @param BusinessSummaryLookup|string|null $businessLookup SmartyKey string or a Business\Summary\Lookup.
     * @return \SmartyStreets\PhpSdk\US_Enrichment\Business\Summary\Result[]
     */
    public function sendBusinessLookup($businessLookup): array {
        if (is_string($businessLookup)) {
            $lookup = new BusinessSummaryLookup($businessLookup);
        } elseif ($businessLookup instanceof BusinessSummaryLookup) {
            $lookup = $businessLookup;
        } else {
            throw new SmartyException('sendBusinessLookup requires a string SmartyKey or Business\\Summary\\Lookup');
        }
        $this->assertAddressIdentifierPresent($lookup);
        $request = $this->buildEnrichmentRequest($lookup);
        $this->dispatch($request, $lookup);
        return $lookup->getResults();
    }

    /**
     * @param BusinessDetailLookup|string|null $detailLookup businessId string or a Business\Detail\Lookup.
     */
    public function sendBusinessDetailLookup($detailLookup): ?\SmartyStreets\PhpSdk\US_Enrichment\Business\Detail\Result {
        if (is_string($detailLookup)) {
            $lookup = new BusinessDetailLookup($detailLookup);
        } elseif ($detailLookup instanceof BusinessDetailLookup) {
            $lookup = $detailLookup;
        } else {
            throw new SmartyException('sendBusinessDetailLookup requires a string businessId or Business\\Detail\\Lookup');
        }
        $businessId = $lookup->getBusinessId();
        if ($businessId === null || trim($businessId) === '') {
            throw new SmartyException("Business\\Detail\\Lookup requires a non-empty 'businessId'");
        }
        $request = new Request();
        $request->setUrlComponents('/business/' . rawurlencode($businessId));
        $this->applyIncludeExclude($request, $lookup);
        $this->applyEtagAndCustomParams($request, $lookup);
        $this->dispatch($request, $lookup);
        return $lookup->getResult();
    }

    private function sendDatasetLookup($input, string $dataSetName, ?string $dataSubsetName) {
        if (is_string($input)) {
            $lookup = new Lookup($input, $dataSetName, $dataSubsetName);
        } elseif ($input instanceof Lookup) {
            $lookup = $input;
            $lookup->setDataSetName($dataSetName);
            $lookup->setDataSubsetName($dataSubsetName);
        } else {
            throw new SmartyException('Enrichment lookup requires a string SmartyKey or US_Enrichment\\Lookup');
        }
        $this->assertAddressIdentifierPresent($lookup);
        $request = $this->buildEnrichmentRequest($lookup);
        $this->dispatch($request, $lookup);
        return $lookup->getResponse();
    }

    private function assertAddressIdentifierPresent(Lookup $lookup): void {
        if (self::isBlank($lookup->getSmartyKey())
            && self::isBlank($lookup->getStreet())
            && self::isBlank($lookup->getFreeform())) {
            throw new SmartyException("Lookup requires one of 'smartyKey', 'street', or 'freeform' to be set");
        }
    }

    private static function isBlank(?string $value): bool {
        return $value === null || trim($value) === '';
    }

    private function dispatch(Request $request, EnrichmentLookupBase $lookup): void {
        $response = $this->sender->send($request);
        $etag = HeaderUtil::extractEtag($response->getHeaders());
        if ($etag !== null) {
            $lookup->setResponseEtag($etag);
        }
        $payload = $response->getPayload();
        $decoded = $payload === null || $payload === '' ? null : $this->serializer->deserialize($payload);
        $lookup->buildResults(is_array($decoded) ? $decoded : null);
    }

    private function buildEnrichmentRequest(Lookup $lookup): Request {
        $request = new Request();
        $request->setUrlComponents('/lookup/' . $this->getUrlPrefix($lookup));

        if ($lookup->getSmartyKey() === null) {
            $request->setParameter('freeform', $lookup->getFreeform());
            $request->setParameter('street', $lookup->getStreet());
            $request->setParameter('city', $lookup->getCity());
            $request->setParameter('state', $lookup->getState());
            $request->setParameter('zipcode', $lookup->getZipcode());
        }
        $this->applyIncludeExclude($request, $lookup);
        $request->setParameter('features', $lookup->getFeatures());
        $this->applyEtagAndCustomParams($request, $lookup);
        return $request;
    }

    private function applyIncludeExclude(Request $request, EnrichmentLookupBase $lookup): void {
        $include = $this->buildFilterString($lookup->getIncludeArray());
        if ($include !== null) {
            $request->setParameter('include', $include);
        }
        $exclude = $this->buildFilterString($lookup->getExcludeArray());
        if ($exclude !== null) {
            $request->setParameter('exclude', $exclude);
        }
    }

    private function applyEtagAndCustomParams(Request $request, EnrichmentLookupBase $lookup): void {
        if ($lookup->getRequestEtag() !== null) {
            $request->setHeader('Etag', $lookup->getRequestEtag());
        }
        foreach ($lookup->getCustomParamArray() as $key => $value) {
            $request->setParameter($key, $value);
        }
    }

    private function getUrlPrefix(Lookup $lookup): string {
        if ($lookup->getSmartyKey() === null) {
            if ($lookup->getDataSubsetName() === null) {
                return 'search/' . $lookup->getDataSetName();
            }
            return 'search/' . $lookup->getDataSetName() . '/' . $lookup->getDataSubsetName();
        }
        if ($lookup->getDataSubsetName() === null) {
            return $lookup->getSmartyKey() . '/' . $lookup->getDataSetName();
        }
        return $lookup->getSmartyKey() . '/' . $lookup->getDataSetName() . '/' . $lookup->getDataSubsetName();
    }

    private function buildFilterString(array $list): ?string {
        if (empty($list)) {
            return null;
        }
        return implode(',', $list);
    }
}
