<?php


namespace smartystreets\api\us_street;

require_once('Components.php');
require_once('Metadata.php');
require_once('Analysis.php');


class Candidate {
    private $input_index,
            $candidate_index,
            $addressee,
            $delivery_line_1,
            $delivery_line_2,
            $delivery_point_barcode,
            $last_line,
            $metadata,
            $components,
            $analysis;

    public function __construct($obj) {
        $this->input_index = $obj['input_index'];
        $this->candidate_index = $obj['candidate_index'];
        $this->addressee = $obj['addressee'];
        $this->delivery_line_1 = $obj['delivery_line_1'];
        $this->delivery_line_2 = $obj['delivery_line_2'];
        $this->last_line = $obj['last_line'];
        $this->delivery_point_barcode = $obj['delivery_point_barcode'];
        $this->components = new Components(isset($obj['components']) ? $obj['components'] : array());
        $this->metadata = new Metadata(isset($obj['metadata']) ? $obj['metadata'] : array());
        $this->analysis = new Analysis(isset($obj['analysis']) ? $obj['analysis'] : array());
    }

    //region [Getters]

    public function getInputIndex() {
        return $this->input_index;
    }


    public function getCandidateIndex() {
        return $this->candidate_index;
    }


    public function getAddressee() {
        return $this->addressee;
    }


    public function getDeliveryLine1() {
        return $this->delivery_line_1;
    }


    public function getDeliveryLine2() {
        return $this->delivery_line_2;
    }


    public function getDeliveryPointBarcode() {
        return $this->delivery_point_barcode;
    }


    public function getLastLine() {
        return $this->last_line;
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