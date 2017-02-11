<?php

namespace smartystreets\api\us_street;

require_once('Components.php');
require_once('Metadata.php');
require_once('Analysis.php');

class Candidate {
    private $inputIndex,
            $candidateIndex,
            $addressee,
            $deliveryLine1,
            $deliveryLine2,
            $deliveryPointBarcode,
            $lastLine,
            $metadata,
            $components,
            $analysis;

    public function __construct() {
        $argv = func_get_args();
        $i = func_num_args();
        if (method_exists($this, $f = '__construct' . $i)) {
            call_user_func_array(array($this, $f), $argv);
        }
    }

    public function __construct1($obj) {
        $this->inputIndex = $obj['input_index'];
        $this->candidateIndex = $obj['candidate_index'];
        $this->addressee = $this->setField($obj, 'addressee');
        $this->deliveryLine1 = $this->setField($obj, 'delivery_line_1');
        $this->deliveryLine2 = $this->setField($obj, 'delivery_line_2');
        $this->lastLine = $this->setField($obj, 'last_line');
        $this->deliveryPointBarcode = $this->setField($obj, 'delivery_point_barcode');

        $this->components = new Components($this->setField($obj, 'components', array()));
        $this->metadata = new Metadata($this->setField($obj, 'metadata', array()));
        $this->analysis = new Analysis($this->setField($obj, 'analysis', array()));
    }

    private function setField($obj, $key, $typeIfKeyNotFound = null) {
        if (isset($obj[$key]))
            return $obj[$key];
        else
            return $typeIfKeyNotFound;
    }

    //region [Getters]

    public function getInputIndex() {
        return $this->inputIndex;
    }

    public function getCandidateIndex() {
        return $this->candidateIndex;
    }

    public function getAddressee() {
        return $this->addressee;
    }

    public function getDeliveryLine1() {
        return $this->deliveryLine1;
    }

    public function getDeliveryLine2() {
        return $this->deliveryLine2;
    }

    public function getDeliveryPointBarcode() {
        return $this->deliveryPointBarcode;
    }

    public function getLastLine() {
        return $this->lastLine;
    }

    public function getMetadata() {
        return $this->metadata;
    }

    public function getComponents() {
        return $this->components;
    }

    public function getAnalysis() {
        return $this->analysis;
    }

    //endregion
}