<?php

namespace SmartyStreets\US_Street;

class Analysis {
    private $dpvMatchCode,
            $dpvFootnotes,
            $cmra,
            $vacant,
            $active,
            $isEwsMatch,
            $footnotes,
            $lacsLinkCode,
            $lacsLinkIndicator,
            $isSuiteLinkMatch;

    public function __construct($obj) {
        $this->dpvMatchCode = $this->setField($obj, 'dpv_match_code');
        $this->dpvFootnotes = $this->setField($obj, 'dpv_footnotes');
        $this->cmra = $this->setField($obj, 'dpv_cmra');
        $this->vacant = $this->setField($obj, 'dpv_vacant');
        $this->active = $this->setField($obj, 'active');
        $this->isEwsMatch = $this->setField($obj, 'ews_match');
        $this->footnotes = $this->setField($obj, 'footnotes');
        $this->lacsLinkCode = $this->setField($obj, 'lacslink_code');
        $this->lacsLinkIndicator = $this->setField($obj, 'lacslink_indicator');
        $this->isSuiteLinkMatch = $this->setField($obj, 'suitelink_match');
    }

    private function setField($obj, $key, $typeIfKeyNotFound = null) { //TODO: try and put this in a single class
        if (isset($obj[$key]))
            return $obj[$key];
        else
            return $typeIfKeyNotFound;
    }

    //region [ Getters ]

    public function getDpvMatchCode() {
        return $this->dpvMatchCode;
    }

    public function getDpvFootnotes() {
        return $this->dpvFootnotes;
    }

    public function getCmra() {
        return $this->cmra;
    }

    public function getVacant() {
        return $this->vacant;
    }

    public function getActive() {
        return $this->active;
    }

    public function isEwsMatch() {
        return $this->isEwsMatch;
    }

    public function getFootnotes() {
        return $this->footnotes;
    }

    public function getLacsLinkCode() {
        return $this->lacsLinkCode;
    }

    public function getLacsLinkIndicator() {
        return $this->lacsLinkIndicator;
    }

    public function isSuiteLinkMatch() {
        return $this->isSuiteLinkMatch;
    }

    //endregion
}