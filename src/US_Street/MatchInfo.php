<?php

namespace SmartyStreets\PhpSdk\US_Street;

require_once(dirname(dirname(__FILE__)) . '/ArrayUtil.php');
use SmartyStreets\PhpSdk\ArrayUtil;

class MatchInfo {
    private $status,
            $change;

    public function __construct($obj) {
        $this->status = ArrayUtil::setField($obj, 'status');
        $this->change = ArrayUtil::setField($obj, 'change');
    }

    public function getStatus() {
        return $this->status;
    }

    public function getChange() {
        return $this->change;
    }
}
