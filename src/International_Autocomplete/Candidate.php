<?php

namespace SmartyStreets\PhpSdk\International_Autocomplete;

require_once(__DIR__ . '/../ArrayUtil.php');
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
            $administrativeAreaShort,
            $administrativeAreaLong,
            $postalCode,
            $countryISO3,
            $entries,
            $address_text,
            $address_id;

    public function __construct($obj = null) {
        if ($obj == null)
            return;

        $this->street = ArrayUtil::setField($obj, 'street');
        $this->locality = ArrayUtil::setField($obj, 'locality');
        $this->administrativeArea = ArrayUtil::setField($obj, 'administrative_area');
        $this->administrativeAreaShort = ArrayUtil::setField($obj, 'administrative_area_short');
        $this->administrativeAreaLong = ArrayUtil::setField($obj, 'administrative_area_long');
        $this->postalCode = ArrayUtil::setField($obj, 'postal_code');
        $this->countryISO3 = ArrayUtil::setField($obj, 'country_iso3');
        $this->entries = ArrayUtil::setField($obj, 'entries');
        $this->address_text = ArrayUtil::setField($obj, 'address_text');
        $this->address_id = ArrayUtil::setField($obj, 'address_id');
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

    public function getAdministrativeAreaShort() {
        return $this->administrativeAreaShort;
    }

    public function getAdministrativeAreaLong() {
        return $this->administrativeAreaLong;
    }

    public function getPostalCode() {
        return $this->postalCode;
    }

    public function getCountryISO3() {
        return $this->countryISO3;
    }

    public function getEntries() {
        return $this->entries;
    }

    public function getAddressText() {
        return $this->address_text;
    }

    public function getAddressID() {
        return $this->address_id;
    }

    //endregion
}