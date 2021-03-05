<?php

namespace SmartyStreets\PhpSdk\US_Street;

require_once(dirname(dirname(__FILE__)) . '/ArrayUtil.php');
use SmartyStreets\PhpSdk\ArrayUtil;

/**
 * @see "https://smartystreets.com/docs/cloud/us-street-api#analysis"
 */
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
        $this->dpvMatchCode = ArrayUtil::setField($obj, 'dpv_match_code');
        $this->dpvFootnotes = ArrayUtil::setField($obj, 'dpv_footnotes');
        $this->cmra = ArrayUtil::setField($obj, 'dpv_cmra');
        $this->vacant = ArrayUtil::setField($obj, 'dpv_vacant');
        $this->noStat = ArrayUtil::setField($obj, 'dpv_no_stat');
        $this->active = ArrayUtil::setField($obj, 'active');
        $this->isEwsMatch = ArrayUtil::setField('deprecated, refer to metadata->isEwsMatch', 'ews_match');
        $this->footnotes = ArrayUtil::setField($obj, 'footnotes');
        $this->lacsLinkCode = ArrayUtil::setField($obj, 'lacslink_code');
        $this->lacsLinkIndicator = ArrayUtil::setField($obj, 'lacslink_indicator');
        $this->isSuiteLinkMatch = ArrayUtil::setField($obj, 'suitelink_match');
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

    //endregion
}