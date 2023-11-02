<?php
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
    $deed DocumentPage,
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
        $this->firstFloorSqft = ArrayUtil::setField($obj, "1st_floor_sqft");
        $this->secondFloorSqft = ArrayUtil::setField($obj, "2nd_floor_sqft");
        $this->acres = ArrayUtil::setField($obj, "acres");
        $this->airConditioner = ArrayUtil::setField($obj, "air_conditioner");
        $this->arborPergola = ArrayUtil::setField($obj, "arbor_pergola");
        $this->assessedImprovementPercent = ArrayUtil::setField($obj, "assessed_improvement_percent");
        $this->assessedImprovementValue = ArrayUtil::setField($obj, "assessed_improvement_value");
        $this->assessedLandValue = ArrayUtil::setField($obj, "assessed_land_value");
        $this->assessedValue = ArrayUtil::setField($obj, "assessed_value");
        $this->assessorLastUpdate = ArrayUtil::setField($obj, "assessor_last_update");
        $this->assessorTaxrollUpdate = ArrayUtil::setField($obj, "assessor_taxroll_update");
        $this->atticArea = ArrayUtil::setField($obj, "attic_area");
        $this->atticFlag = ArrayUtil::setField($obj, "attic_flag");
        $this->balcony = ArrayUtil::setField($obj, "balcony");
        $this->balconyArea = ArrayUtil::setField($obj, "balcony_area");
        $this->basementSqft = ArrayUtil::setField($obj, "basement_sqft");
        $this->basementSqftFinished = ArrayUtil::setField($obj, "basement_sqft_finished");
        $this->basementSqftUnfinished = ArrayUtil::setField($obj, "basement_sqft_unfinished");
        $this->bathHouse = ArrayUtil::setField($obj, "bath_house");
        $this->bathHouseSqft = ArrayUtil::setField($obj, "bath_house_sqft");
        $this->bathroomsPartial = ArrayUtil::setField($obj, "bathrooms_partial");
        $this->bathroomsTotal = ArrayUtil::setField($obj, "bathrooms_total");
        $this->bedrooms = ArrayUtil::setField($obj, "bedrooms");
        $this->block1 = ArrayUtil::setField($obj, "block1");
        $this->block2 = ArrayUtil::setField($obj, "block2");
        $this->boatAccess = ArrayUtil::setField($obj, "boat_access");
        $this->boatHouse = ArrayUtil::setField($obj, "boat_house");
        $this->boatHouseSqft = ArrayUtil::setField($obj, "boat_house_sqft");
        $this->boatLift = ArrayUtil::setField($obj, "boat_lift");
        $this->bonusRoom = ArrayUtil::setField($obj, "bonus_room");
        $this->breakfastNook = ArrayUtil::setField($obj, "breakfast_nook");
        $this->breezeway = ArrayUtil::setField($obj, "breezeway");
        $this->buildingDefinitionCode = ArrayUtil::setField($obj, "building_definition_code");
        $this->buildingSqft = ArrayUtil::setField($obj, "building_sqft");
        $this->cabin = ArrayUtil::setField($obj, "cabin");
        $this->cabinSqft = ArrayUtil::setField($obj, "cabin_sqft");
        $this->canopy = ArrayUtil::setField($obj, "canopy");
        $this->canopySqft = ArrayUtil::setField($obj, "canopy_sqft");
        $this->carport = ArrayUtil::setField($obj, "carport");
        $this->carportSqft = ArrayUtil::setField($obj, "carport_sqft");
        $this->cbsaCode = ArrayUtil::setField($obj, "cbsa_code");
        $this->cbsaName = ArrayUtil::setField($obj, "cbsa_name");
        $this->cellar = ArrayUtil::setField($obj, "cellar");
        $this->censusBlock = ArrayUtil::setField($obj, "census_block");
        $this->censusBlockGroup = ArrayUtil::setField($obj, "census_block_group");
        $this->censusFipsPlaceCode = ArrayUtil::setField($obj, "census_fips_place_code");
        $this->censusTract = ArrayUtil::setField($obj, "census_tract");
        $this->centralVacuum = ArrayUtil::setField($obj, "central_vacuum");
        $this->codeTitleCompany = ArrayUtil::setField($obj, "code_title_company");
        $this->combinedStatisticalArea = ArrayUtil::setField($obj, "combined_statistical_area");
        $this->communityRec = ArrayUtil::setField($obj, "community_rec");
        $this->companyFlag = ArrayUtil::setField($obj, "company_flag");
        $this->congressionalDistrict = ArrayUtil::setField($obj, "congressional_district");
        $this->constructionType = ArrayUtil::setField($obj, "construction_type");
        $this->contactCity = ArrayUtil::setField($obj, "contact_city");
        $this->contactCrrt = ArrayUtil::setField($obj, "contact_crrt");
        $this->contactFullAddress = ArrayUtil::setField($obj, "contact_full_address");
        $this->contactHouseNumber = ArrayUtil::setField($obj, "contact_house_number");
        $this->contactMailInfoFormat = ArrayUtil::setField($obj, "contact_mail_info_format");
        $this->contactMailInfoPrivacy = ArrayUtil::setField($obj, "contact_mail_info_privacy");
        $this->contactMailingCounty = ArrayUtil::setField($obj, "contact_mailing_county");
        $this->contactMailingFips = ArrayUtil::setField($obj, "contact_mailing_fips");
        $this->contactPostDirection = ArrayUtil::setField($obj, "contact_post_direction");
        $this->contactPreDirection = ArrayUtil::setField($obj, "contact_pre_direction");
        $this->contactState = ArrayUtil::setField($obj, "contact_state");
        $this->contactStreetName = ArrayUtil::setField($obj, "contact_street_name");
        $this->contactSuffix = ArrayUtil::setField($obj, "contact_suffix");
        $this->contactUnitDesignator = ArrayUtil::setField($obj, "contact_unit_designator");
        $this->contactValue = ArrayUtil::setField($obj, "contact_value");
        $this->contactZip = ArrayUtil::setField($obj, "contact_zip");
        $this->contactZip4 = ArrayUtil::setField($obj, "contact_zip4");
        $this->courtyard = ArrayUtil::setField($obj, "courtyard");
        $this->courtyardArea = ArrayUtil::setField($obj, "courtyard_area");
        $this->deck = ArrayUtil::setField($obj, "deck");
        $this->deckArea = ArrayUtil::setField($obj, "deck_area");
        $this->deed DocumentPage = ArrayUtil::setField($obj, "deed_ document_page");
        $this->deedDocumentBook = ArrayUtil::setField($obj, "deed_document_book");
        $this->deedDocumentNumber = ArrayUtil::setField($obj, "deed_document_number");
        $this->deedOwnerFirstName = ArrayUtil::setField($obj, "deed_owner_first_name");
        $this->deedOwnerFirstName2 = ArrayUtil::setField($obj, "deed_owner_first_name2");
        $this->deedOwnerFirstName3 = ArrayUtil::setField($obj, "deed_owner_first_name3");
        $this->deedOwnerFirstName4 = ArrayUtil::setField($obj, "deed_owner_first_name4");
        $this->deedOwnerFullName = ArrayUtil::setField($obj, "deed_owner_full_name");
        $this->deedOwnerFullName2 = ArrayUtil::setField($obj, "deed_owner_full_name2");
        $this->deedOwnerFullName3 = ArrayUtil::setField($obj, "deed_owner_full_name3");
        $this->deedOwnerFullName4 = ArrayUtil::setField($obj, "deed_owner_full_name4");
        $this->deedOwnerLastName = ArrayUtil::setField($obj, "deed_owner_last_name");
        $this->deedOwnerLastName2 = ArrayUtil::setField($obj, "deed_owner_last_name2");
        $this->deedOwnerLastName3 = ArrayUtil::setField($obj, "deed_owner_last_name3");
        $this->deedOwnerLastName4 = ArrayUtil::setField($obj, "deed_owner_last_name4");
        $this->deedOwnerMiddleName = ArrayUtil::setField($obj, "deed_owner_middle_name");
        $this->deedOwnerMiddleName2 = ArrayUtil::setField($obj, "deed_owner_middle_name2");
        $this->deedOwnerMiddleName3 = ArrayUtil::setField($obj, "deed_owner_middle_name3");
        $this->deedOwnerMiddleName4 = ArrayUtil::setField($obj, "deed_owner_middle_name4");
        $this->deedOwnerSuffix = ArrayUtil::setField($obj, "deed_owner_suffix");
        $this->deedOwnerSuffix2 = ArrayUtil::setField($obj, "deed_owner_suffix2");
        $this->deedOwnerSuffix3 = ArrayUtil::setField($obj, "deed_owner_suffix3");
        $this->deedOwnerSuffix4 = ArrayUtil::setField($obj, "deed_owner_suffix4");
        $this->deedSaleDate = ArrayUtil::setField($obj, "deed_sale_date");
        $this->deedSalePrice = ArrayUtil::setField($obj, "deed_sale_price");
        $this->deedTransactionId = ArrayUtil::setField($obj, "deed_transaction_id");
        $this->depthLinearFootage = ArrayUtil::setField($obj, "depth_linear_footage");
        $this->disabledTaxExemption = ArrayUtil::setField($obj, "disabled_tax_exemption");
        $this->drivewaySqft = ArrayUtil::setField($obj, "driveway_sqft");
        $this->drivewayType = ArrayUtil::setField($obj, "driveway_type");
        $this->effectiveYearBuilt = ArrayUtil::setField($obj, "effective_year_built");
        $this->elevationFeet = ArrayUtil::setField($obj, "elevation_feet");
        $this->elevator = ArrayUtil::setField($obj, "elevator");
        $this->equestrianArena = ArrayUtil::setField($obj, "equestrian_arena");
        $this->escalator = ArrayUtil::setField($obj, "escalator");
        $this->exerciseRoom = ArrayUtil::setField($obj, "exercise_room");
        $this->exteriorWalls = ArrayUtil::setField($obj, "exterior_walls");
        $this->familyRoom = ArrayUtil::setField($obj, "family_room");
        $this->fence = ArrayUtil::setField($obj, "fence");
        $this->fenceArea = ArrayUtil::setField($obj, "fence_area");
        $this->fipsCode = ArrayUtil::setField($obj, "fips_code");
        $this->fireResistanceCode = ArrayUtil::setField($obj, "fire_resistance_code");
        $this->fireSprinklersFlag = ArrayUtil::setField($obj, "fire_sprinklers_flag");
        $this->fireplace = ArrayUtil::setField($obj, "fireplace");
        $this->fireplaceNumber = ArrayUtil::setField($obj, "fireplace_number");
        $this->firstName = ArrayUtil::setField($obj, "first_name");
        $this->firstName2 = ArrayUtil::setField($obj, "first_name_2");
        $this->firstName3 = ArrayUtil::setField($obj, "first_name_3");
        $this->firstName4 = ArrayUtil::setField($obj, "first_name_4");
        $this->flooring = ArrayUtil::setField($obj, "flooring");
        $this->foundation = ArrayUtil::setField($obj, "foundation");
        $this->gameRoom = ArrayUtil::setField($obj, "game_room");
        $this->garage = ArrayUtil::setField($obj, "garage");
        $this->garageSqft = ArrayUtil::setField($obj, "garage_sqft");
        $this->gazebo = ArrayUtil::setField($obj, "gazebo");
        $this->gazeboSqft = ArrayUtil::setField($obj, "gazebo_sqft");
        $this->golfCourse = ArrayUtil::setField($obj, "golf_course");
        $this->grainery = ArrayUtil::setField($obj, "grainery");
        $this->grainerySqft = ArrayUtil::setField($obj, "grainery_sqft");
        $this->greatRoom = ArrayUtil::setField($obj, "great_room");
        $this->greenhouse = ArrayUtil::setField($obj, "greenhouse");
        $this->greenhouseSqft = ArrayUtil::setField($obj, "greenhouse_sqft");
        $this->grossSqft = ArrayUtil::setField($obj, "gross_sqft");
        $this->guesthouse = ArrayUtil::setField($obj, "guesthouse");
        $this->guesthouseSqft = ArrayUtil::setField($obj, "guesthouse_sqft");
        $this->handicapAccessibility = ArrayUtil::setField($obj, "handicap_accessibility");
        $this->heat = ArrayUtil::setField($obj, "heat");
        $this->heatFuelType = ArrayUtil::setField($obj, "heat_fuel_type");
        $this->hobbyRoom = ArrayUtil::setField($obj, "hobby_room");
        $this->homeownerTaxExemption = ArrayUtil::setField($obj, "homeowner_tax_exemption");
        $this->instrumentDate = ArrayUtil::setField($obj, "instrument_date");
        $this->intercomSystem = ArrayUtil::setField($obj, "intercom_system");
        $this->interestRateType2 = ArrayUtil::setField($obj, "interest_rate_type_2");
        $this->interiorStructure = ArrayUtil::setField($obj, "interior_structure");
        $this->kennel = ArrayUtil::setField($obj, "kennel");
        $this->kennelSqft = ArrayUtil::setField($obj, "kennel_sqft");
        $this->landUseCode = ArrayUtil::setField($obj, "land_use_code");
        $this->landUseGroup = ArrayUtil::setField($obj, "land_use_group");
        $this->landUseStandard = ArrayUtil::setField($obj, "land_use_standard");
        $this->lastName = ArrayUtil::setField($obj, "last_name");
        $this->lastName2 = ArrayUtil::setField($obj, "last_name_2");
        $this->lastName3 = ArrayUtil::setField($obj, "last_name_3");
        $this->lastName4 = ArrayUtil::setField($obj, "last_name_4");
        $this->latitude = ArrayUtil::setField($obj, "latitude");
        $this->laundry = ArrayUtil::setField($obj, "laundry");
        $this->leanTo = ArrayUtil::setField($obj, "lean_to");
        $this->leanToSqft = ArrayUtil::setField($obj, "lean_to_sqft");
        $this->legalDescription = ArrayUtil::setField($obj, "legal_description");
        $this->legalUnit = ArrayUtil::setField($obj, "legal_unit");
        $this->lenderAddress = ArrayUtil::setField($obj, "lender_address");
        $this->lenderAddress2 = ArrayUtil::setField($obj, "lender_address_2");
        $this->lenderCity = ArrayUtil::setField($obj, "lender_city");
        $this->lenderCity2 = ArrayUtil::setField($obj, "lender_city_2");
        $this->lenderCode2 = ArrayUtil::setField($obj, "lender_code_2");
        $this->lenderFirstName = ArrayUtil::setField($obj, "lender_first_name");
        $this->lenderFirstName2 = ArrayUtil::setField($obj, "lender_first_name_2");
        $this->lenderLastName = ArrayUtil::setField($obj, "lender_last_name");
        $this->lenderLastName2 = ArrayUtil::setField($obj, "lender_last_name_2");
        $this->lenderName = ArrayUtil::setField($obj, "lender_name");
        $this->lenderName2 = ArrayUtil::setField($obj, "lender_name_2");
        $this->lenderSellerCarryBack = ArrayUtil::setField($obj, "lender_seller_carry_back");
        $this->lenderSellerCarryBack2 = ArrayUtil::setField($obj, "lender_seller_carry_back_2");
        $this->lenderState = ArrayUtil::setField($obj, "lender_state");
        $this->lenderState2 = ArrayUtil::setField($obj, "lender_state_2");
        $this->lenderZip = ArrayUtil::setField($obj, "lender_zip");
        $this->lenderZip2 = ArrayUtil::setField($obj, "lender_zip_2");
        $this->lenderZipExtended = ArrayUtil::setField($obj, "lender_zip_extended");
        $this->lenderZipExtended2 = ArrayUtil::setField($obj, "lender_zip_extended_2");
        $this->loadingPlatform = ArrayUtil::setField($obj, "loading_platform");
        $this->loadingPlatformSqft = ArrayUtil::setField($obj, "loading_platform_sqft");
        $this->longitude = ArrayUtil::setField($obj, "longitude");
        $this->lot1 = ArrayUtil::setField($obj, "lot_1");
        $this->lot2 = ArrayUtil::setField($obj, "lot_2");
        $this->lot3 = ArrayUtil::setField($obj, "lot_3");
        $this->lotSqft = ArrayUtil::setField($obj, "lot_sqft");
        $this->marketImprovementPercent = ArrayUtil::setField($obj, "market_improvement_percent");
        $this->marketImprovementValue = ArrayUtil::setField($obj, "market_improvement_value");
        $this->marketLandValue = ArrayUtil::setField($obj, "market_land_value");
        $this->marketValueYear = ArrayUtil::setField($obj, "market_value_year");
        $this->matchType = ArrayUtil::setField($obj, "match_type");
        $this->mediaRoom = ArrayUtil::setField($obj, "media_room");
        $this->metroDivision = ArrayUtil::setField($obj, "metro_division");
        $this->middleName = ArrayUtil::setField($obj, "middle_name");
        $this->middleName2 = ArrayUtil::setField($obj, "middle_name_2");
        $this->middleName3 = ArrayUtil::setField($obj, "middle_name_3");
        $this->middleName4 = ArrayUtil::setField($obj, "middle_name_4");
        $this->milkhouse = ArrayUtil::setField($obj, "milkhouse");
        $this->milkhouseSqft = ArrayUtil::setField($obj, "milkhouse_sqft");
        $this->minorCivilDivisionCode = ArrayUtil::setField($obj, "minor_civil_division_code");
        $this->minorCivilDivisionName = ArrayUtil::setField($obj, "minor_civil_division_name");
        $this->mobileHomeHookup = ArrayUtil::setField($obj, "mobile_home_hookup");
        $this->mortgageAmount = ArrayUtil::setField($obj, "mortgage_amount");
        $this->mortgageAmount2 = ArrayUtil::setField($obj, "mortgage_amount_2");
        $this->mortgageDueDate = ArrayUtil::setField($obj, "mortgage_due_date");
        $this->mortgageDueDate2 = ArrayUtil::setField($obj, "mortgage_due_date_2");
        $this->mortgageInterestRate = ArrayUtil::setField($obj, "mortgage_interest_rate");
        $this->mortgageInterestRateType = ArrayUtil::setField($obj, "mortgage_interest_rate_type");
        $this->mortgageLenderCode = ArrayUtil::setField($obj, "mortgage_lender_code");
        $this->mortgageRate2 = ArrayUtil::setField($obj, "mortgage_rate_2");
        $this->mortgageRecordingDate = ArrayUtil::setField($obj, "mortgage_recording_date");
        $this->mortgageRecordingDate2 = ArrayUtil::setField($obj, "mortgage_recording_date_2");
        $this->mortgageTerm = ArrayUtil::setField($obj, "mortgage_term");
        $this->mortgageTerm2 = ArrayUtil::setField($obj, "mortgage_term_2");
        $this->mortgageTermType = ArrayUtil::setField($obj, "mortgage_term_type");
        $this->mortgageTermType2 = ArrayUtil::setField($obj, "mortgage_term_type_2");
        $this->mortgageType = ArrayUtil::setField($obj, "mortgage_type");
        $this->mortgageType2 = ArrayUtil::setField($obj, "mortgage_type_2");
        $this->msaCode = ArrayUtil::setField($obj, "msa_code");
        $this->msaName = ArrayUtil::setField($obj, "msa_name");
        $this->mudRoom = ArrayUtil::setField($obj, "mud_room");
        $this->multiParcelFlag = ArrayUtil::setField($obj, "multi_parcel_flag");
        $this->nameTitleCompany = ArrayUtil::setField($obj, "name_title_company");
        $this->neighborhoodCode = ArrayUtil::setField($obj, "neighborhood_code");
        $this->numberOfBuildings = ArrayUtil::setField($obj, "number_of_buildings");
        $this->office = ArrayUtil::setField($obj, "office");
        $this->officeSqft = ArrayUtil::setField($obj, "office_sqft");
        $this->otherTaxExemption = ArrayUtil::setField($obj, "other_tax_exemption");
        $this->outdoorKitchenFireplace = ArrayUtil::setField($obj, "outdoor_kitchen_fireplace");
        $this->overheadDoor = ArrayUtil::setField($obj, "overhead_door");
        $this->ownerFullName = ArrayUtil::setField($obj, "owner_full_name");
        $this->ownerFullName2 = ArrayUtil::setField($obj, "owner_full_name_2");
        $this->ownerFullName3 = ArrayUtil::setField($obj, "owner_full_name_3");
        $this->ownerFullName4 = ArrayUtil::setField($obj, "owner_full_name_4");
        $this->ownerOccupancyStatus = ArrayUtil::setField($obj, "owner_occupancy_status");
        $this->ownershipTransferDate = ArrayUtil::setField($obj, "ownership_transfer_date");
        $this->ownershipTransferDocNumber = ArrayUtil::setField($obj, "ownership_transfer_doc_number");
        $this->ownershipTransferTransactionId = ArrayUtil::setField($obj, "ownership_transfer_transaction_id");
        $this->ownershipType = ArrayUtil::setField($obj, "ownership_type");
        $this->ownershipType2 = ArrayUtil::setField($obj, "ownership_type_2");
        $this->ownershipVestingRelationCode = ArrayUtil::setField($obj, "ownership_vesting_relation_code");
        $this->parcelAccountNumber = ArrayUtil::setField($obj, "parcel_account_number");
        $this->parcelMapBook = ArrayUtil::setField($obj, "parcel_map_book");
        $this->parcelMapPage = ArrayUtil::setField($obj, "parcel_map_page");
        $this->parcelNumberAlternate = ArrayUtil::setField($obj, "parcel_number_alternate");
        $this->parcelNumberFormatted = ArrayUtil::setField($obj, "parcel_number_formatted");
        $this->parcelNumberPrevious = ArrayUtil::setField($obj, "parcel_number_previous");
        $this->parcelNumberYearAdded = ArrayUtil::setField($obj, "parcel_number_year_added");
        $this->parcelNumberYearChange = ArrayUtil::setField($obj, "parcel_number_year_change");
        $this->parcelRawNumber = ArrayUtil::setField($obj, "parcel_raw_number");
        $this->parcelShellRecord = ArrayUtil::setField($obj, "parcel_shell_record");
        $this->parkingSpaces = ArrayUtil::setField($obj, "parking_spaces");
        $this->patioArea = ArrayUtil::setField($obj, "patio_area");
        $this->phaseName = ArrayUtil::setField($obj, "phase_name");
        $this->plumbingFixturesCount = ArrayUtil::setField($obj, "plumbing_fixtures_count");
        $this->poleStruct = ArrayUtil::setField($obj, "pole_struct");
        $this->poleStructSqft = ArrayUtil::setField($obj, "pole_struct_sqft");
        $this->pond = ArrayUtil::setField($obj, "pond");
        $this->pool = ArrayUtil::setField($obj, "pool");
        $this->poolArea = ArrayUtil::setField($obj, "pool_area");
        $this->poolhouse = ArrayUtil::setField($obj, "poolhouse");
        $this->poolhouseSqft = ArrayUtil::setField($obj, "poolhouse_sqft");
        $this->porch = ArrayUtil::setField($obj, "porch");
        $this->porchArea = ArrayUtil::setField($obj, "porch_area");
        $this->poultryHouse = ArrayUtil::setField($obj, "poultry_house");
        $this->poultryHouseSqft = ArrayUtil::setField($obj, "poultry_house_sqft");
        $this->previousAssessedValue = ArrayUtil::setField($obj, "previous_assessed_value");
        $this->priorSaleAmount = ArrayUtil::setField($obj, "prior_sale_amount");
        $this->priorSaleDate = ArrayUtil::setField($obj, "prior_sale_date");
        $this->propertyAddressCarrierRouteCode = ArrayUtil::setField($obj, "property_address_carrier_route_code");
        $this->propertyAddressCity = ArrayUtil::setField($obj, "property_address_city");
        $this->propertyAddressFull = ArrayUtil::setField($obj, "property_address_full");
        $this->propertyAddressHouseNumber = ArrayUtil::setField($obj, "property_address_house_number");
        $this->propertyAddressPostDirection = ArrayUtil::setField($obj, "property_address_post_direction");
        $this->propertyAddressPreDirection = ArrayUtil::setField($obj, "property_address_pre_direction");
        $this->propertyAddressState = ArrayUtil::setField($obj, "property_address_state");
        $this->propertyAddressStreetName = ArrayUtil::setField($obj, "property_address_street_name");
        $this->propertyAddressStreetSuffix = ArrayUtil::setField($obj, "property_address_street_suffix");
        $this->propertyAddressUnitDesignator = ArrayUtil::setField($obj, "property_address_unit_designator");
        $this->propertyAddressUnitValue = ArrayUtil::setField($obj, "property_address_unit_value");
        $this->propertyAddressZip4 = ArrayUtil::setField($obj, "property_address_zip_4");
        $this->propertyAddressZipcode = ArrayUtil::setField($obj, "property_address_zipcode");
        $this->publicationDate = ArrayUtil::setField($obj, "publication_date");
        $this->quarter = ArrayUtil::setField($obj, "quarter");
        $this->quarterQuarter = ArrayUtil::setField($obj, "quarter_quarter");
        $this->quonset = ArrayUtil::setField($obj, "quonset");
        $this->quonsetSqft = ArrayUtil::setField($obj, "quonset_sqft");
        $this->range = ArrayUtil::setField($obj, "range");
        $this->recordingDate = ArrayUtil::setField($obj, "recording_date");
        $this->roofCover = ArrayUtil::setField($obj, "roof_cover");
        $this->roofFrame = ArrayUtil::setField($obj, "roof_frame");
        $this->rooms = ArrayUtil::setField($obj, "rooms");
        $this->rvParking = ArrayUtil::setField($obj, "rv_parking");
        $this->safeRoom = ArrayUtil::setField($obj, "safe_room");
        $this->saleAmount = ArrayUtil::setField($obj, "sale_amount");
        $this->saleDate = ArrayUtil::setField($obj, "sale_date");
        $this->sauna = ArrayUtil::setField($obj, "sauna");
        $this->section = ArrayUtil::setField($obj, "section");
        $this->securityAlarm = ArrayUtil::setField($obj, "security_alarm");
        $this->seniorTaxExemption = ArrayUtil::setField($obj, "senior_tax_exemption");
        $this->sewerType = ArrayUtil::setField($obj, "sewer_type");
        $this->shed = ArrayUtil::setField($obj, "shed");
        $this->shedSqft = ArrayUtil::setField($obj, "shed_sqft");
        $this->silo = ArrayUtil::setField($obj, "silo");
        $this->siloSqft = ArrayUtil::setField($obj, "silo_sqft");
        $this->sittingRoom = ArrayUtil::setField($obj, "sitting_room");
        $this->situsCounty = ArrayUtil::setField($obj, "situs_county");
        $this->situsState = ArrayUtil::setField($obj, "situs_state");
        $this->soundSystem = ArrayUtil::setField($obj, "sound_system");
        $this->sportsCourt = ArrayUtil::setField($obj, "sports_court");
        $this->sprinklers = ArrayUtil::setField($obj, "sprinklers");
        $this->stable = ArrayUtil::setField($obj, "stable");
        $this->stableSqft = ArrayUtil::setField($obj, "stable_sqft");
        $this->storageBuilding = ArrayUtil::setField($obj, "storage_building");
        $this->storageBuildingSqft = ArrayUtil::setField($obj, "storage_building_sqft");
        $this->storiesNumber = ArrayUtil::setField($obj, "stories_number");
        $this->stormShelter = ArrayUtil::setField($obj, "storm_shelter");
        $this->stormShutter = ArrayUtil::setField($obj, "storm_shutter");
        $this->structureStyle = ArrayUtil::setField($obj, "structure_style");
        $this->study = ArrayUtil::setField($obj, "study");
        $this->subdivision = ArrayUtil::setField($obj, "subdivision");
        $this->suffix = ArrayUtil::setField($obj, "suffix");
        $this->suffix2 = ArrayUtil::setField($obj, "suffix_2");
        $this->suffix3 = ArrayUtil::setField($obj, "suffix_3");
        $this->suffix4 = ArrayUtil::setField($obj, "suffix_4");
        $this->sunroom = ArrayUtil::setField($obj, "sunroom");
        $this->taxAssessYear = ArrayUtil::setField($obj, "tax_assess_year");
        $this->taxBilledAmount = ArrayUtil::setField($obj, "tax_billed_amount");
        $this->taxDelinquentYear = ArrayUtil::setField($obj, "tax_delinquent_year");
        $this->taxFiscalYear = ArrayUtil::setField($obj, "tax_fiscal_year");
        $this->taxJurisdiction = ArrayUtil::setField($obj, "tax_jurisdiction");
        $this->taxRateArea = ArrayUtil::setField($obj, "tax_rate_area");
        $this->tennisCourt = ArrayUtil::setField($obj, "tennis_court");
        $this->topographyCode = ArrayUtil::setField($obj, "topography_code");
        $this->totalMarketValue = ArrayUtil::setField($obj, "total_market_value");
        $this->township = ArrayUtil::setField($obj, "township");
        $this->tractNumber = ArrayUtil::setField($obj, "tract_number");
        $this->transferAmount = ArrayUtil::setField($obj, "transfer_amount");
        $this->trustDescription = ArrayUtil::setField($obj, "trust_description");
        $this->unitCount = ArrayUtil::setField($obj, "unit_count");
        $this->upperFloorsSqft = ArrayUtil::setField($obj, "upper_floors_sqft");
        $this->utility = ArrayUtil::setField($obj, "utility");
        $this->utilityBuilding = ArrayUtil::setField($obj, "utility_building");
        $this->utilityBuildingSqft = ArrayUtil::setField($obj, "utility_building_sqft");
        $this->utilitySqft = ArrayUtil::setField($obj, "utility_sqft");
        $this->veteranTaxExemption = ArrayUtil::setField($obj, "veteran_tax_exemption");
        $this->viewDescription = ArrayUtil::setField($obj, "view_description");
        $this->waterFeature = ArrayUtil::setField($obj, "water_feature");
        $this->waterServiceType = ArrayUtil::setField($obj, "water_service_type");
        $this->wetBar = ArrayUtil::setField($obj, "wet_bar");
        $this->widowTaxExemption = ArrayUtil::setField($obj, "widow_tax_exemption");
        $this->widthLinearFootage = ArrayUtil::setField($obj, "width_linear_footage");
        $this->wineCellar = ArrayUtil::setField($obj, "wine_cellar");
        $this->yearBuilt = ArrayUtil::setField($obj, "year_built");
        $this->zoning = ArrayUtil::setField($obj, "zoning");

    }
}