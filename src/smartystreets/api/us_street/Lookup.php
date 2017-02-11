<?php
namespace smartystreets\api\us_street;


class Lookup implements \JsonSerializable {
    //region [ Fields ]

    private $input_id,
            $street,
            $street2,
            $secondary,
            $city,
            $state,
            $zipcode,
            $lastline,
            $addressee,
            $urbanization,
            $match,
            $candidates,
            $result;

    //endregion

    public function __construct($street = null, $street2 = null, $secondary = null, $city = null, $state = null, $zipcode = null,
                                $lastline = null, $addressee = null, $urbanization = null, $match = null, $candidates = 1, $input_id = null) {
        $this->input_id = $input_id;
        $this->street = $street;
        $this->street2 = $street2;
        $this->secondary = $secondary;
        $this->city = $city;
        $this->state = $state;
        $this->zipcode = $zipcode;
        $this->lastline = $lastline;
        $this->addressee = $addressee;
        $this->urbanization = $urbanization;
        $this->match = $match;
        $this->candidates = $candidates;
        $this->result = array();
    }

    function jsonSerialize() {
        return array(
            'input_id' => $this->input_id,
            'street' => $this->street,
            'street2' => $this->street2,
            'secondary' => $this->secondary,
            'city' => $this->city,
            'state' => $this->state,
            'zipcode' => $this->zipcode,
            'lastline' => $this->lastline,
            'addressee' => $this->addressee,
            'urbanization' => $this->urbanization,
            'match' => $this->match,
            'candidates' => $this->candidates
        );
    }

    //region [ Getters ]

    public function getInputId() {
        return $this->input_id;
    }

    public function getStreet() {
        return $this->street;
    }

    public function getStreet2() {
        return $this->street2;
    }

    public function getSecondary() {
        return $this->secondary;
    }

    public function getCity() {
        return $this->city;
    }

    public function getState() {
        return $this->state;
    }

    public function getZipcode() {
        return $this->zipcode;
    }

    public function getLastline() {
        return $this->lastline;
    }

    public function getAddressee() {
        return $this->addressee;
    }

    public function getUrbanization() {
        return $this->urbanization;
    }

    public function getMatch() {
        return $this->match;
    }

    public function getCandidates() {
        return $this->candidates;
    }

    public function getResult() {
        return $this->result;
    }

    //endregion

    //region [ Setters ]

    public function setInputId($input_id) {
        $this->input_id = $input_id;
    }

    public function setStreet($street) {
        $this->street = $street;
    }

    public function setStreet2($street2) {
        $this->street2 = $street2;
    }

    public function setSecondary($secondary) {
        $this->secondary = $secondary;
    }

    public function setCity($city) {
        $this->city = $city;
    }

    public function setState($state) {
        $this->state = $state;
    }

    public function setZipcode($zipcode) {
        $this->zipcode = $zipcode;
    }

    public function setLastline($lastline) {
        $this->lastline = $lastline;
    }

    public function setAddressee($addressee) {
        $this->addressee = $addressee;
    }

    public function setUrbanization($urbanization) {
        $this->urbanization = $urbanization;
    }

    public function setMatch($match) {
        $this->match = $match;
    }

    public function setCandidates($candidates) {
        $this->candidates = $candidates;
    }

    public function setResult($result) {
        $this->result[] = $result;
    }

    //endregion
}