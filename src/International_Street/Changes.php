<?php

namespace SmartyStreets\PhpSdk\International_Street;

require_once (__DIR__ . '/RootLevel.php');
require_once (__DIR__ . '/Components.php');
require_once(__DIR__ . '/../ArrayUtil.php');
use SmartyStreets\PhpSdk\ArrayUtil;

class Changes extends RootLevel {

    //region [fields]

    private $components;

    //endregion

    public function __construct($obj = null) {
        if ($obj == null)
            return;

        parent::__construct($obj);
        $this->components = new Components(ArrayUtil::setField($obj, 'components'));
    }

    public function getComponents() {
        return $this->components;
    }
}