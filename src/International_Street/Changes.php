<?php

namespace SmartyStreets\PhpSdk\International_Street;

require_once (__DIR__ . '/RootLevel.php');
require_once (__DIR__ . '/Components.php');
require_once(__DIR__ . '/../ArrayUtil.php');
use SmartyStreets\PhpSdk\ArrayUtil;

class Changes extends RootLevel {

    //region [fields]

    private $country,
            $components;

    //endregion

    public function __construct($obj = null) {
        if ($obj == null)
            return;

        parent::__construct($obj);
        $this->country = ArrayUtil::getField($obj, 'country');
        $this->components = new Components(ArrayUtil::getField($obj, 'components'));
    }

    public function getCountry() {
        return $this->country;
    }

    public function getComponents() {
        return $this->components;
    }
}