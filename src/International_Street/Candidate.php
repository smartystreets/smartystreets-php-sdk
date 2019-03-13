<?php

namespace SmartyStreets\PhpSdk\International_Street;

require_once('Components.php');
require_once('Metadata.php');
require_once('Analysis.php');
require_once('RootLevel.php');
require_once(dirname(dirname(__FILE__)) . '/ArrayUtil.php');
use SmartyStreets\PhpSdk\ArrayUtil;

/**
 * A candidate is a possible match for an address that was submitted.<br>
 *     A lookup can have multiple candidates if the address was ambiguous.
 *
 * @see "https://smartystreets.com/docs/cloud/international-street-api#root"
 */
class Candidate extends RootLevel {

    //region [ Fields ]

    private $components,
        $metadata,
        $analysis;

    //endregion

    public function __construct($obj = null) {
        if ($obj == null)
            return;

        parent::__construct($obj);
        $this->components = new Components(ArrayUtil::setField($obj, 'components', array()));
        $this->metadata = new Metadata(ArrayUtil::setField($obj, 'metadata', array()));
        $this->analysis = new Analysis(ArrayUtil::setField($obj, 'analysis', array()));

    }

    //region [ Getters ]


    public function getComponents() {
        return $this->components;
    }

    public function getMetadata() {
        return $this->metadata;
    }

    public function getAnalysis() {
        return $this->analysis;
    }


    //endregion
}