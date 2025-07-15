<?php

namespace SmartyStreets\PhpSdk\International_Street;

require_once(__DIR__ . '/Components.php');
require_once(__DIR__ . '/Metadata.php');
require_once(__DIR__ . '/Analysis.php');
require_once(__DIR__ . '/RootLevel.php');
require_once(__DIR__ . '/../ArrayUtil.php');
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
        if ($this->components === null) {
            $this->components = new Components([]);
        }
        return $this->components;
    }

    public function getMetadata() {
        if ($this->metadata === null) {
            $this->metadata = new Metadata([]);
        }
        return $this->metadata;
    }

    public function getAnalysis() {
        if ($this->analysis === null) {
            $this->analysis = new Analysis([]);
        }
        return $this->analysis;
    }


    //endregion
}