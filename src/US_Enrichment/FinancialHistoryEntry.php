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
        $this->codeTitleCompany = ArrayUtil::setField($obj, "code_title_company");
        $this->documentTypeDescription = ArrayUtil::setField($obj, "document_type_description");
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