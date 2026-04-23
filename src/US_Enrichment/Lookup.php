<?php

namespace SmartyStreets\PhpSdk\US_Enrichment;

require_once(__DIR__ . '/EnrichmentLookupBase.php');
require_once(__DIR__ . '/Result.php');

class Lookup extends EnrichmentLookupBase {
    protected ?string $smartyKey;
    protected ?string $freeform = null;
    protected ?string $street = null;
    protected ?string $city = null;
    protected ?string $state = null;
    protected ?string $zipcode = null;
    protected ?string $dataSetName;
    protected ?string $dataSubsetName;
    protected ?string $features = null;
    protected ?array $response = null;

    public function __construct(
        ?string $smartyKey = null,
        ?string $dataSetName = null,
        ?string $dataSubsetName = null,
        ?string $freeform = null,
        ?string $street = null,
        ?string $city = null,
        ?string $state = null,
        ?string $zipcode = null,
        ?array $include = null,
        ?array $exclude = null,
        ?string $features = null,
        ?string $requestEtag = null
    ) {
        $this->smartyKey = $smartyKey;
        $this->dataSetName = $dataSetName;
        $this->dataSubsetName = $dataSubsetName;
        $this->freeform = $freeform;
        $this->street = $street;
        $this->city = $city;
        $this->state = $state;
        $this->zipcode = $zipcode;
        $this->features = $features;
        $this->requestEtag = $requestEtag;
        if ($include !== null) {
            $this->include = $include;
        }
        if ($exclude !== null) {
            $this->exclude = $exclude;
        }
    }

    public function getSmartyKey(): ?string {
        return $this->smartyKey;
    }

    public function setSmartyKey(?string $smartyKey): void {
        $this->smartyKey = $smartyKey;
    }

    public function getFreeform(): ?string {
        return $this->freeform;
    }

    public function setFreeform(?string $freeform): void {
        $this->freeform = $freeform;
    }

    public function getStreet(): ?string {
        return $this->street;
    }

    public function setStreet(?string $street): void {
        $this->street = $street;
    }

    public function getCity(): ?string {
        return $this->city;
    }

    public function setCity(?string $city): void {
        $this->city = $city;
    }

    public function getState(): ?string {
        return $this->state;
    }

    public function setState(?string $state): void {
        $this->state = $state;
    }

    public function getZipcode(): ?string {
        return $this->zipcode;
    }

    public function setZipcode(?string $zipcode): void {
        $this->zipcode = $zipcode;
    }

    public function getDataSetName(): ?string {
        return $this->dataSetName;
    }

    public function setDataSetName(?string $dataSetName): void {
        $this->dataSetName = $dataSetName;
    }

    public function getDataSubsetName(): ?string {
        return $this->dataSubsetName;
    }

    public function setDataSubsetName(?string $dataSubsetName): void {
        $this->dataSubsetName = $dataSubsetName;
    }

    public function getFeatures(): ?string {
        return $this->features;
    }

    public function setFeatures(?string $features): void {
        $this->features = $features;
    }

    public function getResponse(): ?array {
        return $this->response;
    }

    public function setResponse(?array $response): void {
        $this->response = $response;
    }

    public function buildResults(?array $rawArray): void {
        if ($rawArray === null) {
            $this->response = [];
            return;
        }
        $response = [];
        foreach ($rawArray as $entry) {
            $response[] = new Result($entry);
        }
        $this->response = $response;
    }
}
