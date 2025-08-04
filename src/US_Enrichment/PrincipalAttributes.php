<?php

namespace SmartyStreets\PhpSdk\US_Enrichment;
use SmartyStreets\PhpSdk\ArrayUtil;

class PrincipalAttributes {

    //region [ Fields ]

    public $firstFloorSqft,
    $secondFloorSqft,
    $acres,
    $airConditioner,
    $arborPergola,
    $assessedImprovementPercent,
    $assessedImprovementValue,
    $assessedLandValue,
    $assessedValue,
    $assessorLastUpdate,
    $assessorTaxrollUpdate,
    $atticArea,
    $atticFlag,
    $balcony,
    $balconyArea,
    $basementSqft,
    $basementSqftFinished,
    $basementSqftUnfinished,
    $bathHouse,
    $bathHouseSqft,
    $bathroomsPartial,
    $bathroomsTotal,
    $bedrooms,
    $block1,
    $block2,
    $boatAccess,
    $boatHouse,
    $boatHouseSqft,
    $boatLift,
    $bonusRoom,
    $breakfastNook,
    $breezeway,
    $buildingDefinitionCode,
    $buildingSqft,
    $cabin,
    $cabinSqft,
    $canopy,
    $canopySqft,
    $carport,
    $carportSqft,
    $cbsaCode,
    $cbsaName,
    $cellar,
    $censusBlock,
    $censusBlockGroup,
    $censusFipsPlaceCode,
    $censusTract,
    $centralVacuum,
    $codeTitleCompany,
    $combinedStatisticalArea,
    $communityRec,
    $companyFlag,
    $congressionalDistrict,
    $constructionType,
    $contactCity,
    $contactCrrt,
    $contactFullAddress,
    $contactHouseNumber,
    $contactMailInfoFormat,
    $contactMailInfoPrivacy,
    $contactMailingCounty,
    $contactMailingFips,
    $contactPostDirection,
    $contactPreDirection,
    $contactState,
    $contactStreetName,
    $contactSuffix,
    $contactUnitDesignator,
    $contactValue,
    $contactZip,
    $contactZip4,
    $courtyard,
    $courtyardArea,
    $deck,
    $deckArea,
    $deedDocumentPage,
    $deedDocumentBook,
    $deedDocumentNumber,
    $deedOwnerFirstName,
    $deedOwnerFirstName2,
    $deedOwnerFirstName3,
    $deedOwnerFirstName4,
    $deedOwnerFullName,
    $deedOwnerFullName2,
    $deedOwnerFullName3,
    $deedOwnerFullName4,
    $deedOwnerLastName,
    $deedOwnerLastName2,
    $deedOwnerLastName3,
    $deedOwnerLastName4,
    $deedOwnerMiddleName,
    $deedOwnerMiddleName2,
    $deedOwnerMiddleName3,
    $deedOwnerMiddleName4,
    $deedOwnerSuffix,
    $deedOwnerSuffix2,
    $deedOwnerSuffix3,
    $deedOwnerSuffix4,
    $deedSaleDate,
    $deedSalePrice,
    $deedTransactionId,
    $depthLinearFootage,
    $disabledTaxExemption,
    $documentTypeDescription,
    $drivewaySqft,
    $drivewayType,
    $effectiveYearBuilt,
    $elevationFeet,
    $elevator,
    $equestrianArena,
    $escalator,
    $exerciseRoom,
    $exteriorWalls,
    $familyRoom,
    $fence,
    $fenceArea,
    $fipsCode,
    $fireResistanceCode,
    $fireSprinklersFlag,
    $fireplace,
    $fireplaceNumber,
    $firstName,
    $firstName2,
    $firstName3,
    $firstName4,
    $flooring,
    $foundation,
    $gameRoom,
    $garage,
    $garageSqft,
    $gazebo,
    $gazeboSqft,
    $golfCourse,
    $grainery,
    $grainerySqft,
    $greatRoom,
    $greenhouse,
    $greenhouseSqft,
    $grossSqft,
    $guesthouse,
    $guesthouseSqft,
    $handicapAccessibility,
    $heat,
    $heatFuelType,
    $hobbyRoom,
    $homeownerTaxExemption,
    $instrumentDate,
    $intercomSystem,
    $interestRateType2,
    $interiorStructure,
    $kennel,
    $kennelSqft,
    $landUseCode,
    $landUseGroup,
    $landUseStandard,
    $lastName,
    $lastName2,
    $lastName3,
    $lastName4,
    $latitude,
    $laundry,
    $leanTo,
    $leanToSqft,
    $legalDescription,
    $legalUnit,
    $lenderAddress,
    $lenderAddress2,
    $lenderCity,
    $lenderCity2,
    $lenderCode2,
    $lenderFirstName,
    $lenderFirstName2,
    $lenderLastName,
    $lenderLastName2,
    $lenderName,
    $lenderName2,
    $lenderSellerCarryBack,
    $lenderSellerCarryBack2,
    $lenderState,
    $lenderState2,
    $lenderZip,
    $lenderZip2,
    $lenderZipExtended,
    $lenderZipExtended2,
    $loadingPlatform,
    $loadingPlatformSqft,
    $longitude,
    $lot1,
    $lot2,
    $lot3,
    $lotSqft,
    $marketImprovementPercent,
    $marketImprovementValue,
    $marketLandValue,
    $marketValueYear,
    $matchType,
    $mediaRoom,
    $metroDivision,
    $middleName,
    $middleName2,
    $middleName3,
    $middleName4,
    $milkhouse,
    $milkhouseSqft,
    $minorCivilDivisionCode,
    $minorCivilDivisionName,
    $mobileHomeHookup,
    $mortgageAmount,
    $mortgageAmount2,
    $mortgageDueDate,
    $mortgageDueDate2,
    $mortgageInterestRate,
    $mortgageInterestRateType,
    $mortgageLenderCode,
    $mortgageRate2,
    $mortgageRecordingDate,
    $mortgageRecordingDate2,
    $mortgageTerm,
    $mortgageTerm2,
    $mortgageTermType,
    $mortgageTermType2,
    $mortgageType,
    $mortgageType2,
    $msaCode,
    $msaName,
    $mudRoom,
    $multiParcelFlag,
    $nameTitleCompany,
    $neighborhoodCode,
    $numberOfBuildings,
    $office,
    $officeSqft,
    $otherTaxExemption,
    $outdoorKitchenFireplace,
    $overheadDoor,
    $ownerFullName,
    $ownerFullName2,
    $ownerFullName3,
    $ownerFullName4,
    $ownerOccupancyStatus,
    $ownershipTransferDate,
    $ownershipTransferDocNumber,
    $ownershipTransferTransactionId,
    $ownershipType,
    $ownershipType2,
    $ownershipVestingRelationCode,
    $parcelAccountNumber,
    $parcelMapBook,
    $parcelMapPage,
    $parcelNumberAlternate,
    $parcelNumberFormatted,
    $parcelNumberPrevious,
    $parcelNumberYearAdded,
    $parcelNumberYearChange,
    $parcelRawNumber,
    $parcelShellRecord,
    $parkingSpaces,
    $patioArea,
    $phaseName,
    $plumbingFixturesCount,
    $poleStruct,
    $poleStructSqft,
    $pond,
    $pool,
    $poolArea,
    $poolhouse,
    $poolhouseSqft,
    $porch,
    $porchArea,
    $poultryHouse,
    $poultryHouseSqft,
    $previousAssessedValue,
    $priorSaleAmount,
    $priorSaleDate,
    $propertyAddressCarrierRouteCode,
    $propertyAddressCity,
    $propertyAddressFull,
    $propertyAddressHouseNumber,
    $propertyAddressPostDirection,
    $propertyAddressPreDirection,
    $propertyAddressState,
    $propertyAddressStreetName,
    $propertyAddressStreetSuffix,
    $propertyAddressUnitDesignator,
    $propertyAddressUnitValue,
    $propertyAddressZip4,
    $propertyAddressZipcode,
    $publicationDate,
    $quarter,
    $quarterQuarter,
    $quonset,
    $quonsetSqft,
    $range,
    $recordingDate,
    $roofCover,
    $roofFrame,
    $rooms,
    $rvParking,
    $safeRoom,
    $saleAmount,
    $saleDate,
    $sauna,
    $section,
    $securityAlarm,
    $seniorTaxExemption,
    $sewerType,
    $shed,
    $shedSqft,
    $silo,
    $siloSqft,
    $sittingRoom,
    $situsCounty,
    $situsState,
    $soundSystem,
    $sportsCourt,
    $sprinklers,
    $stable,
    $stableSqft,
    $storageBuilding,
    $storageBuildingSqft,
    $storiesNumber,
    $stormShelter,
    $stormShutter,
    $structureStyle,
    $study,
    $subdivision,
    $suffix,
    $suffix2,
    $suffix3,
    $suffix4,
    $sunroom,
    $taxAssessYear,
    $taxBilledAmount,
    $taxDelinquentYear,
    $taxFiscalYear,
    $taxJurisdiction,
    $taxRateArea,
    $tennisCourt,
    $topographyCode,
    $totalMarketValue,
    $township,
    $tractNumber,
    $transferAmount,
    $trustDescription,
    $unitCount,
    $upperFloorsSqft,
    $utility,
    $utilityBuilding,
    $utilityBuildingSqft,
    $utilitySqft,
    $veteranTaxExemption,
    $viewDescription,
    $waterFeature,
    $waterServiceType,
    $wetBar,
    $widowTaxExemption,
    $widthLinearFootage,
    $wineCellar,
    $yearBuilt,
    $zoning;

