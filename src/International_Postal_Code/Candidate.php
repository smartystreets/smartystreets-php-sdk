<?php

namespace SmartyStreets\PhpSdk\International_Postal_Code;

require_once(__DIR__ . '/../ArrayUtil.php');
use SmartyStreets\PhpSdk\ArrayUtil;

/**
 * A candidate is a possible match for an address that was submitted.<br>
 *     A lookup can have multiple candidates if the address was ambiguous.
 *
 * @see "https://smartystreets.com/docs/international-postal-code-api"
 */
class Candidate {
    private $inputId,
            $administrativeArea,
            $subAdministrativeArea,
            $superAdministrativeArea,
            $countryIso3,
            $locality,
            $dependentLocality,
            $dependentLocalityName,
            $doubleDependentLocality,
            $postalCodeShort,
            $postalCodeExtra;

    public function __construct($obj = null) {
        if ($obj == null)
            return;

        $this->inputId = ArrayUtil::setField($obj, 'input_id');
        $this->administrativeArea = ArrayUtil::setField($obj, 'administrative_area');
        $this->subAdministrativeArea = ArrayUtil::setField($obj, 'sub_administrative_area');
        $this->superAdministrativeArea = ArrayUtil::setField($obj, 'super_administrative_area');
        $this->countryIso3 = ArrayUtil::setField($obj, 'country_iso_3');
        $this->locality = ArrayUtil::setField($obj, 'locality');
        $this->dependentLocality = ArrayUtil::setField($obj, 'dependent_locality');
        $this->dependentLocalityName = ArrayUtil::setField($obj, 'dependent_locality_name');
        $this->doubleDependentLocality = ArrayUtil::setField($obj, 'double_dependent_locality');
        $this->postalCodeShort = ArrayUtil::setField($obj, 'postal_code');
        $this->postalCodeExtra = ArrayUtil::setField($obj, 'postal_code_extra');
    }

    //region [ Getters ]

    public function getInputId() {
        return $this->inputId;
    }

    public function getAdministrativeArea() {
        return $this->administrativeArea;
    }

    public function getSubAdministrativeArea() {
        return $this->subAdministrativeArea;
    }

    public function getSuperAdministrativeArea() {
        return $this->superAdministrativeArea;
    }

    public function getCountryIso3() {
        return $this->countryIso3;
    }

    public function getLocality() {
        return $this->locality;
    }

    public function getDependentLocality() {
        return $this->dependentLocality;
    }

    public function getDependentLocalityName() {
        return $this->dependentLocalityName;
    }

    public function getDoubleDependentLocality() {
        return $this->doubleDependentLocality;
    }

    public function getPostalCodeShort() {
        return $this->postalCodeShort;
    }

    public function getPostalCodeExtra() {
        return $this->postalCodeExtra;
    }

    //endregion
}

