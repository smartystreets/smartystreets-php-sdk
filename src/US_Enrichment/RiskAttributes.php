<?php
namespace SmartyStreets\PhpSdk\US_Enrichment;

require_once(__DIR__ . '/../ArrayUtil.php');
use SmartyStreets\PhpSdk\ArrayUtil;

class RiskAttributes {

    //region [ Fields ]

    public $AGRIVALUE,
    $ALR_NPCTL,
    $ALR_VALA,
    $ALR_VALB,
    $ALR_VALP,
    $ALR_VRA_NPCTL,
    $AREA,
    $AVLN_AFREQ,
    $AVLN_ALRB,
    $AVLN_ALRP,
    $AVLN_ALR_NPCTL,
    $AVLN_EALB,
    $AVLN_EALP,
    $AVLN_EALPE,
    $AVLN_EALR,
    $AVLN_EALS,
    $AVLN_EALT,
    $AVLN_EVNTS,
    $AVLN_EXPB,
    $AVLN_EXPP,
    $AVLN_EXPPE,
    $AVLN_EXPT,
    $AVLN_EXP_AREA,
    $AVLN_HLRB,
    $AVLN_HLRP,
    $AVLN_HLRR,
    $AVLN_RISKR,
    $AVLN_RISKS,
    $AVLN_RISKV,
    $BUILDVALUE,
    $CFLD_AFREQ,
    $CFLD_ALRB,
    $CFLD_ALRP,
    $CFLD_ALR_NPCTL,
    $CFLD_EALB,
    $CFLD_EALP,
    $CFLD_EALPE,
    $CFLD_EALR,
    $CFLD_EALS,
    $CFLD_EALT,
    $CFLD_EVNTS,
    $CFLD_EXPB,
    $CFLD_EXPP,
    $CFLD_EXPPE,
    $CFLD_EXPT,
    $CFLD_EXP_AREA,
    $CFLD_HLRB,
    $CFLD_HLRP,
    $CFLD_HLRR,
    $CFLD_RISKR,
    $CFLD_RISKS,
    $CFLD_RISKV,
    $COUNTY,
    $COUNTYFIPS,
    $COUNTYTYPE,
    $CRF_VALUE,
    $CWAV_AFREQ,
    $CWAV_ALRA,
    $CWAV_ALRB,
    $CWAV_ALRP,
    $CWAV_ALR_NPCTL,
    $CWAV_EALA,
    $CWAV_EALB,
    $CWAV_EALP,
    $CWAV_EALPE,
    $CWAV_EALR,
    $CWAV_EALS,
    $CWAV_EALT,
    $CWAV_EVNTS,
    $CWAV_EXPA,
    $CWAV_EXPB,
    $CWAV_EXPP,
    $CWAV_EXPPE,
    $CWAV_EXPT,
    $CWAV_EXP_AREA,
    $CWAV_HLRA,
    $CWAV_HLRB,
    $CWAV_HLRP,
    $CWAV_HLRR,
    $CWAV_RISKR,
    $CWAV_RISKS,
    $CWAV_RISKV,
    $DRGT_AFREQ,
    $DRGT_ALRA,
    $DRGT_ALR_NPCTL,
    $DRGT_EALA,
    $DRGT_EALR,
    $DRGT_EALS,
    $DRGT_EALT,
    $DRGT_EVNTS,
    $DRGT_EXPA,
    $DRGT_EXPT,
    $DRGT_EXP_AREA,
    $DRGT_HLRA,
    $DRGT_HLRR,
    $DRGT_RISKR,
    $DRGT_RISKS,
    $DRGT_RISKV,
    $EAL_RATNG,
    $EAL_SCORE,
    $EAL_SPCTL,
    $EAL_VALA,
    $EAL_VALB,
    $EAL_VALP,
    $EAL_VALPE,
    $EAL_VALT,
    $ERQK_AFREQ,
    $ERQK_ALRB,
    $ERQK_ALRP,
    $ERQK_ALR_NPCTL,
    $ERQK_EALB,
    $ERQK_EALP,
    $ERQK_EALPE,
    $ERQK_EALR,
    $ERQK_EALS,
    $ERQK_EALT,
    $ERQK_EVNTS,
    $ERQK_EXPB,
    $ERQK_EXPP,
    $ERQK_EXPPE,
    $ERQK_EXPT,
    $ERQK_EXP_AREA,
    $ERQK_HLRB,
    $ERQK_HLRP,
    $ERQK_HLRR,
    $ERQK_RISKR,
    $ERQK_RISKS,
    $ERQK_RISKV,
    $HAIL_AFREQ,
    $HAIL_ALRA,
    $HAIL_ALRB,
    $HAIL_ALRP,
    $HAIL_ALR_NPCTL,
    $HAIL_EALA,
    $HAIL_EALB,
    $HAIL_EALP,
    $HAIL_EALPE,
    $HAIL_EALR,
    $HAIL_EALS,
    $HAIL_EALT,
    $HAIL_EVNTS,
    $HAIL_EXPA,
    $HAIL_EXPB,
    $HAIL_EXPP,
    $HAIL_EXPPE,
    $HAIL_EXPT,
    $HAIL_EXP_AREA,
    $HAIL_HLRA,
    $HAIL_HLRB,
    $HAIL_HLRP,
    $HAIL_HLRR,
    $HAIL_RISKR,
    $HAIL_RISKS,
    $HAIL_RISKV,
    $HRCN_AFREQ,
    $HRCN_ALRA,
    $HRCN_ALRB,
    $HRCN_ALRP,
    $HRCN_ALR_NPCTL,
    $HRCN_EALA,
    $HRCN_EALB,
    $HRCN_EALP,
    $HRCN_EALPE,
    $HRCN_EALR,
    $HRCN_EALS,
    $HRCN_EALT,
    $HRCN_EVNTS,
    $HRCN_EXPA,
    $HRCN_EXPB,
    $HRCN_EXPP,
    $HRCN_EXPPE,
    $HRCN_EXPT,
    $HRCN_EXP_AREA,
    $HRCN_HLRA,
    $HRCN_HLRB,
    $HRCN_HLRP,
    $HRCN_HLRR,
    $HRCN_RISKR,
    $HRCN_RISKS,
    $HRCN_RISKV,
    $HWAV_AFREQ,
    $HWAV_ALRA,
    $HWAV_ALRB,
    $HWAV_ALRP,
    $HWAV_ALR_NPCTL,
    $HWAV_EALA,
    $HWAV_EALB,
    $HWAV_EALP,
    $HWAV_EALPE,
    $HWAV_EALR,
    $HWAV_EALS,
    $HWAV_EALT,
    $HWAV_EVNTS,
    $HWAV_EXPA,
    $HWAV_EXPB,
    $HWAV_EXPP,
    $HWAV_EXPPE,
    $HWAV_EXPT,
    $HWAV_EXP_AREA,
    $HWAV_HLRA,
    $HWAV_HLRB,
    $HWAV_HLRP,
    $HWAV_HLRR,
    $HWAV_RISKR,
    $HWAV_RISKS,
    $HWAV_RISKV,
    $ISTM_AFREQ,
    $ISTM_ALRB,
    $ISTM_ALRP,
    $ISTM_ALR_NPCTL,
    $ISTM_EALB,
    $ISTM_EALP,
    $ISTM_EALPE,
    $ISTM_EALR,
    $ISTM_EALS,
    $ISTM_EALT,
    $ISTM_EVNTS,
    $ISTM_EXPB,
    $ISTM_EXPP,
    $ISTM_EXPPE,
    $ISTM_EXPT,
    $ISTM_EXP_AREA,
    $ISTM_HLRB,
    $ISTM_HLRP,
    $ISTM_HLRR,
    $ISTM_RISKR,
    $ISTM_RISKS,
    $ISTM_RISKV,
    $LNDS_AFREQ,
    $LNDS_ALRB,
    $LNDS_ALRP,
    $LNDS_ALR_NPCTL,
    $LNDS_EALB,
    $LNDS_EALP,
    $LNDS_EALPE,
    $LNDS_EALR,
    $LNDS_EALS,
    $LNDS_EALT,
    $LNDS_EVNTS,
    $LNDS_EXPB,
    $LNDS_EXPP,
    $LNDS_EXPPE,
    $LNDS_EXPT,
    $LNDS_EXP_AREA,
    $LNDS_HLRB,
    $LNDS_HLRP,
    $LNDS_HLRR,
    $LNDS_RISKR,
    $LNDS_RISKS,
    $LNDS_RISKV,
    $LTNG_AFREQ,
    $LTNG_ALRB,
    $LTNG_ALRP,
    $LTNG_ALR_NPCTL,
    $LTNG_EALB,
    $LTNG_EALP,
    $LTNG_EALPE,
    $LTNG_EALR,
    $LTNG_EALS,
    $LTNG_EALT,
    $LTNG_EVNTS,
    $LTNG_EXPB,
    $LTNG_EXPP,
    $LTNG_EXPPE,
    $LTNG_EXPT,
    $LTNG_EXP_AREA,
    $LTNG_HLRB,
    $LTNG_HLRP,
    $LTNG_HLRR,
    $LTNG_RISKR,
    $LTNG_RISKS,
    $LTNG_RISKV,
    $NRI_VER,
    $POPULATION,
    $RESL_RATNG,
    $RESL_SCORE,
    $RESL_SPCTL,
    $RESL_VALUE,
    $RFLD_AFREQ,
    $RFLD_ALRA,
    $RFLD_ALRB,
    $RFLD_ALRP,
    $RFLD_ALR_NPCTL,
    $RFLD_EALA,
    $RFLD_EALB,
    $RFLD_EALP,
    $RFLD_EALPE,
    $RFLD_EALR,
    $RFLD_EALS,
    $RFLD_EALT,
    $RFLD_EVNTS,
    $RFLD_EXPA,
    $RFLD_EXPB,
    $RFLD_EXPP,
    $RFLD_EXPPE,
    $RFLD_EXPT,
    $RFLD_EXP_AREA,
    $RFLD_HLRA,
    $RFLD_HLRB,
    $RFLD_HLRP,
    $RFLD_HLRR,
    $RFLD_RISKR,
    $RFLD_RISKS,
    $RFLD_RISKV,
    $RISK_RATNG,
    $RISK_SCORE,
    $RISK_SPCTL,
    $RISK_VALUE,
    $SOVI_RATNG,
    $SOVI_SCORE,
    $SOVI_SPCTL,
    $STATE,
    $STATEABBRV,
    $STATEFIPS,
    $STCOFIPS,
    $SWND_AFREQ,
    $SWND_ALRA,
    $SWND_ALRB,
    $SWND_ALRP,
    $SWND_ALR_NPCTL,
    $SWND_EALA,
    $SWND_EALB,
    $SWND_EALP,
    $SWND_EALPE,
    $SWND_EALR,
    $SWND_EALS,
    $SWND_EALT,
    $SWND_EVNTS,
    $SWND_EXPA,
    $SWND_EXPB,
    $SWND_EXPP,
    $SWND_EXPPE,
    $SWND_EXPT,
    $SWND_EXP_AREA,
    $SWND_HLRA,
    $SWND_HLRB,
    $SWND_HLRP,
    $SWND_HLRR,
    $SWND_RISKR,
    $SWND_RISKS,
    $SWND_RISKV,
    $TRACT,
    $TRACTFIPS,
    $TRND_AFREQ,
    $TRND_ALRA,
    $TRND_ALRB,
    $TRND_ALRP,
    $TRND_ALR_NPCTL,
    $TRND_EALA,
    $TRND_EALB,
    $TRND_EALP,
    $TRND_EALPE,
    $TRND_EALR,
    $TRND_EALS,
    $TRND_EALT,
    $TRND_EVNTS,
    $TRND_EXPA,
    $TRND_EXPB,
    $TRND_EXPP,
    $TRND_EXPPE,
    $TRND_EXPT,
    $TRND_EXP_AREA,
    $TRND_HLRA,
    $TRND_HLRB,
    $TRND_HLRP,
    $TRND_HLRR,
    $TRND_RISKR,
    $TRND_RISKS,
    $TRND_RISKV,
    $TSUN_AFREQ,
    $TSUN_ALRB,
    $TSUN_ALRP,
    $TSUN_ALR_NPCTL,
    $TSUN_EALB,
    $TSUN_EALP,
    $TSUN_EALPE,
    $TSUN_EALR,
    $TSUN_EALS,
    $TSUN_EALT,
    $TSUN_EVNTS,
    $TSUN_EXPB,
    $TSUN_EXPP,
    $TSUN_EXPPE,
    $TSUN_EXPT,
    $TSUN_EXP_AREA,
    $TSUN_HLRB,
    $TSUN_HLRP,
    $TSUN_HLRR,
    $TSUN_RISKR,
    $TSUN_RISKS,
    $TSUN_RISKV,
    $VLCN_AFREQ,
    $VLCN_ALRB,
    $VLCN_ALRP,
    $VLCN_ALR_NPCTL,
    $VLCN_EALB,
    $VLCN_EALP,
    $VLCN_EALPE,
    $VLCN_EALR,
    $VLCN_EALS,
    $VLCN_EALT,
    $VLCN_EVNTS,
    $VLCN_EXPB,
    $VLCN_EXPP,
    $VLCN_EXPPE,
    $VLCN_EXPT,
    $VLCN_EXP_AREA,
    $VLCN_HLRB,
    $VLCN_HLRP,
    $VLCN_HLRR,
    $VLCN_RISKR,
    $VLCN_RISKS,
    $VLCN_RISKV,
    $WFIR_AFREQ,
    $WFIR_ALRA,
    $WFIR_ALRB,
    $WFIR_ALRP,
    $WFIR_ALR_NPCTL,
    $WFIR_EALA,
    $WFIR_EALB,
    $WFIR_EALP,
    $WFIR_EALPE,
    $WFIR_EALR,
    $WFIR_EALS,
    $WFIR_EALT,
    $WFIR_EVNTS,
    $WFIR_EXPA,
    $WFIR_EXPB,
    $WFIR_EXPP,
    $WFIR_EXPPE,
    $WFIR_EXPT,
    $WFIR_EXP_AREA,
    $WFIR_HLRA,
    $WFIR_HLRB,
    $WFIR_HLRP,
    $WFIR_HLRR,
    $WFIR_RISKR,
    $WFIR_RISKS,
    $WFIR_RISKV,
    $WNTW_AFREQ,
    $WNTW_ALRA,
    $WNTW_ALRB,
    $WNTW_ALRP,
    $WNTW_ALR_NPCTL,
    $WNTW_EALA,
    $WNTW_EALB,
    $WNTW_EALP,
    $WNTW_EALPE,
    $WNTW_EALR,
    $WNTW_EALS,
    $WNTW_EALT,
    $WNTW_EVNTS,
    $WNTW_EXPA,
    $WNTW_EXPB,
    $WNTW_EXPP,
    $WNTW_EXPPE,
    $WNTW_EXPT,
    $WNTW_EXP_AREA,
    $WNTW_HLRA,
    $WNTW_HLRB,
    $WNTW_HLRP,
    $WNTW_HLRR,
    $WNTW_RISKR,
    $WNTW_RISKS,
    $WNTW_RISKV;

