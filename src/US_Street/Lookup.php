<?php

namespace SmartyStreets\PhpSdk\US_Street;

/**
 * In addition to holding all of the input data for this lookup, this class also<br>
 *     will contain the result of the lookup after it comes back from the API.
 *     @see "https://smartystreets.com/docs/cloud/us-street-api#input-fields"
 */
class Lookup implements \JsonSerializable {
    //region [ Fields ]
    const STRICT = "strict";
    const RANGE = "range"; // Deprecated
    const INVALID = "invalid";
    const ENHANCED = "enhanced";

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

    /**
     * This constructor accepts a freeform address. That means the whole address is in one string.
     */
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

    /**
     * You can optionally put the entire address in the <b>street</b> field,<br>
     *     and leave the other fields blank. We call this a <b>freeform address</b>.<br>
     *     <i><b>Note:</b> Freeform addresses are slightly less reliable.</i>
     *
     *     @param $street string If using a freeform address, do <b>not</b> include country information
     */
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

    /**
     * Sets the match output strategy to be employed for this lookup.<br>
     *
     * @see "https://smartystreets.com/docs/cloud/us-street-api#input-fields"
     * @param $matchStrategy string The match output strategy
     */
    public function setMatchStrategy($matchStrategy) {
        if ($matchStrategy == self::ENHANCED && $this->maxCandidates == 1)
            $this->maxCandidates = 5;
        $this->matchStrategy = $matchStrategy;
    }

    /**
     * Sets the maximum number of valid addresses returned when the input is ambiguous.
     * @param $maxCandidates int Defaults to 1. Must be an integer between 1 and 10, inclusive.
     * @throws \InvalidArgumentException
     */
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