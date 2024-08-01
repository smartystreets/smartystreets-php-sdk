<?php
namespace SmartyStreets\PhpSdk\US_Enrichment;

use PSpell\Dictionary;
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

    private function createCensusBlock($censusBlockArray){
        $this->censusBlock = new CensusBlockEntry($censusBlockArray);
    }

    private function createCensusCountyDivision($censusCountyDivisionArray){
        $this->censusCountyDivision = new CensusCountyDivisionEntry($censusCountyDivisionArray);
    }
    
    private function createCensusTract($censusTractArray){
            $this->censusTract = new CensusTractEntry($censusTractArray);
    }

    private function createCoreBasedStatArea($coreBasedStatAreaArray){
            $this->coreBasedStatArea = new CoreBasedStatAreaEntry($coreBasedStatAreaArray);
    }

    private function createPlace($placeArray){
            $this->place = new PlaceEntry($placeArray);
    }
}