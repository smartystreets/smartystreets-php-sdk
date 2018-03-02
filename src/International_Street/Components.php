<?php

namespace SmartyStreets\PhpSdk\International_Street;

require_once(dirname(dirname(__FILE__)) . '/ArrayUtil.php');
use SmartyStreets\PhpSdk\ArrayUtil;

/**
 * @see "https://smartystreets.com/docs/cloud/international-street-api#components"
 */
class Components {
    //region [ Fields ]

    private $countryIso3,
            $superAdministrativeArea,
            $administrativeArea,
            $subAdministrativeArea,
            $dependentLocality,
            $dependentLocalityName,
            $doubleDependentLocality,
            $locality,
            $postalCode,
            $postalCodeShort,
            $postalCodeExtra,
            $premise,
            $premiseExtra,
            $premiseNumber,
            $premisePrefixNumber,
            $premiseType,
            $thoroughfare,
            $thoroughfarePredirection,
            $thoroughfarePostdirection,
            $thoroughfareName,
            $thoroughfareTrailingType,
            $thoroughfareType,
            $dependentThoroughfare,
            $dependentThoroughfarePredirection,
            $dependentThoroughfarePostdirection,
            $dependentThoroughfareName,
            $dependentThoroughfareTrailingType,
            $dependentThoroughfareType,
            $building,
            $buildingLeadingType,
            $buildingName,
            $buildingTrailingType,
            $subBuildingType,
            $subBuildingNumber,
            $subBuildingName,
            $subBuilding,
            $postBox,
            $postBoxType,
            $postBoxNumber;

    //endregion

    //region [ Constructor ]

    public function __construct($obj = null) {
        if ($obj == null)
            return;

        $this->countryIso3 = ArrayUtil::setField($obj,'country_iso_3');
        $this->superAdministrativeArea = ArrayUtil::setField($obj,'super_administrative_area');
        $this->administrativeArea = ArrayUtil::setField($obj,'administrative_area');
        $this->subAdministrativeArea = ArrayUtil::setField($obj,'sub_administrative_area');
        $this->dependentLocality = ArrayUtil::setField($obj,'dependent_locality');
        $this->dependentLocalityName = ArrayUtil::setField($obj,'dependent_locality_name');
        $this->doubleDependentLocality = ArrayUtil::setField($obj,'double_dependent_locality');
        $this->locality = ArrayUtil::setField($obj,'locality');
        $this->postalCode = ArrayUtil::setField($obj,'postal_code');
        $this->postalCodeShort = ArrayUtil::setField($obj,'postal_code_short');
        $this->postalCodeExtra = ArrayUtil::setField($obj,'postal_code_extra');
        $this->premise = ArrayUtil::setField($obj,'premise');
        $this->premiseExtra = ArrayUtil::setField($obj,'premise_extra');
        $this->premiseNumber = ArrayUtil::setField($obj,'premise_number');
        $this->premisePrefixNumber = ArrayUtil::setField($obj,'premise_prefix_number');
        $this->premiseType = ArrayUtil::setField($obj,'premise_type');
        $this->thoroughfare = ArrayUtil::setField($obj,'thoroughfare');
        $this->thoroughfarePredirection = ArrayUtil::setField($obj,'thoroughfare_predirection');
        $this->thoroughfarePostdirection = ArrayUtil::setField($obj,'thoroughfare_postdirection');
        $this->thoroughfareName = ArrayUtil::setField($obj,'thoroughfare_name');
        $this->thoroughfareTrailingType = ArrayUtil::setField($obj,'thoroughfare_trailing_type');
        $this->thoroughfareType = ArrayUtil::setField($obj,'thoroughfare_type');
        $this->dependentThoroughfare = ArrayUtil::setField($obj,'dependent_thoroughfare');
        $this->dependentThoroughfarePredirection = ArrayUtil::setField($obj,'dependent_thoroughfare_predirection');
        $this->dependentThoroughfarePostdirection = ArrayUtil::setField($obj,'dependent_thoroughfare_postdirection');
        $this->dependentThoroughfareName = ArrayUtil::setField($obj,'dependent_thoroughfare_name');
        $this->dependentThoroughfareTrailingType = ArrayUtil::setField($obj,'dependent_thoroughfare_trailing_type');
        $this->dependentThoroughfareType = ArrayUtil::setField($obj,'dependent_thoroughfare_type');
        $this->building = ArrayUtil::setField($obj,'building');
        $this->buildingLeadingType = ArrayUtil::setField($obj,'building_leading_type');
        $this->buildingName = ArrayUtil::setField($obj,'building_name');
        $this->buildingTrailingType = ArrayUtil::setField($obj,'building_trailing_type');
        $this->subBuildingType = ArrayUtil::setField($obj,'sub_building_type');
        $this->subBuildingNumber = ArrayUtil::setField($obj,'sub_building_number');
        $this->subBuildingName = ArrayUtil::setField($obj,'sub_building_name');
        $this->subBuilding = ArrayUtil::setField($obj,'sub_building');
        $this->postBox = ArrayUtil::setField($obj,'post_box');
        $this->postBoxType = ArrayUtil::setField($obj,'post_box_type');
        $this->postBoxNumber = ArrayUtil::setField($obj,'post_box_number');
    }

