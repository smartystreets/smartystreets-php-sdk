<?php

namespace SmartyStreets\US_Street;

class Lookup implements \JsonSerializable {
    //region [ Fields ]
    const STRICT = "strict";
    const RANGE = "range";
    const INVALID = "invalid";

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
            $matchStrategy,
            $maxCandidates,
            $result;

    //endregion

    public function __construct($street = null, $street2 = null, $secondary = null, $city = null, $state = null, $zipcode = null,
                                $lastline = null, $addressee = null, $urbanization = null, $matchStrategy = null, $maxCandidates = 1, $input_id = null) {
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
        $this->matchStrategy = $matchStrategy;
        $this->maxCandidates = $maxCandidates;
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
            'match' => $this->matchStrategy,
            'candidates' => $this->maxCandidates
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

    public function getMatchStrategy() {
        return $this->matchStrategy;
    }

    public function getMaxCandidates() {
        return $this->maxCandidates;
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

    public function setMatchStrategy($matchStrategy) {
        $this->matchStrategy = $matchStrategy;
    }

    public function setMaxCandidates($maxCandidates) {
        if ($maxCandidates > 0)
            $this->maxCandidates = $maxCandidates;
        else
            throw new \InvalidArgumentException("Max candidates must be a positive integer.");
    }

    public function setResult($result) {
        $this->result[] = $result;
    }

    //endregion
}