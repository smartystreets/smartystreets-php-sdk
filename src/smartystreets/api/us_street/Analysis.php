<?php


namespace smartystreets\api\us_street;


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
        $this->dpvMatchCode = $obj['dpv_match_code'];
      $this->dpvFootnotes = $obj['dpv_footnotes'];
      $this->cmra = $obj['dpv_cmra'];
      $this->vacant = $obj['dpv_vacant'];
      $this->active = $obj['active'];
      $this->isEwsMatch = $obj['ews_match'];
      $this->footnotes = $obj['footnotes'];
      $this->lacsLinkCode = $obj['lacslink_code'];
      $this->lacsLinkIndicator = $obj['lacslink_indicator'];
      $this->isSuiteLinkMatch = $obj['suitelink_match'];
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