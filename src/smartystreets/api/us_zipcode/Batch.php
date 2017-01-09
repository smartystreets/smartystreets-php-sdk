<?php

namespace smartystreets\api\us_zipcode;

class Batch {

    const MAX_BATCH_SIZE = 100;
    private $nameLookups;
    private $allLookups;

    public function __construct() {
        $this->nameLookups = [];
        $this->allLookups = [];
    }



}