<?php

namespace SmartyStreets\PhpSdk\International_Street;

require_once ('RootLevel.php');
require_once ('Components.php');
require_once(dirname(dirname(__FILE__)) . '/ArrayUtil.php');
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