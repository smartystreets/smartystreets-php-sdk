<?php

namespace SmartyStreets\PhpSdk\International_Street;

require_once(__DIR__ . '/../ArrayUtil.php');
use SmartyStreets\PhpSdk\ArrayUtil;

/**
 * @see "https://smartystreets.com/docs/cloud/international-street-api#components"
 */
class Components {
    //region [ Fields ]

    private $countryIso3,
            $superAdministrativeArea,
            $administrativeArea,
            $administrativeAreaISO2,
            $administrativeAreaShort,
            $administrativeAreaLong,
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
            $levelType,
            $levelNumber,
            $postBox,
            $postBoxType,
            $postBoxNumber,
            $additionalContent,
            $deliveryInstallation,
            $deliveryInstallationType,
            $deliveryInstallationQualifierName,
            $route,
            $routeNumber,
            $routeType;

    //endregion

    //region [ Constructor ]

    public function __construct($obj = null) {
        if ($obj == null)
            return;

        $this->countryIso3 = ArrayUtil::getField($obj,'country_iso_3');
        $this->superAdministrativeArea = ArrayUtil::getField($obj,'super_administrative_area');
        $this->administrativeArea = ArrayUtil::getField($obj,'administrative_area');
        $this->administrativeAreaISO2 = ArrayUtil::getField($obj,'administrative_area_iso2');
        $this->administrativeAreaShort = ArrayUtil::getField($obj,'administrative_area_short');
        $this->administrativeAreaLong = ArrayUtil::getField($obj,'administrative_area_long');
        $this->subAdministrativeArea = ArrayUtil::getField($obj,'sub_administrative_area');
        $this->dependentLocality = ArrayUtil::getField($obj,'dependent_locality');
        $this->dependentLocalityName = ArrayUtil::getField($obj,'dependent_locality_name');
        $this->doubleDependentLocality = ArrayUtil::getField($obj,'double_dependent_locality');
        $this->locality = ArrayUtil::getField($obj,'locality');
        $this->postalCode = ArrayUtil::getField($obj,'postal_code');
        $this->postalCodeShort = ArrayUtil::getField($obj,'postal_code_short');
        $this->postalCodeExtra = ArrayUtil::getField($obj,'postal_code_extra');
        $this->premise = ArrayUtil::getField($obj,'premise');
        $this->premiseExtra = ArrayUtil::getField($obj,'premise_extra');
        $this->premiseNumber = ArrayUtil::getField($obj,'premise_number');
        $this->premisePrefixNumber = ArrayUtil::getField($obj,'premise_prefix_number');
        $this->premiseType = ArrayUtil::getField($obj,'premise_type');
        $this->thoroughfare = ArrayUtil::getField($obj,'thoroughfare');
        $this->thoroughfarePredirection = ArrayUtil::getField($obj,'thoroughfare_predirection');
        $this->thoroughfarePostdirection = ArrayUtil::getField($obj,'thoroughfare_postdirection');
        $this->thoroughfareName = ArrayUtil::getField($obj,'thoroughfare_name');
        $this->thoroughfareTrailingType = ArrayUtil::getField($obj,'thoroughfare_trailing_type');
        $this->thoroughfareType = ArrayUtil::getField($obj,'thoroughfare_type');
        $this->dependentThoroughfare = ArrayUtil::getField($obj,'dependent_thoroughfare');
        $this->dependentThoroughfarePredirection = ArrayUtil::getField($obj,'dependent_thoroughfare_predirection');
        $this->dependentThoroughfarePostdirection = ArrayUtil::getField($obj,'dependent_thoroughfare_postdirection');
        $this->dependentThoroughfareName = ArrayUtil::getField($obj,'dependent_thoroughfare_name');
        $this->dependentThoroughfareTrailingType = ArrayUtil::getField($obj,'dependent_thoroughfare_trailing_type');
        $this->dependentThoroughfareType = ArrayUtil::getField($obj,'dependent_thoroughfare_type');
        $this->building = ArrayUtil::getField($obj,'building');
        $this->buildingLeadingType = ArrayUtil::getField($obj,'building_leading_type');
        $this->buildingName = ArrayUtil::getField($obj,'building_name');
        $this->buildingTrailingType = ArrayUtil::getField($obj,'building_trailing_type');
        $this->subBuildingType = ArrayUtil::getField($obj,'sub_building_type');
        $this->subBuildingNumber = ArrayUtil::getField($obj,'sub_building_number');
        $this->subBuildingName = ArrayUtil::getField($obj,'sub_building_name');
        $this->subBuilding = ArrayUtil::getField($obj,'sub_building');
        $this->levelType = ArrayUtil::getField($obj,'level_type');
        $this->levelNumber = ArrayUtil::getField($obj,'level_number');
        $this->postBox = ArrayUtil::getField($obj,'post_box');
        $this->postBoxType = ArrayUtil::getField($obj,'post_box_type');
        $this->postBoxNumber = ArrayUtil::getField($obj,'post_box_number');
        $this->additionalContent = ArrayUtil::getField($obj,'additional_content');
        $this->deliveryInstallation = ArrayUtil::getField($obj,'delivery_installation');
        $this->deliveryInstallationType = ArrayUtil::getField($obj,'delivery_installation_type');
        $this->deliveryInstallationQualifierName = ArrayUtil::getField($obj,'delivery_installation_qualifier_name');
        $this->route = ArrayUtil::getField($obj,'route');
        $this->routeNumber = ArrayUtil::getField($obj,'route_number');
        $this->routeType = ArrayUtil::getField($obj,'route_type');
    }

    //endregion

    //region [ Getters ]

    public function getAdditionalContent() {
        return $this->additionalContent;
    }

    public function getDeliveryInstallation() {
        return $this->deliveryInstallation;
    }
    
    public function getDeliveryInstallationType() {
        return $this->deliveryInstallationType;
    }
    
    public function getDeliveryInstallationQualifierName() {
        return $this->deliveryInstallationQualifierName;
    }
    
    public function getRoute() {
        return $this->route;
    }
    
    public function getRouteNumber() {
        return $this->routeNumber;
    }
    
    public function getRouteType() {
        return $this->routeType;
    }
    
    public function getCountryIso3() {
        return $this->countryIso3;
    }

    public function getSuperAdministrativeArea() {
        return $this->superAdministrativeArea;
    }

    public function getAdministrativeArea() {
        return $this->administrativeArea;
    }

    public function getAdministrativeAreaISO2() {
        return $this->administrativeAreaISO2;
    }

    public function getAdministrativeAreaShort() {
        return $this->administrativeAreaShort;
    }

    public function getAdministrativeAreaLong() {
        return $this->administrativeAreaLong;
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

    public function getLevelType() {
        return $this->levelType;
    }

    public function getLevelNumber() {
        return $this->levelNumber;
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