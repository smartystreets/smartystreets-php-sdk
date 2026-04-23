<?php

namespace SmartyStreets\PhpSdk\US_Enrichment\Business\Detail;

require_once(__DIR__ . '/../../EnrichmentLookupBase.php');
require_once(__DIR__ . '/../../../Exceptions/SmartyException.php');
require_once(__DIR__ . '/Result.php');

use SmartyStreets\PhpSdk\Exceptions\SmartyException;
use SmartyStreets\PhpSdk\US_Enrichment\EnrichmentLookupBase;

class Lookup extends EnrichmentLookupBase {
    private ?string $businessId;
    private ?Result $result = null;

    public function __construct(?string $businessId = null) {
        $this->businessId = $businessId;
    }

    public function getBusinessId(): ?string {
        return $this->businessId;
    }

    public function setBusinessId(?string $businessId): void {
        $this->businessId = $businessId;
    }

    public function getResult(): ?Result {
        return $this->result;
    }

    public function setResult(?Result $result): void {
        $this->result = $result;
    }

    public function buildResults(?array $rawArray): void {
        if ($rawArray === null || count($rawArray) === 0) {
            $this->result = null;
            return;
        }
        if (count($rawArray) > 1) {
            throw new SmartyException(
                'business detail response contained ' . count($rawArray) . ' results; expected at most 1'
            );
        }
        $this->result = new Result($rawArray[0]);
    }
}
