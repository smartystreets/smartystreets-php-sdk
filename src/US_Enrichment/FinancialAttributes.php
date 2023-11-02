<?php
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
        $this->financialHistory = new FinancialHistory(ArrayUtil::setField($obj, "financial_history"));
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
}

class FinancialHistory {
    //region [ Fields ]

    public $codeTitleCompany,
    $instrumentDate,
    $interestRateType2,
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
    $multiParcelFlag,
    $nameTitleCompany,
    $recordingDate,
    $transferAmount;

    //endregion

    public __construct($obj = null){
        if ($obj == null)
            return;
        $this->codeTitleCompany = ArrayUtil::setField($obj, "code_title_company");
        $this->instrumentDate = ArrayUtil::setField($obj, "instrument_date");
        $this->interestRateType2 = ArrayUtil::setField($obj, "interest_rate_type_2");
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
        $this->multiParcelFlag = ArrayUtil::setField($obj, "multi_parcel_flag");
        $this->nameTitleCompany = ArrayUtil::setField($obj, "name_title_company");
        $this->recordingDate = ArrayUtil::setField($obj, "recording_date");
        $this->transferAmount = ArrayUtil::setField($obj, "transfer_amount");
    }
}