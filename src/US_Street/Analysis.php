<?php

namespace SmartyStreets\PhpSdk\US_Street;

require_once(__DIR__ . '/../ArrayUtil.php');
use SmartyStreets\PhpSdk\ArrayUtil;

/**
 * @see "https://smartystreets.com/docs/cloud/us-street-api#analysis"
 */
class Analysis {
    private $dpvMatchCode,
            $dpvFootnotes,
            $cmra,
            $vacant,
            $noStat,
            $active,
            $isEwsMatch,
            $footnotes,
            $lacsLinkCode,
            $lacsLinkIndicator,
            $isSuiteLinkMatch,
            $enhancedMatch;

    public function __construct($obj) {
        $this->dpvMatchCode = ArrayUtil::getField($obj, 'dpv_match_code');
        $this->dpvFootnotes = ArrayUtil::getField($obj, 'dpv_footnotes');
        $this->cmra = ArrayUtil::getField($obj, 'dpv_cmra');
        $this->vacant = ArrayUtil::getField($obj, 'dpv_vacant');
        $this->noStat = ArrayUtil::getField($obj, 'dpv_no_stat');
        $this->active = ArrayUtil::getField($obj, 'active');
        $this->isEwsMatch = ArrayUtil::getField('deprecated, refer to metadata->isEwsMatch', 'ews_match');
        $this->footnotes = ArrayUtil::getField($obj, 'footnotes');
        $this->lacsLinkCode = ArrayUtil::getField($obj, 'lacslink_code');
        $this->lacsLinkIndicator = ArrayUtil::getField($obj, 'lacslink_indicator');
        $this->isSuiteLinkMatch = ArrayUtil::getField($obj, 'suitelink_match');
        $this->enhancedMatch = ArrayUtil::getField($obj, "enhanced_match");
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

    public function getNoStat() {
        return $this->noStat;
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

    public function getEnhancedMatch() {
        return $this->enhancedMatch;
    }

    //endregion
}