<?php

namespace SmartyStreets\PhpSdk\International_Postal_Code;

require_once(__DIR__ . '/../ArrayUtil.php');
use SmartyStreets\PhpSdk\ArrayUtil;

/**
 * A candidate is a possible match for a postal code lookup that was submitted.<br>
 *     A lookup can have multiple candidates if the postal code was ambiguous.
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

        $this->inputId = ArrayUtil::getField($obj, 'input_id');
        $this->administrativeArea = ArrayUtil::getField($obj, 'administrative_area');
        $this->subAdministrativeArea = ArrayUtil::getField($obj, 'sub_administrative_area');
        $this->superAdministrativeArea = ArrayUtil::getField($obj, 'super_administrative_area');
        $this->countryIso3 = ArrayUtil::getField($obj, 'country_iso_3');
        $this->locality = ArrayUtil::getField($obj, 'locality');
        $this->dependentLocality = ArrayUtil::getField($obj, 'dependent_locality');
        $this->dependentLocalityName = ArrayUtil::getField($obj, 'dependent_locality_name');
        $this->doubleDependentLocality = ArrayUtil::getField($obj, 'double_dependent_locality');
        $this->postalCodeShort = ArrayUtil::getField($obj, 'postal_code');
        $this->postalCodeExtra = ArrayUtil::getField($obj, 'postal_code_extra');
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

