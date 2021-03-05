<?php

namespace SmartyStreets\PhpSdk\Tests\US_Street;

require_once(dirname(dirname(dirname(__FILE__))) . '/src/US_Street/Candidate.php');
use SmartyStreets\PhpSdk\US_Street\Candidate;
use PHPUnit\Framework\TestCase;

class CandidateTest extends TestCase {
    private $obj;

    public function setUp() : void {
        $this->obj = array(
            'input_id' =>'1234',
            'input_index' => 0,
            'candidate_index' => 1,
            'addressee' => '2',
            'delivery_line_1' => '3',
            'delivery_line_2' => '4',
            'last_line' => '5',
            'delivery_point_barcode' => '6',
            'components' => array(
                'urbanization' => '7',
                'primary_number' => '8',
                'street_name' => '9',
                'street_predirection' => '10',
                'street_postdirection' => '11',
                'street_suffix' => '12',
                'secondary_number' => '13',
                'secondary_designator' => '14',
                'extra_secondary_number' => '15',
                'extra_secondary_designator' => '16',
                'pmb_designator' => '17',
                'pmb_number' => '18',
                'city_name' => '19',
                'default_city_name' => '20',
                'state_abbreviation' => '21',
                'zipcode' => '22',
                'plus4_code' => '23',
                'delivery_point' => '24',
                'delivery_point_check_digit' => '25'
            ),
            'metadata' => array(
                'record_type' => '26',
                'zip_type' => '27',
                'county_fips' => '28',
                'county_name' => '29',
                'carrier_route' => '30',
                'congressional_district' => '31',
                'building_default_indicator' => '32',
                'rdi' => '33',
                'elot_sequence' => '34',
                'elot_sort' => '35',
                'latitude' => 36.0,
                'longitude' => 37.0,
                'precision' => '38',
                'time_zone' => '39',
                'utc_offset' => 40.0,
                'dst' => true,
                'ews_match' => true
            ),
            'analysis' => array(
                'dpv_match_code' => '42',
                'dpv_footnotes' => '43',
                'dpv_cmra' => '44',
                'dpv_vacant' => '45',
                'active' => '46',
                'ews_match' => false,
                'footnotes' => '48',
                'lacslink_code' => '49',
                'lacslink_indicator' => '50',
                'suitelink_match' => true,
                'dpv_no_stat' => '51'
            )
        );
    }

    public function testAllFieldsFilledCorrectly() {
        $candidate = new Candidate($this->obj);

        $this->assertEquals('1234', $candidate->getInputId());
        $this->assertEquals(0, $candidate->getInputIndex());
        $this->assertEquals(1, $candidate->getCandidateIndex());
        $this->assertEquals('2', $candidate->getAddressee());
        $this->assertEquals('3', $candidate->getDeliveryLine1());
        $this->assertEquals('4', $candidate->getDeliveryLine2());
        $this->assertEquals('5', $candidate->getLastLine());
        $this->assertEquals('6', $candidate->getDeliveryPointBarcode());

        $components = $candidate->getComponents();
        $this->assertEquals('7', $components->getUrbanization());
        $this->assertEquals('8', $components->getPrimaryNumber());
        $this->assertEquals('9', $components->getStreetName());
        $this->assertEquals('10', $components->getStreetPredirection());
        $this->assertEquals('11', $components->getStreetPostdirection());
        $this->assertEquals('12', $components->getStreetSuffix());
        $this->assertEquals('13', $components->getSecondaryNumber());
        $this->assertEquals('14', $components->getSecondaryDesignator());
        $this->assertEquals('15', $components->getExtraSecondaryNumber());
        $this->assertEquals('16', $components->getExtraSecondaryDesignator());
        $this->assertEquals('17', $components->getPmbDesignator());
        $this->assertEquals('18', $components->getPmbNumber());
        $this->assertEquals('19', $components->getCityName());
        $this->assertEquals('20', $components->getDefaultCityName());
        $this->assertEquals('21', $components->getStateAbbreviation());
        $this->assertEquals('22', $components->getZipcode());
        $this->assertEquals('23', $components->getPlus4Code());
        $this->assertEquals('24', $components->getDeliveryPoint());
        $this->assertEquals('25', $components->getDeliveryPointCheckDigit());

        $metadata = $candidate->getMetadata();
        $this->assertEquals('26', $metadata->getRecordType());
        $this->assertEquals('27', $metadata->getZipType());
        $this->assertEquals('28', $metadata->getCountyFips());
        $this->assertEquals('29', $metadata->getCountyName());
        $this->assertEquals('30', $metadata->getCarrierRoute());
        $this->assertEquals('31', $metadata->getCongressionalDistrict());
        $this->assertEquals('32', $metadata->getbuildingDefaultIndicator());
        $this->assertEquals('33', $metadata->getRdi());
        $this->assertEquals('34', $metadata->getElotSequence());
        $this->assertEquals('35', $metadata->getElotSort());
        $this->assertEquals(36.0, $metadata->getLatitude());
        $this->assertEquals(37.0, $metadata->getLongitude());
        $this->assertEquals('38', $metadata->getPrecision());
        $this->assertEquals('39', $metadata->getTimeZone());
        $this->assertEquals(40.0, $metadata->getUtcOffset());
        $this->assertEquals(true, $metadata->obeysDst());
        $this->assertEquals(true, $metadata->isEwsMatch());

        $analysis = $candidate->getAnalysis();
        $this->assertEquals('42', $analysis->getDpvMatchCode());
        $this->assertEquals('43', $analysis->getDpvFootnotes());
        $this->assertEquals('44', $analysis->getCmra());
        $this->assertEquals('45', $analysis->getVacant());
        $this->assertEquals('46', $analysis->getActive());
        $this->assertEquals('48', $analysis->getFootnotes());
        $this->assertEquals('49', $analysis->getLacsLinkCode());
        $this->assertEquals('50', $analysis->getLacsLinkIndicator());
        $this->assertEquals(true, $analysis->isSuiteLinkMatch());
        $this->assertEquals('51', $analysis->getNoStat());
    }
}