<?php

namespace SmartyStreets\PhpSdk\US_Enrichment\Business\Summary;

require_once(__DIR__ . '/../../Lookup.php');
require_once(__DIR__ . '/Result.php');

use SmartyStreets\PhpSdk\US_Enrichment\Lookup as EnrichmentLookup;

class Lookup extends EnrichmentLookup {
    /** @var Result[]|null */
    private ?array $results = null;

    public function __construct(?string $smartyKey = null) {
        parent::__construct($smartyKey, 'business', null);
    }

    /**
     * @return Result[]|null Null when the record was not modified (304) or no request has been sent.
     */
    public function getResults(): ?array {
        return $this->results;
    }

    /**
     * @param Result[] $results
     */
    public function setResults(array $results): void {
        $this->results = $results;
    }

    public function buildResults(?array $rawArray): void {
        if ($rawArray === null) {
            $this->results = [];
            return;
        }
        $results = [];
        foreach ($rawArray as $entry) {
            $results[] = new Result($entry);
        }
        $this->results = $results;
    }
}
