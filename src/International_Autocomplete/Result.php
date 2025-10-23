<?php

namespace SmartyStreets\PhpSdk\International_Autocomplete;

require_once(__DIR__ . '/../ArrayUtil.php');
require_once(__DIR__ . '/Candidate.php');
use SmartyStreets\PhpSdk\ArrayUtil;

class Result {
    private $candidates;

    public function __construct($obj = null) {
        if ($obj == null)
            return;

        $this->candidates = ArrayUtil::getField($obj, 'candidates', array());

        $this->candidates = $this->convertToCandidateObjects();
    }

    private function convertToCandidateObjects() {
        $candidateObjects = array();

        foreach ($this->candidates as $candidate)
            $candidateObjects[] = new Candidate($candidate);

        return $candidateObjects;
    }

    public function getCandidates() {
        return $this->candidates;
    }

    public function getCandidate($index) {
        return $this->candidates[$index];
    }
}