<?php

namespace SmartyStreets\PhpSdk\US_Enrichment;

abstract class EnrichmentLookupBase {
    protected array $include = [];
    protected array $exclude = [];
    protected array $customParamArray = [];
    protected ?string $requestEtag = null;
    protected ?string $responseEtag = null;

    public function getIncludeArray(): array {
        return $this->include;
    }

    public function setIncludeArray(array $include): void {
        $this->include = $include;
    }

    public function addIncludeAttribute(string $attribute): void {
        $this->include[] = $attribute;
    }

    public function getExcludeArray(): array {
        return $this->exclude;
    }

    public function setExcludeArray(array $exclude): void {
        $this->exclude = $exclude;
    }

    public function addExcludeAttribute(string $attribute): void {
        $this->exclude[] = $attribute;
    }

    public function getCustomParamArray(): array {
        return $this->customParamArray;
    }

    public function addCustomParameter(string $parameter, string $value): void {
        $this->customParamArray[$parameter] = $value;
    }

    public function getRequestEtag(): ?string {
        return $this->requestEtag;
    }

    public function setRequestEtag(?string $etag): void {
        $this->requestEtag = $etag;
    }

    public function getResponseEtag(): ?string {
        return $this->responseEtag;
    }

    public function setResponseEtag(?string $etag): void {
        $this->responseEtag = $etag;
    }

    /**
     * Build typed result objects from the decoded JSON payload and stash them on the lookup.
     * $rawArray is null or an array of associative arrays from the serializer.
     */
    abstract public function buildResults(?array $rawArray): void;
}