    //endregion

    public function __construct($obj = null) {
        if ($obj == null)
            return;
        $this->AGRIVALUE = ArrayUtil::getField($obj, "AGRIVALUE");
        $this->ALR_NPCTL = ArrayUtil::getField($obj, "ALR_NPCTL");
        $this->ALR_VALA = ArrayUtil::getField($obj, "ALR_VALA");
        $this->ALR_VALB = ArrayUtil::getField($obj, "ALR_VALB");
        $this->ALR_VALP = ArrayUtil::getField($obj, "ALR_VALP");
        $this->ALR_VRA_NPCTL = ArrayUtil::getField($obj, "ALR_VRA_NPCTL");
        $this->AREA = ArrayUtil::getField($obj, "AREA");
        $this->AVLN_AFREQ = ArrayUtil::getField($obj, "AVLN_AFREQ");
        $this->AVLN_ALRB = ArrayUtil::getField($obj, "AVLN_ALRB");
        $this->AVLN_ALRP = ArrayUtil::getField($obj, "AVLN_ALRP");
        $this->AVLN_ALR_NPCTL = ArrayUtil::getField($obj, "AVLN_ALR_NPCTL");
        $this->AVLN_EALB = ArrayUtil::getField($obj, "AVLN_EALB");
        $this->AVLN_EALP = ArrayUtil::getField($obj, "AVLN_EALP");
        $this->AVLN_EALPE = ArrayUtil::getField($obj, "AVLN_EALPE");
        $this->AVLN_EALR = ArrayUtil::getField($obj, "AVLN_EALR");
        $this->AVLN_EALS = ArrayUtil::getField($obj, "AVLN_EALS");
        $this->AVLN_EALT = ArrayUtil::getField($obj, "AVLN_EALT");
        $this->AVLN_EVNTS = ArrayUtil::getField($obj, "AVLN_EVNTS");
        $this->AVLN_EXPB = ArrayUtil::getField($obj, "AVLN_EXPB");
        $this->AVLN_EXPP = ArrayUtil::getField($obj, "AVLN_EXPP");
        $this->AVLN_EXPPE = ArrayUtil::getField($obj, "AVLN_EXPPE");
        $this->AVLN_EXPT = ArrayUtil::getField($obj, "AVLN_EXPT");
        $this->AVLN_EXP_AREA = ArrayUtil::getField($obj, "AVLN_EXP_AREA");
        $this->AVLN_HLRB = ArrayUtil::getField($obj, "AVLN_HLRB");
        $this->AVLN_HLRP = ArrayUtil::getField($obj, "AVLN_HLRP");
        $this->AVLN_HLRR = ArrayUtil::getField($obj, "AVLN_HLRR");
        $this->AVLN_RISKR = ArrayUtil::getField($obj, "AVLN_RISKR");
        $this->AVLN_RISKS = ArrayUtil::getField($obj, "AVLN_RISKS");
        $this->AVLN_RISKV = ArrayUtil::getField($obj, "AVLN_RISKV");
        $this->BUILDVALUE = ArrayUtil::getField($obj, "BUILDVALUE");
        $this->CFLD_AFREQ = ArrayUtil::getField($obj, "CFLD_AFREQ");
        $this->CFLD_ALRB = ArrayUtil::getField($obj, "CFLD_ALRB");
        $this->CFLD_ALRP = ArrayUtil::getField($obj, "CFLD_ALRP");
        $this->CFLD_ALR_NPCTL = ArrayUtil::getField($obj, "CFLD_ALR_NPCTL");
        $this->CFLD_EALB = ArrayUtil::getField($obj, "CFLD_EALB");
        $this->CFLD_EALP = ArrayUtil::getField($obj, "CFLD_EALP");
        $this->CFLD_EALPE = ArrayUtil::getField($obj, "CFLD_EALPE");
        $this->CFLD_EALR = ArrayUtil::getField($obj, "CFLD_EALR");
        $this->CFLD_EALS = ArrayUtil::getField($obj, "CFLD_EALS");
        $this->CFLD_EALT = ArrayUtil::getField($obj, "CFLD_EALT");
        $this->CFLD_EVNTS = ArrayUtil::getField($obj, "CFLD_EVNTS");
        $this->CFLD_EXPB = ArrayUtil::getField($obj, "CFLD_EXPB");
        $this->CFLD_EXPP = ArrayUtil::getField($obj, "CFLD_EXPP");
        $this->CFLD_EXPPE = ArrayUtil::getField($obj, "CFLD_EXPPE");
        $this->CFLD_EXPT = ArrayUtil::getField($obj, "CFLD_EXPT");
        $this->CFLD_EXP_AREA = ArrayUtil::getField($obj, "CFLD_EXP_AREA");
        $this->CFLD_HLRB = ArrayUtil::getField($obj, "CFLD_HLRB");
        $this->CFLD_HLRP = ArrayUtil::getField($obj, "CFLD_HLRP");
        $this->CFLD_HLRR = ArrayUtil::getField($obj, "CFLD_HLRR");
        $this->CFLD_RISKR = ArrayUtil::getField($obj, "CFLD_RISKR");
        $this->CFLD_RISKS = ArrayUtil::getField($obj, "CFLD_RISKS");
        $this->CFLD_RISKV = ArrayUtil::getField($obj, "CFLD_RISKV");
        $this->COUNTY = ArrayUtil::getField($obj, "COUNTY");
        $this->COUNTYFIPS = ArrayUtil::getField($obj, "COUNTYFIPS");
        $this->COUNTYTYPE = ArrayUtil::getField($obj, "COUNTYTYPE");
        $this->CRF_VALUE = ArrayUtil::getField($obj, "CRF_VALUE");
        $this->CWAV_AFREQ = ArrayUtil::getField($obj, "CWAV_AFREQ");
        $this->CWAV_ALRA = ArrayUtil::getField($obj, "CWAV_ALRA");
        $this->CWAV_ALRB = ArrayUtil::getField($obj, "CWAV_ALRB");
        $this->CWAV_ALRP = ArrayUtil::getField($obj, "CWAV_ALRP");
        $this->CWAV_ALR_NPCTL = ArrayUtil::getField($obj, "CWAV_ALR_NPCTL");
        $this->CWAV_EALA = ArrayUtil::getField($obj, "CWAV_EALA");
        $this->CWAV_EALB = ArrayUtil::getField($obj, "CWAV_EALB");
        $this->CWAV_EALP = ArrayUtil::getField($obj, "CWAV_EALP");
        $this->CWAV_EALPE = ArrayUtil::getField($obj, "CWAV_EALPE");
        $this->CWAV_EALR = ArrayUtil::getField($obj, "CWAV_EALR");
        $this->CWAV_EALS = ArrayUtil::getField($obj, "CWAV_EALS");
        $this->CWAV_EALT = ArrayUtil::getField($obj, "CWAV_EALT");
        $this->CWAV_EVNTS = ArrayUtil::getField($obj, "CWAV_EVNTS");
        $this->CWAV_EXPA = ArrayUtil::getField($obj, "CWAV_EXPA");
        $this->CWAV_EXPB = ArrayUtil::getField($obj, "CWAV_EXPB");
        $this->CWAV_EXPP = ArrayUtil::getField($obj, "CWAV_EXPP");
        $this->CWAV_EXPPE = ArrayUtil::getField($obj, "CWAV_EXPPE");
        $this->CWAV_EXPT = ArrayUtil::getField($obj, "CWAV_EXPT");
        $this->CWAV_EXP_AREA = ArrayUtil::getField($obj, "CWAV_EXP_AREA");
        $this->CWAV_HLRA = ArrayUtil::getField($obj, "CWAV_HLRA");
        $this->CWAV_HLRB = ArrayUtil::getField($obj, "CWAV_HLRB");
        $this->CWAV_HLRP = ArrayUtil::getField($obj, "CWAV_HLRP");
        $this->CWAV_HLRR = ArrayUtil::getField($obj, "CWAV_HLRR");
        $this->CWAV_RISKR = ArrayUtil::getField($obj, "CWAV_RISKR");
        $this->CWAV_RISKS = ArrayUtil::getField($obj, "CWAV_RISKS");
        $this->CWAV_RISKV = ArrayUtil::getField($obj, "CWAV_RISKV");
        $this->DRGT_AFREQ = ArrayUtil::getField($obj, "DRGT_AFREQ");
        $this->DRGT_ALRA = ArrayUtil::getField($obj, "DRGT_ALRA");
        $this->DRGT_ALR_NPCTL = ArrayUtil::getField($obj, "DRGT_ALR_NPCTL");
        $this->DRGT_EALA = ArrayUtil::getField($obj, "DRGT_EALA");
        $this->DRGT_EALR = ArrayUtil::getField($obj, "DRGT_EALR");
        $this->DRGT_EALS = ArrayUtil::getField($obj, "DRGT_EALS");
        $this->DRGT_EALT = ArrayUtil::getField($obj, "DRGT_EALT");
        $this->DRGT_EVNTS = ArrayUtil::getField($obj, "DRGT_EVNTS");
        $this->DRGT_EXPA = ArrayUtil::getField($obj, "DRGT_EXPA");
        $this->DRGT_EXPT = ArrayUtil::getField($obj, "DRGT_EXPT");
        $this->DRGT_EXP_AREA = ArrayUtil::getField($obj, "DRGT_EXP_AREA");
        $this->DRGT_HLRA = ArrayUtil::getField($obj, "DRGT_HLRA");
        $this->DRGT_HLRR = ArrayUtil::getField($obj, "DRGT_HLRR");
        $this->DRGT_RISKR = ArrayUtil::getField($obj, "DRGT_RISKR");
        $this->DRGT_RISKS = ArrayUtil::getField($obj, "DRGT_RISKS");
        $this->DRGT_RISKV = ArrayUtil::getField($obj, "DRGT_RISKV");
        $this->EAL_RATNG = ArrayUtil::getField($obj, "EAL_RATNG");
        $this->EAL_SCORE = ArrayUtil::getField($obj, "EAL_SCORE");
        $this->EAL_SPCTL = ArrayUtil::getField($obj, "EAL_SPCTL");
        $this->EAL_VALA = ArrayUtil::getField($obj, "EAL_VALA");
        $this->EAL_VALB = ArrayUtil::getField($obj, "EAL_VALB");
        $this->EAL_VALP = ArrayUtil::getField($obj, "EAL_VALP");
        $this->EAL_VALPE = ArrayUtil::getField($obj, "EAL_VALPE");
        $this->EAL_VALT = ArrayUtil::getField($obj, "EAL_VALT");
        $this->ERQK_AFREQ = ArrayUtil::getField($obj, "ERQK_AFREQ");
        $this->ERQK_ALRB = ArrayUtil::getField($obj, "ERQK_ALRB");
        $this->ERQK_ALRP = ArrayUtil::getField($obj, "ERQK_ALRP");
        $this->ERQK_ALR_NPCTL = ArrayUtil::getField($obj, "ERQK_ALR_NPCTL");
        $this->ERQK_EALB = ArrayUtil::getField($obj, "ERQK_EALB");
        $this->ERQK_EALP = ArrayUtil::getField($obj, "ERQK_EALP");
        $this->ERQK_EALPE = ArrayUtil::getField($obj, "ERQK_EALPE");
        $this->ERQK_EALR = ArrayUtil::getField($obj, "ERQK_EALR");
        $this->ERQK_EALS = ArrayUtil::getField($obj, "ERQK_EALS");
        $this->ERQK_EALT = ArrayUtil::getField($obj, "ERQK_EALT");
        $this->ERQK_EVNTS = ArrayUtil::getField($obj, "ERQK_EVNTS");
        $this->ERQK_EXPB = ArrayUtil::getField($obj, "ERQK_EXPB");
        $this->ERQK_EXPP = ArrayUtil::getField($obj, "ERQK_EXPP");
        $this->ERQK_EXPPE = ArrayUtil::getField($obj, "ERQK_EXPPE");
        $this->ERQK_EXPT = ArrayUtil::getField($obj, "ERQK_EXPT");
        $this->ERQK_EXP_AREA = ArrayUtil::getField($obj, "ERQK_EXP_AREA");
        $this->ERQK_HLRB = ArrayUtil::getField($obj, "ERQK_HLRB");
        $this->ERQK_HLRP = ArrayUtil::getField($obj, "ERQK_HLRP");
        $this->ERQK_HLRR = ArrayUtil::getField($obj, "ERQK_HLRR");
        $this->ERQK_RISKR = ArrayUtil::getField($obj, "ERQK_RISKR");
        $this->ERQK_RISKS = ArrayUtil::getField($obj, "ERQK_RISKS");
        $this->ERQK_RISKV = ArrayUtil::getField($obj, "ERQK_RISKV");
        $this->HAIL_AFREQ = ArrayUtil::getField($obj, "HAIL_AFREQ");
        $this->HAIL_ALRA = ArrayUtil::getField($obj, "HAIL_ALRA");
        $this->HAIL_ALRB = ArrayUtil::getField($obj, "HAIL_ALRB");
        $this->HAIL_ALRP = ArrayUtil::getField($obj, "HAIL_ALRP");
        $this->HAIL_ALR_NPCTL = ArrayUtil::getField($obj, "HAIL_ALR_NPCTL");
        $this->HAIL_EALA = ArrayUtil::getField($obj, "HAIL_EALA");
        $this->HAIL_EALB = ArrayUtil::getField($obj, "HAIL_EALB");
        $this->HAIL_EALP = ArrayUtil::getField($obj, "HAIL_EALP");
        $this->HAIL_EALPE = ArrayUtil::getField($obj, "HAIL_EALPE");
        $this->HAIL_EALR = ArrayUtil::getField($obj, "HAIL_EALR");
        $this->HAIL_EALS = ArrayUtil::getField($obj, "HAIL_EALS");
        $this->HAIL_EALT = ArrayUtil::getField($obj, "HAIL_EALT");
        $this->HAIL_EVNTS = ArrayUtil::getField($obj, "HAIL_EVNTS");
        $this->HAIL_EXPA = ArrayUtil::getField($obj, "HAIL_EXPA");
        $this->HAIL_EXPB = ArrayUtil::getField($obj, "HAIL_EXPB");
        $this->HAIL_EXPP = ArrayUtil::getField($obj, "HAIL_EXPP");
        $this->HAIL_EXPPE = ArrayUtil::getField($obj, "HAIL_EXPPE");
        $this->HAIL_EXPT = ArrayUtil::getField($obj, "HAIL_EXPT");
        $this->HAIL_EXP_AREA = ArrayUtil::getField($obj, "HAIL_EXP_AREA");
        $this->HAIL_HLRA = ArrayUtil::getField($obj, "HAIL_HLRA");
        $this->HAIL_HLRB = ArrayUtil::getField($obj, "HAIL_HLRB");
        $this->HAIL_HLRP = ArrayUtil::getField($obj, "HAIL_HLRP");
        $this->HAIL_HLRR = ArrayUtil::getField($obj, "HAIL_HLRR");
        $this->HAIL_RISKR = ArrayUtil::getField($obj, "HAIL_RISKR");
        $this->HAIL_RISKS = ArrayUtil::getField($obj, "HAIL_RISKS");
        $this->HAIL_RISKV = ArrayUtil::getField($obj, "HAIL_RISKV");
        $this->HRCN_AFREQ = ArrayUtil::getField($obj, "HRCN_AFREQ");
        $this->HRCN_ALRA = ArrayUtil::getField($obj, "HRCN_ALRA");
        $this->HRCN_ALRB = ArrayUtil::getField($obj, "HRCN_ALRB");
        $this->HRCN_ALRP = ArrayUtil::getField($obj, "HRCN_ALRP");
        $this->HRCN_ALR_NPCTL = ArrayUtil::getField($obj, "HRCN_ALR_NPCTL");
        $this->HRCN_EALA = ArrayUtil::getField($obj, "HRCN_EALA");
        $this->HRCN_EALB = ArrayUtil::getField($obj, "HRCN_EALB");
        $this->HRCN_EALP = ArrayUtil::getField($obj, "HRCN_EALP");
        $this->HRCN_EALPE = ArrayUtil::getField($obj, "HRCN_EALPE");
        $this->HRCN_EALR = ArrayUtil::getField($obj, "HRCN_EALR");
        $this->HRCN_EALS = ArrayUtil::getField($obj, "HRCN_EALS");
        $this->HRCN_EALT = ArrayUtil::getField($obj, "HRCN_EALT");
        $this->HRCN_EVNTS = ArrayUtil::getField($obj, "HRCN_EVNTS");
        $this->HRCN_EXPA = ArrayUtil::getField($obj, "HRCN_EXPA");
        $this->HRCN_EXPB = ArrayUtil::getField($obj, "HRCN_EXPB");
        $this->HRCN_EXPP = ArrayUtil::getField($obj, "HRCN_EXPP");
        $this->HRCN_EXPPE = ArrayUtil::getField($obj, "HRCN_EXPPE");
        $this->HRCN_EXPT = ArrayUtil::getField($obj, "HRCN_EXPT");
        $this->HRCN_EXP_AREA = ArrayUtil::getField($obj, "HRCN_EXP_AREA");
        $this->HRCN_HLRA = ArrayUtil::getField($obj, "HRCN_HLRA");
        $this->HRCN_HLRB = ArrayUtil::getField($obj, "HRCN_HLRB");
        $this->HRCN_HLRP = ArrayUtil::getField($obj, "HRCN_HLRP");
        $this->HRCN_HLRR = ArrayUtil::getField($obj, "HRCN_HLRR");
        $this->HRCN_RISKR = ArrayUtil::getField($obj, "HRCN_RISKR");
        $this->HRCN_RISKS = ArrayUtil::getField($obj, "HRCN_RISKS");
        $this->HRCN_RISKV = ArrayUtil::getField($obj, "HRCN_RISKV");
        $this->HWAV_AFREQ = ArrayUtil::getField($obj, "HWAV_AFREQ");
        $this->HWAV_ALRA = ArrayUtil::getField($obj, "HWAV_ALRA");
        $this->HWAV_ALRB = ArrayUtil::getField($obj, "HWAV_ALRB");
        $this->HWAV_ALRP = ArrayUtil::getField($obj, "HWAV_ALRP");
        $this->HWAV_ALR_NPCTL = ArrayUtil::getField($obj, "HWAV_ALR_NPCTL");
        $this->HWAV_EALA = ArrayUtil::getField($obj, "HWAV_EALA");
        $this->HWAV_EALB = ArrayUtil::getField($obj, "HWAV_EALB");
        $this->HWAV_EALP = ArrayUtil::getField($obj, "HWAV_EALP");
        $this->HWAV_EALPE = ArrayUtil::getField($obj, "HWAV_EALPE");
        $this->HWAV_EALR = ArrayUtil::getField($obj, "HWAV_EALR");
        $this->HWAV_EALS = ArrayUtil::getField($obj, "HWAV_EALS");
        $this->HWAV_EALT = ArrayUtil::getField($obj, "HWAV_EALT");
        $this->HWAV_EVNTS = ArrayUtil::getField($obj, "HWAV_EVNTS");
        $this->HWAV_EXPA = ArrayUtil::getField($obj, "HWAV_EXPA");
        $this->HWAV_EXPB = ArrayUtil::getField($obj, "HWAV_EXPB");
        $this->HWAV_EXPP = ArrayUtil::getField($obj, "HWAV_EXPP");
        $this->HWAV_EXPPE = ArrayUtil::getField($obj, "HWAV_EXPPE");
        $this->HWAV_EXPT = ArrayUtil::getField($obj, "HWAV_EXPT");
        $this->HWAV_EXP_AREA = ArrayUtil::getField($obj, "HWAV_EXP_AREA");
        $this->HWAV_HLRA = ArrayUtil::getField($obj, "HWAV_HLRA");
        $this->HWAV_HLRB = ArrayUtil::getField($obj, "HWAV_HLRB");
        $this->HWAV_HLRP = ArrayUtil::getField($obj, "HWAV_HLRP");
        $this->HWAV_HLRR = ArrayUtil::getField($obj, "HWAV_HLRR");
        $this->HWAV_RISKR = ArrayUtil::getField($obj, "HWAV_RISKR");
        $this->HWAV_RISKS = ArrayUtil::getField($obj, "HWAV_RISKS");
        $this->HWAV_RISKV = ArrayUtil::getField($obj, "HWAV_RISKV");
        $this->ISTM_AFREQ = ArrayUtil::getField($obj, "ISTM_AFREQ");
        $this->ISTM_ALRB = ArrayUtil::getField($obj, "ISTM_ALRB");
        $this->ISTM_ALRP = ArrayUtil::getField($obj, "ISTM_ALRP");
        $this->ISTM_ALR_NPCTL = ArrayUtil::getField($obj, "ISTM_ALR_NPCTL");
        $this->ISTM_EALB = ArrayUtil::getField($obj, "ISTM_EALB");
        $this->ISTM_EALP = ArrayUtil::getField($obj, "ISTM_EALP");
        $this->ISTM_EALPE = ArrayUtil::getField($obj, "ISTM_EALPE");
        $this->ISTM_EALR = ArrayUtil::getField($obj, "ISTM_EALR");
        $this->ISTM_EALS = ArrayUtil::getField($obj, "ISTM_EALS");
        $this->ISTM_EALT = ArrayUtil::getField($obj, "ISTM_EALT");
        $this->ISTM_EVNTS = ArrayUtil::getField($obj, "ISTM_EVNTS");
        $this->ISTM_EXPB = ArrayUtil::getField($obj, "ISTM_EXPB");
        $this->ISTM_EXPP = ArrayUtil::getField($obj, "ISTM_EXPP");
        $this->ISTM_EXPPE = ArrayUtil::getField($obj, "ISTM_EXPPE");
        $this->ISTM_EXPT = ArrayUtil::getField($obj, "ISTM_EXPT");
        $this->ISTM_EXP_AREA = ArrayUtil::getField($obj, "ISTM_EXP_AREA");
        $this->ISTM_HLRB = ArrayUtil::getField($obj, "ISTM_HLRB");
        $this->ISTM_HLRP = ArrayUtil::getField($obj, "ISTM_HLRP");
        $this->ISTM_HLRR = ArrayUtil::getField($obj, "ISTM_HLRR");
        $this->ISTM_RISKR = ArrayUtil::getField($obj, "ISTM_RISKR");
        $this->ISTM_RISKS = ArrayUtil::getField($obj, "ISTM_RISKS");
        $this->ISTM_RISKV = ArrayUtil::getField($obj, "ISTM_RISKV");
        $this->LNDS_AFREQ = ArrayUtil::getField($obj, "LNDS_AFREQ");
        $this->LNDS_ALRB = ArrayUtil::getField($obj, "LNDS_ALRB");
        $this->LNDS_ALRP = ArrayUtil::getField($obj, "LNDS_ALRP");
        $this->LNDS_ALR_NPCTL = ArrayUtil::getField($obj, "LNDS_ALR_NPCTL");
        $this->LNDS_EALB = ArrayUtil::getField($obj, "LNDS_EALB");
        $this->LNDS_EALP = ArrayUtil::getField($obj, "LNDS_EALP");
        $this->LNDS_EALPE = ArrayUtil::getField($obj, "LNDS_EALPE");
        $this->LNDS_EALR = ArrayUtil::getField($obj, "LNDS_EALR");
        $this->LNDS_EALS = ArrayUtil::getField($obj, "LNDS_EALS");
        $this->LNDS_EALT = ArrayUtil::getField($obj, "LNDS_EALT");
        $this->LNDS_EVNTS = ArrayUtil::getField($obj, "LNDS_EVNTS");
        $this->LNDS_EXPB = ArrayUtil::getField($obj, "LNDS_EXPB");
        $this->LNDS_EXPP = ArrayUtil::getField($obj, "LNDS_EXPP");
        $this->LNDS_EXPPE = ArrayUtil::getField($obj, "LNDS_EXPPE");
        $this->LNDS_EXPT = ArrayUtil::getField($obj, "LNDS_EXPT");
        $this->LNDS_EXP_AREA = ArrayUtil::getField($obj, "LNDS_EXP_AREA");
        $this->LNDS_HLRB = ArrayUtil::getField($obj, "LNDS_HLRB");
        $this->LNDS_HLRP = ArrayUtil::getField($obj, "LNDS_HLRP");
        $this->LNDS_HLRR = ArrayUtil::getField($obj, "LNDS_HLRR");
        $this->LNDS_RISKR = ArrayUtil::getField($obj, "LNDS_RISKR");
        $this->LNDS_RISKS = ArrayUtil::getField($obj, "LNDS_RISKS");
        $this->LNDS_RISKV = ArrayUtil::getField($obj, "LNDS_RISKV");
        $this->LTNG_AFREQ = ArrayUtil::getField($obj, "LTNG_AFREQ");
        $this->LTNG_ALRB = ArrayUtil::getField($obj, "LTNG_ALRB");
        $this->LTNG_ALRP = ArrayUtil::getField($obj, "LTNG_ALRP");
        $this->LTNG_ALR_NPCTL = ArrayUtil::getField($obj, "LTNG_ALR_NPCTL");
        $this->LTNG_EALB = ArrayUtil::getField($obj, "LTNG_EALB");
        $this->LTNG_EALP = ArrayUtil::getField($obj, "LTNG_EALP");
        $this->LTNG_EALPE = ArrayUtil::getField($obj, "LTNG_EALPE");
        $this->LTNG_EALR = ArrayUtil::getField($obj, "LTNG_EALR");
        $this->LTNG_EALS = ArrayUtil::getField($obj, "LTNG_EALS");
        $this->LTNG_EALT = ArrayUtil::getField($obj, "LTNG_EALT");
        $this->LTNG_EVNTS = ArrayUtil::getField($obj, "LTNG_EVNTS");
        $this->LTNG_EXPB = ArrayUtil::getField($obj, "LTNG_EXPB");
        $this->LTNG_EXPP = ArrayUtil::getField($obj, "LTNG_EXPP");
        $this->LTNG_EXPPE = ArrayUtil::getField($obj, "LTNG_EXPPE");
        $this->LTNG_EXPT = ArrayUtil::getField($obj, "LTNG_EXPT");
        $this->LTNG_EXP_AREA = ArrayUtil::getField($obj, "LTNG_EXP_AREA");
        $this->LTNG_HLRB = ArrayUtil::getField($obj, "LTNG_HLRB");
        $this->LTNG_HLRP = ArrayUtil::getField($obj, "LTNG_HLRP");
        $this->LTNG_HLRR = ArrayUtil::getField($obj, "LTNG_HLRR");
        $this->LTNG_RISKR = ArrayUtil::getField($obj, "LTNG_RISKR");
        $this->LTNG_RISKS = ArrayUtil::getField($obj, "LTNG_RISKS");
        $this->LTNG_RISKV = ArrayUtil::getField($obj, "LTNG_RISKV");
        $this->NRI_VER = ArrayUtil::getField($obj, "NRI_VER");
        $this->POPULATION = ArrayUtil::getField($obj, "POPULATION");
        $this->RESL_RATNG = ArrayUtil::getField($obj, "RESL_RATNG");
        $this->RESL_SCORE = ArrayUtil::getField($obj, "RESL_SCORE");
        $this->RESL_SPCTL = ArrayUtil::getField($obj, "RESL_SPCTL");
        $this->RESL_VALUE = ArrayUtil::getField($obj, "RESL_VALUE");
        $this->RFLD_AFREQ = ArrayUtil::getField($obj, "RFLD_AFREQ");
        $this->RFLD_ALRA = ArrayUtil::getField($obj, "RFLD_ALRA");
        $this->RFLD_ALRB = ArrayUtil::getField($obj, "RFLD_ALRB");
        $this->RFLD_ALRP = ArrayUtil::getField($obj, "RFLD_ALRP");
        $this->RFLD_ALR_NPCTL = ArrayUtil::getField($obj, "RFLD_ALR_NPCTL");
        $this->RFLD_EALA = ArrayUtil::getField($obj, "RFLD_EALA");
        $this->RFLD_EALB = ArrayUtil::getField($obj, "RFLD_EALB");
        $this->RFLD_EALP = ArrayUtil::getField($obj, "RFLD_EALP");
        $this->RFLD_EALPE = ArrayUtil::getField($obj, "RFLD_EALPE");
        $this->RFLD_EALR = ArrayUtil::getField($obj, "RFLD_EALR");
        $this->RFLD_EALS = ArrayUtil::getField($obj, "RFLD_EALS");
        $this->RFLD_EALT = ArrayUtil::getField($obj, "RFLD_EALT");
        $this->RFLD_EVNTS = ArrayUtil::getField($obj, "RFLD_EVNTS");
        $this->RFLD_EXPA = ArrayUtil::getField($obj, "RFLD_EXPA");
        $this->RFLD_EXPB = ArrayUtil::getField($obj, "RFLD_EXPB");
        $this->RFLD_EXPP = ArrayUtil::getField($obj, "RFLD_EXPP");
        $this->RFLD_EXPPE = ArrayUtil::getField($obj, "RFLD_EXPPE");
        $this->RFLD_EXPT = ArrayUtil::getField($obj, "RFLD_EXPT");
        $this->RFLD_EXP_AREA = ArrayUtil::getField($obj, "RFLD_EXP_AREA");
        $this->RFLD_HLRA = ArrayUtil::getField($obj, "RFLD_HLRA");
        $this->RFLD_HLRB = ArrayUtil::getField($obj, "RFLD_HLRB");
        $this->RFLD_HLRP = ArrayUtil::getField($obj, "RFLD_HLRP");
        $this->RFLD_HLRR = ArrayUtil::getField($obj, "RFLD_HLRR");
        $this->RFLD_RISKR = ArrayUtil::getField($obj, "RFLD_RISKR");
        $this->RFLD_RISKS = ArrayUtil::getField($obj, "RFLD_RISKS");
        $this->RFLD_RISKV = ArrayUtil::getField($obj, "RFLD_RISKV");
        $this->RISK_RATNG = ArrayUtil::getField($obj, "RISK_RATNG");
        $this->RISK_SCORE = ArrayUtil::getField($obj, "RISK_SCORE");
        $this->RISK_SPCTL = ArrayUtil::getField($obj, "RISK_SPCTL");
        $this->RISK_VALUE = ArrayUtil::getField($obj, "RISK_VALUE");
        $this->SOVI_RATNG = ArrayUtil::getField($obj, "SOVI_RATNG");
        $this->SOVI_SCORE = ArrayUtil::getField($obj, "SOVI_SCORE");
        $this->SOVI_SPCTL = ArrayUtil::getField($obj, "SOVI_SPCTL");
        $this->STATE = ArrayUtil::getField($obj, "STATE");
        $this->STATEABBRV = ArrayUtil::getField($obj, "STATEABBRV");
        $this->STATEFIPS = ArrayUtil::getField($obj, "STATEFIPS");
        $this->STCOFIPS = ArrayUtil::getField($obj, "STCOFIPS");
        $this->SWND_AFREQ = ArrayUtil::getField($obj, "SWND_AFREQ");
        $this->SWND_ALRA = ArrayUtil::getField($obj, "SWND_ALRA");
        $this->SWND_ALRB = ArrayUtil::getField($obj, "SWND_ALRB");
        $this->SWND_ALRP = ArrayUtil::getField($obj, "SWND_ALRP");
        $this->SWND_ALR_NPCTL = ArrayUtil::getField($obj, "SWND_ALR_NPCTL");
        $this->SWND_EALA = ArrayUtil::getField($obj, "SWND_EALA");
        $this->SWND_EALB = ArrayUtil::getField($obj, "SWND_EALB");
        $this->SWND_EALP = ArrayUtil::getField($obj, "SWND_EALP");
        $this->SWND_EALPE = ArrayUtil::getField($obj, "SWND_EALPE");
        $this->SWND_EALR = ArrayUtil::getField($obj, "SWND_EALR");
        $this->SWND_EALS = ArrayUtil::getField($obj, "SWND_EALS");
        $this->SWND_EALT = ArrayUtil::getField($obj, "SWND_EALT");
        $this->SWND_EVNTS = ArrayUtil::getField($obj, "SWND_EVNTS");
        $this->SWND_EXPA = ArrayUtil::getField($obj, "SWND_EXPA");
        $this->SWND_EXPB = ArrayUtil::getField($obj, "SWND_EXPB");
        $this->SWND_EXPP = ArrayUtil::getField($obj, "SWND_EXPP");
        $this->SWND_EXPPE = ArrayUtil::getField($obj, "SWND_EXPPE");
        $this->SWND_EXPT = ArrayUtil::getField($obj, "SWND_EXPT");
        $this->SWND_EXP_AREA = ArrayUtil::getField($obj, "SWND_EXP_AREA");
        $this->SWND_HLRA = ArrayUtil::getField($obj, "SWND_HLRA");
        $this->SWND_HLRB = ArrayUtil::getField($obj, "SWND_HLRB");
        $this->SWND_HLRP = ArrayUtil::getField($obj, "SWND_HLRP");
        $this->SWND_HLRR = ArrayUtil::getField($obj, "SWND_HLRR");
        $this->SWND_RISKR = ArrayUtil::getField($obj, "SWND_RISKR");
        $this->SWND_RISKS = ArrayUtil::getField($obj, "SWND_RISKS");
        $this->SWND_RISKV = ArrayUtil::getField($obj, "SWND_RISKV");
        $this->TRACT = ArrayUtil::getField($obj, "TRACT");
        $this->TRACTFIPS = ArrayUtil::getField($obj, "TRACTFIPS");
        $this->TRND_AFREQ = ArrayUtil::getField($obj, "TRND_AFREQ");
        $this->TRND_ALRA = ArrayUtil::getField($obj, "TRND_ALRA");
        $this->TRND_ALRB = ArrayUtil::getField($obj, "TRND_ALRB");
        $this->TRND_ALRP = ArrayUtil::getField($obj, "TRND_ALRP");
        $this->TRND_ALR_NPCTL = ArrayUtil::getField($obj, "TRND_ALR_NPCTL");
        $this->TRND_EALA = ArrayUtil::getField($obj, "TRND_EALA");
        $this->TRND_EALB = ArrayUtil::getField($obj, "TRND_EALB");
        $this->TRND_EALP = ArrayUtil::getField($obj, "TRND_EALP");
        $this->TRND_EALPE = ArrayUtil::getField($obj, "TRND_EALPE");
        $this->TRND_EALR = ArrayUtil::getField($obj, "TRND_EALR");
        $this->TRND_EALS = ArrayUtil::getField($obj, "TRND_EALS");
        $this->TRND_EALT = ArrayUtil::getField($obj, "TRND_EALT");
        $this->TRND_EVNTS = ArrayUtil::getField($obj, "TRND_EVNTS");
        $this->TRND_EXPA = ArrayUtil::getField($obj, "TRND_EXPA");
        $this->TRND_EXPB = ArrayUtil::getField($obj, "TRND_EXPB");
        $this->TRND_EXPP = ArrayUtil::getField($obj, "TRND_EXPP");
        $this->TRND_EXPPE = ArrayUtil::getField($obj, "TRND_EXPPE");
        $this->TRND_EXPT = ArrayUtil::getField($obj, "TRND_EXPT");
        $this->TRND_EXP_AREA = ArrayUtil::getField($obj, "TRND_EXP_AREA");
        $this->TRND_HLRA = ArrayUtil::getField($obj, "TRND_HLRA");
        $this->TRND_HLRB = ArrayUtil::getField($obj, "TRND_HLRB");
        $this->TRND_HLRP = ArrayUtil::getField($obj, "TRND_HLRP");
        $this->TRND_HLRR = ArrayUtil::getField($obj, "TRND_HLRR");
        $this->TRND_RISKR = ArrayUtil::getField($obj, "TRND_RISKR");
        $this->TRND_RISKS = ArrayUtil::getField($obj, "TRND_RISKS");
        $this->TRND_RISKV = ArrayUtil::getField($obj, "TRND_RISKV");
        $this->TSUN_AFREQ = ArrayUtil::getField($obj, "TSUN_AFREQ");
        $this->TSUN_ALRB = ArrayUtil::getField($obj, "TSUN_ALRB");
        $this->TSUN_ALRP = ArrayUtil::getField($obj, "TSUN_ALRP");
        $this->TSUN_ALR_NPCTL = ArrayUtil::getField($obj, "TSUN_ALR_NPCTL");
        $this->TSUN_EALB = ArrayUtil::getField($obj, "TSUN_EALB");
        $this->TSUN_EALP = ArrayUtil::getField($obj, "TSUN_EALP");
        $this->TSUN_EALPE = ArrayUtil::getField($obj, "TSUN_EALPE");
        $this->TSUN_EALR = ArrayUtil::getField($obj, "TSUN_EALR");
        $this->TSUN_EALS = ArrayUtil::getField($obj, "TSUN_EALS");
        $this->TSUN_EALT = ArrayUtil::getField($obj, "TSUN_EALT");
        $this->TSUN_EVNTS = ArrayUtil::getField($obj, "TSUN_EVNTS");
        $this->TSUN_EXPB = ArrayUtil::getField($obj, "TSUN_EXPB");
        $this->TSUN_EXPP = ArrayUtil::getField($obj, "TSUN_EXPP");
        $this->TSUN_EXPPE = ArrayUtil::getField($obj, "TSUN_EXPPE");
        $this->TSUN_EXPT = ArrayUtil::getField($obj, "TSUN_EXPT");
        $this->TSUN_EXP_AREA = ArrayUtil::getField($obj, "TSUN_EXP_AREA");
        $this->TSUN_HLRB = ArrayUtil::getField($obj, "TSUN_HLRB");
        $this->TSUN_HLRP = ArrayUtil::getField($obj, "TSUN_HLRP");
        $this->TSUN_HLRR = ArrayUtil::getField($obj, "TSUN_HLRR");
        $this->TSUN_RISKR = ArrayUtil::getField($obj, "TSUN_RISKR");
        $this->TSUN_RISKS = ArrayUtil::getField($obj, "TSUN_RISKS");
        $this->TSUN_RISKV = ArrayUtil::getField($obj, "TSUN_RISKV");
        $this->VLCN_AFREQ = ArrayUtil::getField($obj, "VLCN_AFREQ");
        $this->VLCN_ALRB = ArrayUtil::getField($obj, "VLCN_ALRB");
        $this->VLCN_ALRP = ArrayUtil::getField($obj, "VLCN_ALRP");
        $this->VLCN_ALR_NPCTL = ArrayUtil::getField($obj, "VLCN_ALR_NPCTL");
        $this->VLCN_EALB = ArrayUtil::getField($obj, "VLCN_EALB");
        $this->VLCN_EALP = ArrayUtil::getField($obj, "VLCN_EALP");
        $this->VLCN_EALPE = ArrayUtil::getField($obj, "VLCN_EALPE");
        $this->VLCN_EALR = ArrayUtil::getField($obj, "VLCN_EALR");
        $this->VLCN_EALS = ArrayUtil::getField($obj, "VLCN_EALS");
        $this->VLCN_EALT = ArrayUtil::getField($obj, "VLCN_EALT");
        $this->VLCN_EVNTS = ArrayUtil::getField($obj, "VLCN_EVNTS");
        $this->VLCN_EXPB = ArrayUtil::getField($obj, "VLCN_EXPB");
        $this->VLCN_EXPP = ArrayUtil::getField($obj, "VLCN_EXPP");
        $this->VLCN_EXPPE = ArrayUtil::getField($obj, "VLCN_EXPPE");
        $this->VLCN_EXPT = ArrayUtil::getField($obj, "VLCN_EXPT");
        $this->VLCN_EXP_AREA = ArrayUtil::getField($obj, "VLCN_EXP_AREA");
        $this->VLCN_HLRB = ArrayUtil::getField($obj, "VLCN_HLRB");
        $this->VLCN_HLRP = ArrayUtil::getField($obj, "VLCN_HLRP");
        $this->VLCN_HLRR = ArrayUtil::getField($obj, "VLCN_HLRR");
        $this->VLCN_RISKR = ArrayUtil::getField($obj, "VLCN_RISKR");
        $this->VLCN_RISKS = ArrayUtil::getField($obj, "VLCN_RISKS");
        $this->VLCN_RISKV = ArrayUtil::getField($obj, "VLCN_RISKV");
        $this->WFIR_AFREQ = ArrayUtil::getField($obj, "WFIR_AFREQ");
        $this->WFIR_ALRA = ArrayUtil::getField($obj, "WFIR_ALRA");
        $this->WFIR_ALRB = ArrayUtil::getField($obj, "WFIR_ALRB");
        $this->WFIR_ALRP = ArrayUtil::getField($obj, "WFIR_ALRP");
        $this->WFIR_ALR_NPCTL = ArrayUtil::getField($obj, "WFIR_ALR_NPCTL");
        $this->WFIR_EALA = ArrayUtil::getField($obj, "WFIR_EALA");
        $this->WFIR_EALB = ArrayUtil::getField($obj, "WFIR_EALB");
        $this->WFIR_EALP = ArrayUtil::getField($obj, "WFIR_EALP");
        $this->WFIR_EALPE = ArrayUtil::getField($obj, "WFIR_EALPE");
        $this->WFIR_EALR = ArrayUtil::getField($obj, "WFIR_EALR");
        $this->WFIR_EALS = ArrayUtil::getField($obj, "WFIR_EALS");
        $this->WFIR_EALT = ArrayUtil::getField($obj, "WFIR_EALT");
        $this->WFIR_EVNTS = ArrayUtil::getField($obj, "WFIR_EVNTS");
        $this->WFIR_EXPA = ArrayUtil::getField($obj, "WFIR_EXPA");
        $this->WFIR_EXPB = ArrayUtil::getField($obj, "WFIR_EXPB");
        $this->WFIR_EXPP = ArrayUtil::getField($obj, "WFIR_EXPP");
        $this->WFIR_EXPPE = ArrayUtil::getField($obj, "WFIR_EXPPE");
        $this->WFIR_EXPT = ArrayUtil::getField($obj, "WFIR_EXPT");
        $this->WFIR_EXP_AREA = ArrayUtil::getField($obj, "WFIR_EXP_AREA");
        $this->WFIR_HLRA = ArrayUtil::getField($obj, "WFIR_HLRA");
        $this->WFIR_HLRB = ArrayUtil::getField($obj, "WFIR_HLRB");
        $this->WFIR_HLRP = ArrayUtil::getField($obj, "WFIR_HLRP");
        $this->WFIR_HLRR = ArrayUtil::getField($obj, "WFIR_HLRR");
        $this->WFIR_RISKR = ArrayUtil::getField($obj, "WFIR_RISKR");
        $this->WFIR_RISKS = ArrayUtil::getField($obj, "WFIR_RISKS");
        $this->WFIR_RISKV = ArrayUtil::getField($obj, "WFIR_RISKV");
        $this->WNTW_AFREQ = ArrayUtil::getField($obj, "WNTW_AFREQ");
        $this->WNTW_ALRA = ArrayUtil::getField($obj, "WNTW_ALRA");
        $this->WNTW_ALRB = ArrayUtil::getField($obj, "WNTW_ALRB");
        $this->WNTW_ALRP = ArrayUtil::getField($obj, "WNTW_ALRP");
        $this->WNTW_ALR_NPCTL = ArrayUtil::getField($obj, "WNTW_ALR_NPCTL");
        $this->WNTW_EALA = ArrayUtil::getField($obj, "WNTW_EALA");
        $this->WNTW_EALB = ArrayUtil::getField($obj, "WNTW_EALB");
        $this->WNTW_EALP = ArrayUtil::getField($obj, "WNTW_EALP");
        $this->WNTW_EALPE = ArrayUtil::getField($obj, "WNTW_EALPE");
        $this->WNTW_EALR = ArrayUtil::getField($obj, "WNTW_EALR");
        $this->WNTW_EALS = ArrayUtil::getField($obj, "WNTW_EALS");
        $this->WNTW_EALT = ArrayUtil::getField($obj, "WNTW_EALT");
        $this->WNTW_EVNTS = ArrayUtil::getField($obj, "WNTW_EVNTS");
        $this->WNTW_EXPA = ArrayUtil::getField($obj, "WNTW_EXPA");
        $this->WNTW_EXPB = ArrayUtil::getField($obj, "WNTW_EXPB");
        $this->WNTW_EXPP = ArrayUtil::getField($obj, "WNTW_EXPP");
        $this->WNTW_EXPPE = ArrayUtil::getField($obj, "WNTW_EXPPE");
        $this->WNTW_EXPT = ArrayUtil::getField($obj, "WNTW_EXPT");
        $this->WNTW_EXP_AREA = ArrayUtil::getField($obj, "WNTW_EXP_AREA");
        $this->WNTW_HLRA = ArrayUtil::getField($obj, "WNTW_HLRA");
        $this->WNTW_HLRB = ArrayUtil::getField($obj, "WNTW_HLRB");
        $this->WNTW_HLRP = ArrayUtil::getField($obj, "WNTW_HLRP");
        $this->WNTW_HLRR = ArrayUtil::getField($obj, "WNTW_HLRR");
        $this->WNTW_RISKR = ArrayUtil::getField($obj, "WNTW_RISKR");
        $this->WNTW_RISKS = ArrayUtil::getField($obj, "WNTW_RISKS");
        $this->WNTW_RISKV = ArrayUtil::getField($obj, "WNTW_RISKV");
    }
}