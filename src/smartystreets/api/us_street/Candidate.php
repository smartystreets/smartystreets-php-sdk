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

    public function __construct($obj) {
        $this->inputIndex = $obj['input_index'];
        $this->candidateIndex = $obj['candidate_index'];
        $this->addressee = $obj['addressee'];
        $this->deliveryLine1 = $obj['delivery_line_1'];
        $this->deliveryLine2 = $obj['delivery_line_2'];
        $this->lastLine = $obj['last_line'];
        $this->deliveryPointBarcode = $obj['delivery_point_barcode'];
        $this->components = new Components(isset($obj['components']) ? $obj['components'] : array());
        $this->metadata = new Metadata(isset($obj['metadata']) ? $obj['metadata'] : array());
        $this->analysis = new Analysis(isset($obj['analysis']) ? $obj['analysis'] : array());
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