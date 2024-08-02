<?php
namespace SmartyStreets\PhpSdk\US_Enrichment;

use SmartyStreets\PhpSdk\ArrayUtil;

require_once(dirname(dirname(__FILE__)) . '/US_Enrichment/GeoReference/CensusBlockEntry.php');
require_once(dirname(dirname(__FILE__)) . '/US_Enrichment/GeoReference/CensusCountyDivisionEntry.php');
require_once(dirname(dirname(__FILE__)) . '/US_Enrichment/GeoReference/CensusTractEntry.php');
require_once(dirname(dirname(__FILE__)) . '/US_Enrichment/GeoReference/CoreBasedStatAreaEntry.php');
require_once(dirname(dirname(__FILE__)) . '/US_Enrichment/GeoReference/PlaceEntry.php');

use SmartyStreets\PhpSdk\US_Enrichment\GeoReference\CensusBlockEntry;
use SmartyStreets\PhpSdk\US_Enrichment\GeoReference\CensusCountyDivisionEntry;
use SmartyStreets\PhpSdk\US_Enrichment\GeoReference\CensusTractEntry;
use SmartyStreets\PhpSdk\US_Enrichment\GeoReference\CoreBasedStatAreaEntry;
use SmartyStreets\PhpSdk\US_Enrichment\GeoReference\PlaceEntry;

class GeoReferenceAttributes {

    //region [ Fields ]

    public $censusBlock,
    $censusCountyDivision,
    $censusTract,
    $coreBasedStatArea,
    $place;

    //endregion

    public function __construct($obj = null) {
        if ($obj == null)
            return;
            $this->createCensusBlock(ArrayUtil::setField($obj, "census_block"));
            $this->createCensusCountyDivision(ArrayUtil::setField($obj, "census_county_division"));
            $this->createCensusTract(ArrayUtil::setField($obj, "census_tract"));
            $this->createCoreBasedStatArea(ArrayUtil::setField($obj, "core_based_stat_area"));
            $this->createPlace(ArrayUtil::setField($obj, "place"));
    }

    private function createCensusBlock($censusBlock){
        $this->censusBlock = new CensusBlockEntry($censusBlock);
    }

    private function createCensusCountyDivision($censusCountyDivision){
        $this->censusCountyDivision = new CensusCountyDivisionEntry($censusCountyDivision);
    }
    
    private function createCensusTract($censusTract){
        $this->censusTract = new CensusTractEntry($censusTract);
    }

    private function createCoreBasedStatArea($coreBasedStatArea){
        $this->coreBasedStatArea = new CoreBasedStatAreaEntry($coreBasedStatArea);
    }

    private function createPlace($place){
        $this->place = new PlaceEntry($place);
    }
}