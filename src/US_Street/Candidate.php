<?php

namespace SmartyStreets\PhpSdk\US_Street;

require_once('Components.php');
require_once('Metadata.php');
require_once('Analysis.php');
require_once(dirname(dirname(__FILE__)) . '/ArrayUtil.php');
use SmartyStreets\PhpSdk\ArrayUtil;

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

    public function __construct($obj = null) {
        if ($obj == null)
            return;

        $this->inputIndex = $obj['input_index'];
        $this->candidateIndex = $obj['candidate_index'];
        $this->addressee = ArrayUtil::setField($obj, 'addressee');
        $this->deliveryLine1 = ArrayUtil::setField($obj, 'delivery_line_1');
        $this->deliveryLine2 = ArrayUtil::setField($obj, 'delivery_line_2');
        $this->lastLine = ArrayUtil::setField($obj, 'last_line');
        $this->deliveryPointBarcode = ArrayUtil::setField($obj, 'delivery_point_barcode');

        $this->components = new Components(ArrayUtil::setField($obj, 'components', array()));
        $this->metadata = new Metadata(ArrayUtil::setField($obj, 'metadata', array()));
        $this->analysis = new Analysis(ArrayUtil::setField($obj, 'analysis', array()));
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