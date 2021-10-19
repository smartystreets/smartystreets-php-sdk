<?php

namespace SmartyStreets\PhpSdk\International_Autocomplete;

require_once(dirname(dirname(__FILE__)) . '/ArrayUtil.php');
use SmartyStreets\PhpSdk\ArrayUtil;

/**
 * A candidate is a possible match for an address that was submitted.<br>
 *     A lookup can have multiple candidates if the address was ambiguous, and<br>
 *     the maxCandidates field is set higher than 1.
 *
 * @see "https://smartystreets.com/docs/cloud/international-address-autocomplete"
 */
class Candidate {
    private $street,
            $locality,
            $administrativeArea,
            $postalCode,
            $countryISO3;

    public function __construct($obj = null) {
        if ($obj == null)
            return;

        $this->street = ArrayUtil::setField($obj, 'street');
        $this->locality = ArrayUtil::setField($obj, 'locality');
        $this->administrativeArea = ArrayUtil::setField($obj, 'administrative_area');
        $this->postalCode = ArrayUtil::setField($obj, 'postal_code');
        $this->countryISO3 = ArrayUtil::setField($obj, 'country_iso3');
    }

    //region [Getters]

    public function getStreet() {
        return $this->street;
    }

    public function getLocality() {
        return $this->locality;
    }

    public function getAdministrativeArea() {
        return $this->administrativeArea;
    }

    public function getPostalCode() {
        return $this->postalCode;
    }

    public function getCountryISO3() {
        return $this->countryISO3;
    }

    //endregion
}