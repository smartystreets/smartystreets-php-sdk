<?php

namespace SmartyStreets\PhpSdk\US_Extract;

require_once(__DIR__ . '/../ArrayUtil.php');
require_once(__DIR__ . '/../US_Street/Candidate.php');
use SmartyStreets\PhpSdk\ArrayUtil;
use SmartyStreets\PhpSdk\US_Street\Candidate;

/**
 * @see <a href="https://smartystreets.com/docs/cloud/us-extract-api#http-response-status">SmartyStreets US Extract API docs</a>
 */
class Address {
    private $text,
            $verified,
            $line,
            $start,
            $end,
            $candidates;

    public function __construct($obj = null) {
        if ($obj == null)
            return;

        $this->text = ArrayUtil::getField($obj, 'text');
        $this->verified = ArrayUtil::getField($obj, 'verified');
        $this->line = ArrayUtil::getField($obj, 'line');
        $this->start = ArrayUtil::getField($obj, 'start');
        $this->end = ArrayUtil::getField($obj, 'end');

        $this->candidates = ArrayUtil::getField($obj, 'api_output', array());
        $this->candidates = $this->convertToCandidateObjects();
    }

    private function convertToCandidateObjects() {
        $candidateObjects = array();

        foreach($this->candidates as $candidate)
            $candidateObjects[] = new Candidate($candidate);

        return $candidateObjects;
    }

    //region [ Getters ]

    public function getText() {
        return $this->text;
    }

    public function isVerified() {
        return $this->verified;
    }

    public function getLine() {
        return $this->line;
    }

    public function getStart() {
        return $this->start;
    }

    public function getEnd() {
        return $this->end;
    }

    public function getCandidates() {
        return $this->candidates;
    }

    public function getCandidate($index) {
        return $this->candidates[$index];
    }

    //endregion
}