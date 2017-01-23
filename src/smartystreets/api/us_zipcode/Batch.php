<?php

namespace smartystreets\api\us_zipcode;

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
            //throw new BatchFullException
        }

        $key = $lookup->getInputId();

        if ($key != null)
            $this->namedLookups[$key] = $lookup;

        $this->allLookups[] = $lookup;
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

    //public Iterator<Lookup> iterator() { return this.allLookups.iterator(); }

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