    //endregion

    public function __construct($obj = null) {
        $this->firstFloorSqft = ArrayUtil::getField($obj, "1st_floor_sqft");
        $this->secondFloorSqft = ArrayUtil::getField($obj, "2nd_floor_sqft");
        $this->acres = ArrayUtil::getField($obj, "acres");
        $this->airConditioner = ArrayUtil::getField($obj, "air_conditioner");
        $this->arborPergola = ArrayUtil::getField($obj, "arbor_pergola");
        $this->assessedImprovementPercent = ArrayUtil::getField($obj, "assessed_improvement_percent");
        $this->assessedImprovementValue = ArrayUtil::getField($obj, "assessed_improvement_value");
        $this->assessedLandValue = ArrayUtil::getField($obj, "assessed_land_value");
        $this->assessedValue = ArrayUtil::getField($obj, "assessed_value");
        $this->assessorLastUpdate = ArrayUtil::getField($obj, "assessor_last_update");
        $this->assessorTaxrollUpdate = ArrayUtil::getField($obj, "assessor_taxroll_update");
        $this->atticArea = ArrayUtil::getField($obj, "attic_area");
        $this->atticFlag = ArrayUtil::getField($obj, "attic_flag");
        $this->balcony = ArrayUtil::getField($obj, "balcony");
        $this->balconyArea = ArrayUtil::getField($obj, "balcony_area");
        $this->basementSqft = ArrayUtil::getField($obj, "basement_sqft");
        $this->basementSqftFinished = ArrayUtil::getField($obj, "basement_sqft_finished");
        $this->basementSqftUnfinished = ArrayUtil::getField($obj, "basement_sqft_unfinished");
        $this->bathHouse = ArrayUtil::getField($obj, "bath_house");
        $this->bathHouseSqft = ArrayUtil::getField($obj, "bath_house_sqft");
        $this->bathroomsPartial = ArrayUtil::getField($obj, "bathrooms_partial");
        $this->bathroomsTotal = ArrayUtil::getField($obj, "bathrooms_total");
        $this->bedrooms = ArrayUtil::getField($obj, "bedrooms");
        $this->block1 = ArrayUtil::getField($obj, "block1");
        $this->block2 = ArrayUtil::getField($obj, "block2");
        $this->boatAccess = ArrayUtil::getField($obj, "boat_access");
        $this->boatHouse = ArrayUtil::getField($obj, "boat_house");
        $this->boatHouseSqft = ArrayUtil::getField($obj, "boat_house_sqft");
        $this->boatLift = ArrayUtil::getField($obj, "boat_lift");
        $this->bonusRoom = ArrayUtil::getField($obj, "bonus_room");
        $this->breakfastNook = ArrayUtil::getField($obj, "breakfast_nook");
        $this->breezeway = ArrayUtil::getField($obj, "breezeway");
        $this->buildingDefinitionCode = ArrayUtil::getField($obj, "building_definition_code");
        $this->buildingSqft = ArrayUtil::getField($obj, "building_sqft");
        $this->cabin = ArrayUtil::getField($obj, "cabin");
        $this->cabinSqft = ArrayUtil::getField($obj, "cabin_sqft");
        $this->canopy = ArrayUtil::getField($obj, "canopy");
        $this->canopySqft = ArrayUtil::getField($obj, "canopy_sqft");
        $this->carport = ArrayUtil::getField($obj, "carport");
        $this->carportSqft = ArrayUtil::getField($obj, "carport_sqft");
        $this->cbsaCode = ArrayUtil::getField($obj, "cbsa_code");
        $this->cbsaName = ArrayUtil::getField($obj, "cbsa_name");
        $this->cellar = ArrayUtil::getField($obj, "cellar");
        $this->censusBlock = ArrayUtil::getField($obj, "census_block");
        $this->censusBlockGroup = ArrayUtil::getField($obj, "census_block_group");
        $this->censusFipsPlaceCode = ArrayUtil::getField($obj, "census_fips_place_code");
        $this->censusTract = ArrayUtil::getField($obj, "census_tract");
        $this->centralVacuum = ArrayUtil::getField($obj, "central_vacuum");
        $this->codeTitleCompany = ArrayUtil::getField($obj, "code_title_company");
        $this->combinedStatisticalArea = ArrayUtil::getField($obj, "combined_statistical_area");
        $this->communityRec = ArrayUtil::getField($obj, "community_rec");
        $this->companyFlag = ArrayUtil::getField($obj, "company_flag");
        $this->congressionalDistrict = ArrayUtil::getField($obj, "congressional_district");
        $this->constructionType = ArrayUtil::getField($obj, "construction_type");
        $this->contactCity = ArrayUtil::getField($obj, "contact_city");
        $this->contactCrrt = ArrayUtil::getField($obj, "contact_crrt");
        $this->contactFullAddress = ArrayUtil::getField($obj, "contact_full_address");
        $this->contactHouseNumber = ArrayUtil::getField($obj, "contact_house_number");
        $this->contactMailInfoFormat = ArrayUtil::getField($obj, "contact_mail_info_format");
        $this->contactMailInfoPrivacy = ArrayUtil::getField($obj, "contact_mail_info_privacy");
        $this->contactMailingCounty = ArrayUtil::getField($obj, "contact_mailing_county");
        $this->contactMailingFips = ArrayUtil::getField($obj, "contact_mailing_fips");
        $this->contactPostDirection = ArrayUtil::getField($obj, "contact_post_direction");
        $this->contactPreDirection = ArrayUtil::getField($obj, "contact_pre_direction");
        $this->contactState = ArrayUtil::getField($obj, "contact_state");
        $this->contactStreetName = ArrayUtil::getField($obj, "contact_street_name");
        $this->contactSuffix = ArrayUtil::getField($obj, "contact_suffix");
        $this->contactUnitDesignator = ArrayUtil::getField($obj, "contact_unit_designator");
        $this->contactValue = ArrayUtil::getField($obj, "contact_value");
        $this->contactZip = ArrayUtil::getField($obj, "contact_zip");
        $this->contactZip4 = ArrayUtil::getField($obj, "contact_zip4");
        $this->courtyard = ArrayUtil::getField($obj, "courtyard");
        $this->courtyardArea = ArrayUtil::getField($obj, "courtyard_area");
        $this->deck = ArrayUtil::getField($obj, "deck");
        $this->deckArea = ArrayUtil::getField($obj, "deck_area");
        $this->deedDocumentPage = ArrayUtil::getField($obj, "deed_ document_page");
        $this->deedDocumentBook = ArrayUtil::getField($obj, "deed_document_book");
        $this->deedDocumentNumber = ArrayUtil::getField($obj, "deed_document_number");
        $this->deedOwnerFirstName = ArrayUtil::getField($obj, "deed_owner_first_name");
        $this->deedOwnerFirstName2 = ArrayUtil::getField($obj, "deed_owner_first_name2");
        $this->deedOwnerFirstName3 = ArrayUtil::getField($obj, "deed_owner_first_name3");
        $this->deedOwnerFirstName4 = ArrayUtil::getField($obj, "deed_owner_first_name4");
        $this->deedOwnerFullName = ArrayUtil::getField($obj, "deed_owner_full_name");
        $this->deedOwnerFullName2 = ArrayUtil::getField($obj, "deed_owner_full_name2");
        $this->deedOwnerFullName3 = ArrayUtil::getField($obj, "deed_owner_full_name3");
        $this->deedOwnerFullName4 = ArrayUtil::getField($obj, "deed_owner_full_name4");
        $this->deedOwnerLastName = ArrayUtil::getField($obj, "deed_owner_last_name");
        $this->deedOwnerLastName2 = ArrayUtil::getField($obj, "deed_owner_last_name2");
        $this->deedOwnerLastName3 = ArrayUtil::getField($obj, "deed_owner_last_name3");
        $this->deedOwnerLastName4 = ArrayUtil::getField($obj, "deed_owner_last_name4");
        $this->deedOwnerMiddleName = ArrayUtil::getField($obj, "deed_owner_middle_name");
        $this->deedOwnerMiddleName2 = ArrayUtil::getField($obj, "deed_owner_middle_name2");
        $this->deedOwnerMiddleName3 = ArrayUtil::getField($obj, "deed_owner_middle_name3");
        $this->deedOwnerMiddleName4 = ArrayUtil::getField($obj, "deed_owner_middle_name4");
        $this->deedOwnerSuffix = ArrayUtil::getField($obj, "deed_owner_suffix");
        $this->deedOwnerSuffix2 = ArrayUtil::getField($obj, "deed_owner_suffix2");
        $this->deedOwnerSuffix3 = ArrayUtil::getField($obj, "deed_owner_suffix3");
        $this->deedOwnerSuffix4 = ArrayUtil::getField($obj, "deed_owner_suffix4");
        $this->deedSaleDate = ArrayUtil::getField($obj, "deed_sale_date");
        $this->deedSalePrice = ArrayUtil::getField($obj, "deed_sale_price");
        $this->deedTransactionId = ArrayUtil::getField($obj, "deed_transaction_id");
        $this->depthLinearFootage = ArrayUtil::getField($obj, "depth_linear_footage");
        $this->disabledTaxExemption = ArrayUtil::getField($obj, "disabled_tax_exemption");
        $this->documentTypeDescription = ArrayUtil::getField($obj, "document_type_description");
        $this->drivewaySqft = ArrayUtil::getField($obj, "driveway_sqft");
        $this->drivewayType = ArrayUtil::getField($obj, "driveway_type");
        $this->effectiveYearBuilt = ArrayUtil::getField($obj, "effective_year_built");
        $this->elevationFeet = ArrayUtil::getField($obj, "elevation_feet");
        $this->elevator = ArrayUtil::getField($obj, "elevator");
        $this->equestrianArena = ArrayUtil::getField($obj, "equestrian_arena");
        $this->escalator = ArrayUtil::getField($obj, "escalator");
        $this->exerciseRoom = ArrayUtil::getField($obj, "exercise_room");
        $this->exteriorWalls = ArrayUtil::getField($obj, "exterior_walls");
        $this->familyRoom = ArrayUtil::getField($obj, "family_room");
        $this->fence = ArrayUtil::getField($obj, "fence");
        $this->fenceArea = ArrayUtil::getField($obj, "fence_area");
        $this->fipsCode = ArrayUtil::getField($obj, "fips_code");
        $this->fireResistanceCode = ArrayUtil::getField($obj, "fire_resistance_code");
        $this->fireSprinklersFlag = ArrayUtil::getField($obj, "fire_sprinklers_flag");
        $this->fireplace = ArrayUtil::getField($obj, "fireplace");
        $this->fireplaceNumber = ArrayUtil::getField($obj, "fireplace_number");
        $this->firstName = ArrayUtil::getField($obj, "first_name");
        $this->firstName2 = ArrayUtil::getField($obj, "first_name_2");
        $this->firstName3 = ArrayUtil::getField($obj, "first_name_3");
        $this->firstName4 = ArrayUtil::getField($obj, "first_name_4");
        $this->flooring = ArrayUtil::getField($obj, "flooring");
        $this->foundation = ArrayUtil::getField($obj, "foundation");
        $this->gameRoom = ArrayUtil::getField($obj, "game_room");
        $this->garage = ArrayUtil::getField($obj, "garage");
        $this->garageSqft = ArrayUtil::getField($obj, "garage_sqft");
        $this->gazebo = ArrayUtil::getField($obj, "gazebo");
        $this->gazeboSqft = ArrayUtil::getField($obj, "gazebo_sqft");
        $this->golfCourse = ArrayUtil::getField($obj, "golf_course");
        $this->grainery = ArrayUtil::getField($obj, "grainery");
        $this->grainerySqft = ArrayUtil::getField($obj, "grainery_sqft");
        $this->greatRoom = ArrayUtil::getField($obj, "great_room");
        $this->greenhouse = ArrayUtil::getField($obj, "greenhouse");
        $this->greenhouseSqft = ArrayUtil::getField($obj, "greenhouse_sqft");
        $this->grossSqft = ArrayUtil::getField($obj, "gross_sqft");
        $this->guesthouse = ArrayUtil::getField($obj, "guesthouse");
        $this->guesthouseSqft = ArrayUtil::getField($obj, "guesthouse_sqft");
        $this->handicapAccessibility = ArrayUtil::getField($obj, "handicap_accessibility");
        $this->heat = ArrayUtil::getField($obj, "heat");
        $this->heatFuelType = ArrayUtil::getField($obj, "heat_fuel_type");
        $this->hobbyRoom = ArrayUtil::getField($obj, "hobby_room");
        $this->homeownerTaxExemption = ArrayUtil::getField($obj, "homeowner_tax_exemption");
        $this->instrumentDate = ArrayUtil::getField($obj, "instrument_date");
        $this->intercomSystem = ArrayUtil::getField($obj, "intercom_system");
        $this->interestRateType2 = ArrayUtil::getField($obj, "interest_rate_type_2");
        $this->interiorStructure = ArrayUtil::getField($obj, "interior_structure");
        $this->kennel = ArrayUtil::getField($obj, "kennel");
        $this->kennelSqft = ArrayUtil::getField($obj, "kennel_sqft");
        $this->landUseCode = ArrayUtil::getField($obj, "land_use_code");
        $this->landUseGroup = ArrayUtil::getField($obj, "land_use_group");
        $this->landUseStandard = ArrayUtil::getField($obj, "land_use_standard");
        $this->lastName = ArrayUtil::getField($obj, "last_name");
        $this->lastName2 = ArrayUtil::getField($obj, "last_name_2");
        $this->lastName3 = ArrayUtil::getField($obj, "last_name_3");
        $this->lastName4 = ArrayUtil::getField($obj, "last_name_4");
        $this->latitude = ArrayUtil::getField($obj, "latitude");
        $this->laundry = ArrayUtil::getField($obj, "laundry");
        $this->leanTo = ArrayUtil::getField($obj, "lean_to");
        $this->leanToSqft = ArrayUtil::getField($obj, "lean_to_sqft");
        $this->legalDescription = ArrayUtil::getField($obj, "legal_description");
        $this->legalUnit = ArrayUtil::getField($obj, "legal_unit");
        $this->lenderAddress = ArrayUtil::getField($obj, "lender_address");
        $this->lenderAddress2 = ArrayUtil::getField($obj, "lender_address_2");
        $this->lenderCity = ArrayUtil::getField($obj, "lender_city");
        $this->lenderCity2 = ArrayUtil::getField($obj, "lender_city_2");
        $this->lenderCode2 = ArrayUtil::getField($obj, "lender_code_2");
        $this->lenderFirstName = ArrayUtil::getField($obj, "lender_first_name");
        $this->lenderFirstName2 = ArrayUtil::getField($obj, "lender_first_name_2");
        $this->lenderLastName = ArrayUtil::getField($obj, "lender_last_name");
        $this->lenderLastName2 = ArrayUtil::getField($obj, "lender_last_name_2");
        $this->lenderName = ArrayUtil::getField($obj, "lender_name");
        $this->lenderName2 = ArrayUtil::getField($obj, "lender_name_2");
        $this->lenderSellerCarryBack = ArrayUtil::getField($obj, "lender_seller_carry_back");
        $this->lenderSellerCarryBack2 = ArrayUtil::getField($obj, "lender_seller_carry_back_2");
        $this->lenderState = ArrayUtil::getField($obj, "lender_state");
        $this->lenderState2 = ArrayUtil::getField($obj, "lender_state_2");
        $this->lenderZip = ArrayUtil::getField($obj, "lender_zip");
        $this->lenderZip2 = ArrayUtil::getField($obj, "lender_zip_2");
        $this->lenderZipExtended = ArrayUtil::getField($obj, "lender_zip_extended");
        $this->lenderZipExtended2 = ArrayUtil::getField($obj, "lender_zip_extended_2");
        $this->loadingPlatform = ArrayUtil::getField($obj, "loading_platform");
        $this->loadingPlatformSqft = ArrayUtil::getField($obj, "loading_platform_sqft");
        $this->longitude = ArrayUtil::getField($obj, "longitude");
        $this->lot1 = ArrayUtil::getField($obj, "lot_1");
        $this->lot2 = ArrayUtil::getField($obj, "lot_2");
        $this->lot3 = ArrayUtil::getField($obj, "lot_3");
        $this->lotSqft = ArrayUtil::getField($obj, "lot_sqft");
        $this->marketImprovementPercent = ArrayUtil::getField($obj, "market_improvement_percent");
        $this->marketImprovementValue = ArrayUtil::getField($obj, "market_improvement_value");
        $this->marketLandValue = ArrayUtil::getField($obj, "market_land_value");
        $this->marketValueYear = ArrayUtil::getField($obj, "market_value_year");
        $this->matchType = ArrayUtil::getField($obj, "match_type");
        $this->mediaRoom = ArrayUtil::getField($obj, "media_room");
        $this->metroDivision = ArrayUtil::getField($obj, "metro_division");
        $this->middleName = ArrayUtil::getField($obj, "middle_name");
        $this->middleName2 = ArrayUtil::getField($obj, "middle_name_2");
        $this->middleName3 = ArrayUtil::getField($obj, "middle_name_3");
        $this->middleName4 = ArrayUtil::getField($obj, "middle_name_4");
        $this->milkhouse = ArrayUtil::getField($obj, "milkhouse");
        $this->milkhouseSqft = ArrayUtil::getField($obj, "milkhouse_sqft");
        $this->minorCivilDivisionCode = ArrayUtil::getField($obj, "minor_civil_division_code");
        $this->minorCivilDivisionName = ArrayUtil::getField($obj, "minor_civil_division_name");
        $this->mobileHomeHookup = ArrayUtil::getField($obj, "mobile_home_hookup");
        $this->mortgageAmount = ArrayUtil::getField($obj, "mortgage_amount");
        $this->mortgageAmount2 = ArrayUtil::getField($obj, "mortgage_amount_2");
        $this->mortgageDueDate = ArrayUtil::getField($obj, "mortgage_due_date");
        $this->mortgageDueDate2 = ArrayUtil::getField($obj, "mortgage_due_date_2");
        $this->mortgageInterestRate = ArrayUtil::getField($obj, "mortgage_interest_rate");
        $this->mortgageInterestRateType = ArrayUtil::getField($obj, "mortgage_interest_rate_type");
        $this->mortgageLenderCode = ArrayUtil::getField($obj, "mortgage_lender_code");
        $this->mortgageRate2 = ArrayUtil::getField($obj, "mortgage_rate_2");
        $this->mortgageRecordingDate = ArrayUtil::getField($obj, "mortgage_recording_date");
        $this->mortgageRecordingDate2 = ArrayUtil::getField($obj, "mortgage_recording_date_2");
        $this->mortgageTerm = ArrayUtil::getField($obj, "mortgage_term");
        $this->mortgageTerm2 = ArrayUtil::getField($obj, "mortgage_term_2");
        $this->mortgageTermType = ArrayUtil::getField($obj, "mortgage_term_type");
        $this->mortgageTermType2 = ArrayUtil::getField($obj, "mortgage_term_type_2");
        $this->mortgageType = ArrayUtil::getField($obj, "mortgage_type");
        $this->mortgageType2 = ArrayUtil::getField($obj, "mortgage_type_2");
        $this->msaCode = ArrayUtil::getField($obj, "msa_code");
        $this->msaName = ArrayUtil::getField($obj, "msa_name");
        $this->mudRoom = ArrayUtil::getField($obj, "mud_room");
        $this->multiParcelFlag = ArrayUtil::getField($obj, "multi_parcel_flag");
        $this->nameTitleCompany = ArrayUtil::getField($obj, "name_title_company");
        $this->neighborhoodCode = ArrayUtil::getField($obj, "neighborhood_code");
        $this->numberOfBuildings = ArrayUtil::getField($obj, "number_of_buildings");
        $this->office = ArrayUtil::getField($obj, "office");
        $this->officeSqft = ArrayUtil::getField($obj, "office_sqft");
        $this->otherTaxExemption = ArrayUtil::getField($obj, "other_tax_exemption");
        $this->outdoorKitchenFireplace = ArrayUtil::getField($obj, "outdoor_kitchen_fireplace");
        $this->overheadDoor = ArrayUtil::getField($obj, "overhead_door");
        $this->ownerFullName = ArrayUtil::getField($obj, "owner_full_name");
        $this->ownerFullName2 = ArrayUtil::getField($obj, "owner_full_name_2");
        $this->ownerFullName3 = ArrayUtil::getField($obj, "owner_full_name_3");
        $this->ownerFullName4 = ArrayUtil::getField($obj, "owner_full_name_4");
        $this->ownerOccupancyStatus = ArrayUtil::getField($obj, "owner_occupancy_status");
        $this->ownershipTransferDate = ArrayUtil::getField($obj, "ownership_transfer_date");
        $this->ownershipTransferDocNumber = ArrayUtil::getField($obj, "ownership_transfer_doc_number");
        $this->ownershipTransferTransactionId = ArrayUtil::getField($obj, "ownership_transfer_transaction_id");
        $this->ownershipType = ArrayUtil::getField($obj, "ownership_type");
        $this->ownershipType2 = ArrayUtil::getField($obj, "ownership_type_2");
        $this->ownershipVestingRelationCode = ArrayUtil::getField($obj, "ownership_vesting_relation_code");
        $this->parcelAccountNumber = ArrayUtil::getField($obj, "parcel_account_number");
        $this->parcelMapBook = ArrayUtil::getField($obj, "parcel_map_book");
        $this->parcelMapPage = ArrayUtil::getField($obj, "parcel_map_page");
        $this->parcelNumberAlternate = ArrayUtil::getField($obj, "parcel_number_alternate");
        $this->parcelNumberFormatted = ArrayUtil::getField($obj, "parcel_number_formatted");
        $this->parcelNumberPrevious = ArrayUtil::getField($obj, "parcel_number_previous");
        $this->parcelNumberYearAdded = ArrayUtil::getField($obj, "parcel_number_year_added");
        $this->parcelNumberYearChange = ArrayUtil::getField($obj, "parcel_number_year_change");
        $this->parcelRawNumber = ArrayUtil::getField($obj, "parcel_raw_number");
        $this->parcelShellRecord = ArrayUtil::getField($obj, "parcel_shell_record");
        $this->parkingSpaces = ArrayUtil::getField($obj, "parking_spaces");
        $this->patioArea = ArrayUtil::getField($obj, "patio_area");
        $this->phaseName = ArrayUtil::getField($obj, "phase_name");
        $this->plumbingFixturesCount = ArrayUtil::getField($obj, "plumbing_fixtures_count");
        $this->poleStruct = ArrayUtil::getField($obj, "pole_struct");
        $this->poleStructSqft = ArrayUtil::getField($obj, "pole_struct_sqft");
        $this->pond = ArrayUtil::getField($obj, "pond");
        $this->pool = ArrayUtil::getField($obj, "pool");
        $this->poolArea = ArrayUtil::getField($obj, "pool_area");
        $this->poolhouse = ArrayUtil::getField($obj, "poolhouse");
        $this->poolhouseSqft = ArrayUtil::getField($obj, "poolhouse_sqft");
        $this->porch = ArrayUtil::getField($obj, "porch");
        $this->porchArea = ArrayUtil::getField($obj, "porch_area");
        $this->poultryHouse = ArrayUtil::getField($obj, "poultry_house");
        $this->poultryHouseSqft = ArrayUtil::getField($obj, "poultry_house_sqft");
        $this->previousAssessedValue = ArrayUtil::getField($obj, "previous_assessed_value");
        $this->priorSaleAmount = ArrayUtil::getField($obj, "prior_sale_amount");
        $this->priorSaleDate = ArrayUtil::getField($obj, "prior_sale_date");
        $this->propertyAddressCarrierRouteCode = ArrayUtil::getField($obj, "property_address_carrier_route_code");
        $this->propertyAddressCity = ArrayUtil::getField($obj, "property_address_city");
        $this->propertyAddressFull = ArrayUtil::getField($obj, "property_address_full");
        $this->propertyAddressHouseNumber = ArrayUtil::getField($obj, "property_address_house_number");
        $this->propertyAddressPostDirection = ArrayUtil::getField($obj, "property_address_post_direction");
        $this->propertyAddressPreDirection = ArrayUtil::getField($obj, "property_address_pre_direction");
        $this->propertyAddressState = ArrayUtil::getField($obj, "property_address_state");
        $this->propertyAddressStreetName = ArrayUtil::getField($obj, "property_address_street_name");
        $this->propertyAddressStreetSuffix = ArrayUtil::getField($obj, "property_address_street_suffix");
        $this->propertyAddressUnitDesignator = ArrayUtil::getField($obj, "property_address_unit_designator");
        $this->propertyAddressUnitValue = ArrayUtil::getField($obj, "property_address_unit_value");
        $this->propertyAddressZip4 = ArrayUtil::getField($obj, "property_address_zip_4");
        $this->propertyAddressZipcode = ArrayUtil::getField($obj, "property_address_zipcode");
        $this->publicationDate = ArrayUtil::getField($obj, "publication_date");
        $this->quarter = ArrayUtil::getField($obj, "quarter");
        $this->quarterQuarter = ArrayUtil::getField($obj, "quarter_quarter");
        $this->quonset = ArrayUtil::getField($obj, "quonset");
        $this->quonsetSqft = ArrayUtil::getField($obj, "quonset_sqft");
        $this->range = ArrayUtil::getField($obj, "range");
        $this->recordingDate = ArrayUtil::getField($obj, "recording_date");
        $this->roofCover = ArrayUtil::getField($obj, "roof_cover");
        $this->roofFrame = ArrayUtil::getField($obj, "roof_frame");
        $this->rooms = ArrayUtil::getField($obj, "rooms");
        $this->rvParking = ArrayUtil::getField($obj, "rv_parking");
        $this->safeRoom = ArrayUtil::getField($obj, "safe_room");
        $this->saleAmount = ArrayUtil::getField($obj, "sale_amount");
        $this->saleDate = ArrayUtil::getField($obj, "sale_date");
        $this->sauna = ArrayUtil::getField($obj, "sauna");
        $this->section = ArrayUtil::getField($obj, "section");
        $this->securityAlarm = ArrayUtil::getField($obj, "security_alarm");
        $this->seniorTaxExemption = ArrayUtil::getField($obj, "senior_tax_exemption");
        $this->sewerType = ArrayUtil::getField($obj, "sewer_type");
        $this->shed = ArrayUtil::getField($obj, "shed");
        $this->shedSqft = ArrayUtil::getField($obj, "shed_sqft");
        $this->silo = ArrayUtil::getField($obj, "silo");
        $this->siloSqft = ArrayUtil::getField($obj, "silo_sqft");
        $this->sittingRoom = ArrayUtil::getField($obj, "sitting_room");
        $this->situsCounty = ArrayUtil::getField($obj, "situs_county");
        $this->situsState = ArrayUtil::getField($obj, "situs_state");
        $this->soundSystem = ArrayUtil::getField($obj, "sound_system");
        $this->sportsCourt = ArrayUtil::getField($obj, "sports_court");
        $this->sprinklers = ArrayUtil::getField($obj, "sprinklers");
        $this->stable = ArrayUtil::getField($obj, "stable");
        $this->stableSqft = ArrayUtil::getField($obj, "stable_sqft");
        $this->storageBuilding = ArrayUtil::getField($obj, "storage_building");
        $this->storageBuildingSqft = ArrayUtil::getField($obj, "storage_building_sqft");
        $this->storiesNumber = ArrayUtil::getField($obj, "stories_number");
        $this->stormShelter = ArrayUtil::getField($obj, "storm_shelter");
        $this->stormShutter = ArrayUtil::getField($obj, "storm_shutter");
        $this->structureStyle = ArrayUtil::getField($obj, "structure_style");
        $this->study = ArrayUtil::getField($obj, "study");
        $this->subdivision = ArrayUtil::getField($obj, "subdivision");
        $this->suffix = ArrayUtil::getField($obj, "suffix");
        $this->suffix2 = ArrayUtil::getField($obj, "suffix_2");
        $this->suffix3 = ArrayUtil::getField($obj, "suffix_3");
        $this->suffix4 = ArrayUtil::getField($obj, "suffix_4");
        $this->sunroom = ArrayUtil::getField($obj, "sunroom");
        $this->taxAssessYear = ArrayUtil::getField($obj, "tax_assess_year");
        $this->taxBilledAmount = ArrayUtil::getField($obj, "tax_billed_amount");
        $this->taxDelinquentYear = ArrayUtil::getField($obj, "tax_delinquent_year");
        $this->taxFiscalYear = ArrayUtil::getField($obj, "tax_fiscal_year");
        $this->taxJurisdiction = ArrayUtil::getField($obj, "tax_jurisdiction");
        $this->taxRateArea = ArrayUtil::getField($obj, "tax_rate_area");
        $this->tennisCourt = ArrayUtil::getField($obj, "tennis_court");
        $this->topographyCode = ArrayUtil::getField($obj, "topography_code");
        $this->totalMarketValue = ArrayUtil::getField($obj, "total_market_value");
        $this->township = ArrayUtil::getField($obj, "township");
        $this->tractNumber = ArrayUtil::getField($obj, "tract_number");
        $this->transferAmount = ArrayUtil::getField($obj, "transfer_amount");
        $this->trustDescription = ArrayUtil::getField($obj, "trust_description");
        $this->unitCount = ArrayUtil::getField($obj, "unit_count");
        $this->upperFloorsSqft = ArrayUtil::getField($obj, "upper_floors_sqft");
        $this->utility = ArrayUtil::getField($obj, "utility");
        $this->utilityBuilding = ArrayUtil::getField($obj, "utility_building");
        $this->utilityBuildingSqft = ArrayUtil::getField($obj, "utility_building_sqft");
        $this->utilitySqft = ArrayUtil::getField($obj, "utility_sqft");
        $this->veteranTaxExemption = ArrayUtil::getField($obj, "veteran_tax_exemption");
        $this->viewDescription = ArrayUtil::getField($obj, "view_description");
        $this->waterFeature = ArrayUtil::getField($obj, "water_feature");
        $this->waterServiceType = ArrayUtil::getField($obj, "water_service_type");
        $this->wetBar = ArrayUtil::getField($obj, "wet_bar");
        $this->widowTaxExemption = ArrayUtil::getField($obj, "widow_tax_exemption");
        $this->widthLinearFootage = ArrayUtil::getField($obj, "width_linear_footage");
        $this->wineCellar = ArrayUtil::getField($obj, "wine_cellar");
        $this->yearBuilt = ArrayUtil::getField($obj, "year_built");
        $this->zoning = ArrayUtil::getField($obj, "zoning");

    }
}