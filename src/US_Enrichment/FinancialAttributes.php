<?php
namespace SmartyStreets\PhpSdk\US_Enrichment;
use SmartyStreets\PhpSdk\ArrayUtil;

require_once(__DIR__ . '/FinancialHistoryEntry.php');

class FinancialAttributes {

    //region [ Fields ]

    public $assessedImprovementPercent,
    $assessedImprovementValue,
    $assessedLandValue,
    $assessedValue,
    $assessorLastUpdate,
    $assessorTaxrollUpdate,
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
    $disabledTaxExemption,
    $financialHistory,
    $firstName,
    $firstName2,
    $firstName3,
    $firstName4,
    $homeownerTaxExemption,
    $lastName,
    $lastName2,
    $lastName3,
    $lastName4,
    $marketImprovementPercent,
    $marketImprovementValue,
    $marketLandValue,
    $marketValueYear,
    $matchType,
    $middleName,
    $middleName2,
    $middleName3,
    $middleName4,
    $otherTaxExemption,
    $ownerFullName,
    $ownerFullName2,
    $ownerFullName3,
    $ownerFullName4,
    $ownershipTransferDate,
    $ownershipTransferDocNumber,
    $ownershipTransferTransactionId,
    $ownershipType,
    $ownershipType2,
    $previousAssessedValue,
    $priorSaleAmount,
    $priorSaleDate,
    $saleAmount,
    $saleDate,
    $seniorTaxExemption,
    $suffix,
    $suffix2,
    $suffix3,
    $suffix4,
    $taxAssessYear,
    $taxBilledAmount,
    $taxDelinquentYear,
    $taxFiscalYear,
    $taxRateArea,
    $totalMarketValue,
    $trustDescription,
    $veteranTaxExemption,
    $widowTaxExemption;

    //endregion

    public function __construct($obj = null) {
        if ($obj == null)
            return;
        $this->assessedImprovementPercent = ArrayUtil::getField($obj, "assessed_improvement_percent");
        $this->assessedImprovementValue = ArrayUtil::getField($obj, "assessed_improvement_value");
        $this->assessedLandValue = ArrayUtil::getField($obj, "assessed_land_value");
        $this->assessedValue = ArrayUtil::getField($obj, "assessed_value");
        $this->assessorLastUpdate = ArrayUtil::getField($obj, "assessor_last_update");
        $this->assessorTaxrollUpdate = ArrayUtil::getField($obj, "assessor_taxroll_update");
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
        $this->deedDocumentPage = ArrayUtil::getField($obj, "deed_document_page");
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
        $this->disabledTaxExemption = ArrayUtil::getField($obj, "disabled_tax_exemption");
        $this->createFinancialHistory(ArrayUtil::getField($obj, "financial_history"));
        $this->firstName = ArrayUtil::getField($obj, "first_name");
        $this->firstName2 = ArrayUtil::getField($obj, "first_name_2");
        $this->firstName3 = ArrayUtil::getField($obj, "first_name_3");
        $this->firstName4 = ArrayUtil::getField($obj, "first_name_4");
        $this->homeownerTaxExemption = ArrayUtil::getField($obj, "homeowner_tax_exemption");
        $this->lastName = ArrayUtil::getField($obj, "last_name");
        $this->lastName2 = ArrayUtil::getField($obj, "last_name_2");
        $this->lastName3 = ArrayUtil::getField($obj, "last_name_3");
        $this->lastName4 = ArrayUtil::getField($obj, "last_name_4");
        $this->marketImprovementPercent = ArrayUtil::getField($obj, "market_improvement_percent");
        $this->marketImprovementValue = ArrayUtil::getField($obj, "market_improvement_value");
        $this->marketLandValue = ArrayUtil::getField($obj, "market_land_value");
        $this->marketValueYear = ArrayUtil::getField($obj, "market_value_year");
        $this->matchType = ArrayUtil::getField($obj, "match_type");
        $this->middleName = ArrayUtil::getField($obj, "middle_name");
        $this->middleName2 = ArrayUtil::getField($obj, "middle_name_2");
        $this->middleName3 = ArrayUtil::getField($obj, "middle_name_3");
        $this->middleName4 = ArrayUtil::getField($obj, "middle_name_4");
        $this->otherTaxExemption = ArrayUtil::getField($obj, "other_tax_exemption");
        $this->ownerFullName = ArrayUtil::getField($obj, "owner_full_name");
        $this->ownerFullName2 = ArrayUtil::getField($obj, "owner_full_name_2");
        $this->ownerFullName3 = ArrayUtil::getField($obj, "owner_full_name_3");
        $this->ownerFullName4 = ArrayUtil::getField($obj, "owner_full_name_4");
        $this->ownershipTransferDate = ArrayUtil::getField($obj, "ownership_transfer_date");
        $this->ownershipTransferDocNumber = ArrayUtil::getField($obj, "ownership_transfer_doc_number");
        $this->ownershipTransferTransactionId = ArrayUtil::getField($obj, "ownership_transfer_transaction_id");
        $this->ownershipType = ArrayUtil::getField($obj, "ownership_type");
        $this->ownershipType2 = ArrayUtil::getField($obj, "ownership_type_2");
        $this->previousAssessedValue = ArrayUtil::getField($obj, "previous_assessed_value");
        $this->priorSaleAmount = ArrayUtil::getField($obj, "prior_sale_amount");
        $this->priorSaleDate = ArrayUtil::getField($obj, "prior_sale_date");
        $this->saleAmount = ArrayUtil::getField($obj, "sale_amount");
        $this->saleDate = ArrayUtil::getField($obj, "sale_date");
        $this->seniorTaxExemption = ArrayUtil::getField($obj, "senior_tax_exemption");
        $this->suffix = ArrayUtil::getField($obj, "suffix");
        $this->suffix2 = ArrayUtil::getField($obj, "suffix_2");
        $this->suffix3 = ArrayUtil::getField($obj, "suffix_3");
        $this->suffix4 = ArrayUtil::getField($obj, "suffix_4");
        $this->taxAssessYear = ArrayUtil::getField($obj, "tax_assess_year");
        $this->taxBilledAmount = ArrayUtil::getField($obj, "tax_billed_amount");
        $this->taxDelinquentYear = ArrayUtil::getField($obj, "tax_delinquent_year");
        $this->taxFiscalYear = ArrayUtil::getField($obj, "tax_fiscal_year");
        $this->taxRateArea = ArrayUtil::getField($obj, "tax_rate_area");
        $this->totalMarketValue = ArrayUtil::getField($obj, "total_market_value");
        $this->trustDescription = ArrayUtil::getField($obj, "trust_description");
        $this->veteranTaxExemption = ArrayUtil::getField($obj, "veteran_tax_exemption");
        $this->widowTaxExemption = ArrayUtil::getField($obj, "widow_tax_exemption");
    }

    private function createFinancialHistory($financialHistoryArray){
        foreach($financialHistoryArray as $value){
            $this->financialHistory[] = new FinancialHistoryEntry($value);
        }
    }
}