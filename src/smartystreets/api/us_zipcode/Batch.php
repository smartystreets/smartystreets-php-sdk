<?php

namespace smartystreets\api\us_zipcode;

use smartystreets\api\exceptions\BatchFullException;

class Batch {

    const MAX_BATCH_SIZE = 100;
    private $namedLookups,
            $allLookups;

    public function __construct() {
        $this->namedLookups = array();
        $this->allLookups = array();
    }

    public function add(Lookup $lookup) {
        if ($this->isFull()) {
            throw new BatchFullException("Batch size cannot exceed " . self::MAX_BATCH_SIZE);
        }

        $this->allLookups[] = $lookup;

        $key = $lookup->getInputId();

        if ($key == null)
            return true;

        $this->namedLookups[$key] = $lookup;

        return true;
    }

    public function clear() {
        $this->namedLookups = array();
        $this->allLookups = array();
    }

    public function size() {
        return count($this->allLookups);
    }

    public function isFull() {
        return ($this->size() >= self::MAX_BATCH_SIZE);
    }

    //region [ Getters ]

    public function getNamedLookups()
    {
        return $this->namedLookups;
    }

    public function getAllLookups()
    {
        return $this->allLookups;
    }

    public function getLookupById($inputId) { //TODO: try and make it batch["id"] instead of batch->getLookupById("id");
        return $this->namedLookups[$inputId];
    }

    public function getLookupByIndex($inputIndex) { //TODO: try and make it batch[1] instead of batch->getLookupByIndex(1);
        return $this->allLookups[$inputIndex];
    }

    //endregion
}