<?php

namespace SmartyStreets\PhpSdk\US_Enrichment;
use SmartyStreets\PhpSdk\ArrayUtil;

class FinancialHistoryEntry {
    //region [ Fields ]

    public $codeTitleCompany,
    $documentTypeDescription,
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

    public function __construct($obj = null){
        if ($obj == null)
            return;
        $this->codeTitleCompany = ArrayUtil::getField($obj, "code_title_company");
        $this->documentTypeDescription = ArrayUtil::getField($obj, "document_type_description");
        $this->instrumentDate = ArrayUtil::getField($obj, "instrument_date");
        $this->interestRateType2 = ArrayUtil::getField($obj, "interest_rate_type_2");
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
        $this->multiParcelFlag = ArrayUtil::getField($obj, "multi_parcel_flag");
        $this->nameTitleCompany = ArrayUtil::getField($obj, "name_title_company");
        $this->recordingDate = ArrayUtil::getField($obj, "recording_date");
        $this->transferAmount = ArrayUtil::getField($obj, "transfer_amount");
    }
}