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
        $this->assessedImprovementPercent = ArrayUtil::setField($obj, "assessed_improvement_percent");
        $this->assessedImprovementValue = ArrayUtil::setField($obj, "assessed_improvement_value");
        $this->assessedLandValue = ArrayUtil::setField($obj, "assessed_land_value");
        $this->assessedValue = ArrayUtil::setField($obj, "assessed_value");
        $this->assessorLastUpdate = ArrayUtil::setField($obj, "assessor_last_update");
        $this->assessorTaxrollUpdate = ArrayUtil::setField($obj, "assessor_taxroll_update");
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
        $this->deedDocumentPage = ArrayUtil::setField($obj, "deed_document_page");
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
        $this->disabledTaxExemption = ArrayUtil::setField($obj, "disabled_tax_exemption");
        $this->createFinancialHistory(ArrayUtil::setField($obj, "financial_history"));
        $this->firstName = ArrayUtil::setField($obj, "first_name");
        $this->firstName2 = ArrayUtil::setField($obj, "first_name_2");
        $this->firstName3 = ArrayUtil::setField($obj, "first_name_3");
        $this->firstName4 = ArrayUtil::setField($obj, "first_name_4");
        $this->homeownerTaxExemption = ArrayUtil::setField($obj, "homeowner_tax_exemption");
        $this->lastName = ArrayUtil::setField($obj, "last_name");
        $this->lastName2 = ArrayUtil::setField($obj, "last_name_2");
        $this->lastName3 = ArrayUtil::setField($obj, "last_name_3");
        $this->lastName4 = ArrayUtil::setField($obj, "last_name_4");
        $this->marketImprovementPercent = ArrayUtil::setField($obj, "market_improvement_percent");
        $this->marketImprovementValue = ArrayUtil::setField($obj, "market_improvement_value");
        $this->marketLandValue = ArrayUtil::setField($obj, "market_land_value");
        $this->marketValueYear = ArrayUtil::setField($obj, "market_value_year");
        $this->matchType = ArrayUtil::setField($obj, "match_type");
        $this->middleName = ArrayUtil::setField($obj, "middle_name");
        $this->middleName2 = ArrayUtil::setField($obj, "middle_name_2");
        $this->middleName3 = ArrayUtil::setField($obj, "middle_name_3");
        $this->middleName4 = ArrayUtil::setField($obj, "middle_name_4");
        $this->otherTaxExemption = ArrayUtil::setField($obj, "other_tax_exemption");
        $this->ownerFullName = ArrayUtil::setField($obj, "owner_full_name");
        $this->ownerFullName2 = ArrayUtil::setField($obj, "owner_full_name_2");
        $this->ownerFullName3 = ArrayUtil::setField($obj, "owner_full_name_3");
        $this->ownerFullName4 = ArrayUtil::setField($obj, "owner_full_name_4");
        $this->ownershipTransferDate = ArrayUtil::setField($obj, "ownership_transfer_date");
        $this->ownershipTransferDocNumber = ArrayUtil::setField($obj, "ownership_transfer_doc_number");
        $this->ownershipTransferTransactionId = ArrayUtil::setField($obj, "ownership_transfer_transaction_id");
        $this->ownershipType = ArrayUtil::setField($obj, "ownership_type");
        $this->ownershipType2 = ArrayUtil::setField($obj, "ownership_type_2");
        $this->previousAssessedValue = ArrayUtil::setField($obj, "previous_assessed_value");
        $this->priorSaleAmount = ArrayUtil::setField($obj, "prior_sale_amount");
        $this->priorSaleDate = ArrayUtil::setField($obj, "prior_sale_date");
        $this->saleAmount = ArrayUtil::setField($obj, "sale_amount");
        $this->saleDate = ArrayUtil::setField($obj, "sale_date");
        $this->seniorTaxExemption = ArrayUtil::setField($obj, "senior_tax_exemption");
        $this->suffix = ArrayUtil::setField($obj, "suffix");
        $this->suffix2 = ArrayUtil::setField($obj, "suffix_2");
        $this->suffix3 = ArrayUtil::setField($obj, "suffix_3");
        $this->suffix4 = ArrayUtil::setField($obj, "suffix_4");
        $this->taxAssessYear = ArrayUtil::setField($obj, "tax_assess_year");
        $this->taxBilledAmount = ArrayUtil::setField($obj, "tax_billed_amount");
        $this->taxDelinquentYear = ArrayUtil::setField($obj, "tax_delinquent_year");
        $this->taxFiscalYear = ArrayUtil::setField($obj, "tax_fiscal_year");
        $this->taxRateArea = ArrayUtil::setField($obj, "tax_rate_area");
        $this->totalMarketValue = ArrayUtil::setField($obj, "total_market_value");
        $this->trustDescription = ArrayUtil::setField($obj, "trust_description");
        $this->veteranTaxExemption = ArrayUtil::setField($obj, "veteran_tax_exemption");
        $this->widowTaxExemption = ArrayUtil::setField($obj, "widow_tax_exemption");
    }

    private function createFinancialHistory($financialHistoryArray){
        foreach($financialHistoryArray as $value){
            $this->financialHistory[] = new FinancialHistoryEntry($value);
        }
    }
}