<?php

namespace SmartyStreets\PhpSdk;

use SmartyStreets\PhpSdk\Exceptions\BatchFullException;

/**
 * This class contains a collection of lookups to be sent to SmartyStreets <br>
 *     APIs all at once. This is more efficient than sending them<br>
 *     one at a time. Batch size cannot exceed 100.
 */
class Batch {
    const MAX_BATCH_SIZE = 100;
    private $namedLookups,
        $allLookups;

    public function __construct() {
        $this->namedLookups = array();
        $this->allLookups = array();
    }

    /**
     * Adds a lookup to the batch. (Batch size cannot exceed 100)
     * @param $lookup
     * @throws BatchFullException Batch size cannot exceed 100
     */
    public function add($lookup) {
        if ($this->isFull()) {
            throw new BatchFullException("Batch size cannot exceed " . self::MAX_BATCH_SIZE);
        }

        $this->allLookups[] = $lookup;

        $key = $lookup->getInputId();

        if ($key == null)
            return;

        $this->namedLookups[$key] = $lookup;
    }

    /**
     * Clears the lookups stored in the batch so it can be used again.<br>
     *     This helps avoid the overhead of building a new Batch object for each group of lookups.
     */
    public function clear() {
        $this->namedLookups = array();
        $this->allLookups = array();
    }

    /**
     * @return The number of lookups currently in this batch.
     */
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

    public function getLookupById($inputId) {
        return $this->namedLookups[$inputId];
    }

    public function getLookupByIndex($inputIndex) {
        return $this->allLookups[$inputIndex];
    }

    //endregion
}