    //endregion

    //region [ Getters ]

    public function getCountryIso3() {
        return $this->countryIso3;
    }

    public function getSuperAdministrativeArea() {
        return $this->superAdministrativeArea;
    }

    public function getAdministrativeArea() {
        return $this->administrativeArea;
    }

    public function getSubAdministrativeArea() {
        return $this->subAdministrativeArea;
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

    public function getLocality() {
        return $this->locality;
    }

    public function getPostalCode() {
        return $this->postalCode;
    }

    public function getPostalCodeShort() {
        return $this->postalCodeShort;
    }

    public function getPostalCodeExtra() {
        return $this->postalCodeExtra;
    }

    public function getPremise() {
        return $this->premise;
    }

    public function getPremiseExtra() {
        return $this->premiseExtra;
    }

    public function getPremiseNumber() {
        return $this->premiseNumber;
    }

    public function getPremisePrefixNumber() {
        return $this->premisePrefixNumber;
    }

    public function getPremiseType() {
        return $this->premiseType;
    }

    public function getThoroughfare() {
        return $this->thoroughfare;
    }

    public function getThoroughfarePredirection() {
        return $this->thoroughfarePredirection;
    }

    public function getThoroughfarePostdirection() {
        return $this->thoroughfarePostdirection;
    }

    public function getThoroughfareName() {
        return $this->thoroughfareName;
    }

    public function getThoroughfareTrailingType() {
        return $this->thoroughfareTrailingType;
    }

    public function getThoroughfareType() {
        return $this->thoroughfareType;
    }

    public function getDependentThoroughfare() {
        return $this->dependentThoroughfare;
    }

    public function getDependentThoroughfarePredirection() {
        return $this->dependentThoroughfarePredirection;
    }

    public function getDependentThoroughfarePostdirection() {
        return $this->dependentThoroughfarePostdirection;
    }

    public function getDependentThoroughfareName() {
        return $this->dependentThoroughfareName;
    }

    public function getDependentThoroughfareTrailingType() {
        return $this->dependentThoroughfareTrailingType;
    }

    public function getDependentThoroughfareType() {
        return $this->dependentThoroughfareType;
    }

    public function getBuilding() {
        return $this->building;
    }

    public function getBuildingLeadingType() {
        return $this->buildingLeadingType;
    }

    public function getBuildingName() {
        return $this->buildingName;
    }

    public function getBuildingTrailingType() {
        return $this->buildingTrailingType;
    }

    public function getSubBuildingType() {
        return $this->subBuildingType;
    }

    public function getSubBuildingNumber() {
        return $this->subBuildingNumber;
    }

    public function getSubBuildingName() {
        return $this->subBuildingName;
    }

    public function getSubBuilding() {
        return $this->subBuilding;
    }

    public function getPostBox() {
        return $this->postBox;
    }

    public function getPostBoxType() {
        return $this->postBoxType;
    }

    public function getPostBoxNumber() {
        return $this->postBoxNumber;
    }

    //endregion
}