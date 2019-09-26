<?php

namespace SmartyStreets\PhpSdk\International_Street;

require_once(dirname(dirname(__FILE__)) . '/ArrayUtil.php');
use SmartyStreets\PhpSdk\ArrayUtil;


class RootLevel {

    //region [fields]

    private $inputId,
        $organization,
        $address1,
        $address2,
        $address3,
        $address4,
        $address5,
        $address6,
        $address7,
        $address8,
        $address9,
        $address10,
        $address11,
        $address12;

    //endregion

    public function __construct($obj) {
        if ($obj == null)
            return;

        $this->inputId = ArrayUtil::setField($obj, 'input_id');
        $this->organization = ArrayUtil::setField($obj, 'organization');
        $this->address1 = ArrayUtil::setField($obj, 'address1');
        $this->address2 = ArrayUtil::setField($obj, 'address2');
        $this->address3 = ArrayUtil::setField($obj, 'address3');
        $this->address4 = ArrayUtil::setField($obj, 'address4');
        $this->address5 = ArrayUtil::setField($obj, 'address5');
        $this->address6 = ArrayUtil::setField($obj, 'address6');
        $this->address7 = ArrayUtil::setField($obj, 'address7');
        $this->address8 = ArrayUtil::setField($obj, 'address8');
        $this->address9 = ArrayUtil::setField($obj, 'address9');
        $this->address10 = ArrayUtil::setField($obj, 'address10');
        $this->address11 = ArrayUtil::setField($obj, 'address11');
        $this->address12 = ArrayUtil::setField($obj, 'address12');
    }

    //region [ Getters ]

    public function getInputId() {
        return $this->inputId;
    }

    public function getOrganization() {
        return $this->organization;
    }

    public function getAddress1() {
        return $this->address1;
    }

    public function getAddress2() {
        return $this->address2;
    }

    public function getAddress3() {
        return $this->address3;
    }

    public function getAddress4() {
        return $this->address4;
    }

    public function getAddress5() {
        return $this->address5;
    }

    public function getAddress6() {
        return $this->address6;
    }

    public function getAddress7() {
        return $this->address7;
    }

    public function getAddress8() {
        return $this->address8;
    }

    public function getAddress9() {
        return $this->address9;
    }

    public function getAddress10() {
        return $this->address10;
    }

    public function getAddress11() {
        return $this->address11;
    }

    public function getAddress12() {
        return $this->address12;
    }

    //endregion
}