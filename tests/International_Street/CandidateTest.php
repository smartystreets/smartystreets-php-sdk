<?php

namespace SmartyStreets\PhpSdk\Tests\International_Street;

require_once(dirname(dirname(dirname(__FILE__))) . '/src/International_Street/Candidate.php');
use SmartyStreets\PhpSdk\International_Street\Candidate;
use PHPUnit\Framework\TestCase;
use SmartyStreets\PhpSdk\International_Street\RootLevel;

class CandidateTest extends TestCase {
    private $obj;

    public function setUp() : void {
        $this->obj = array(
            "input_id"=>"1234",
            "organization" => "1",
            "address1" => "2",
            "address2" => "3",
            "address3" => "4",
            "address4" => "5",
            "address5" => "6",
            "address6" => "7",
            "address7" => "8",
            "address8" => "9",
            "address9" => "10",
            "address10" => "11",
            "address11" => "12",
            "address12" => "13",
            "components" => array(
                "country_iso_3" => "14",
                "super_administrative_area" => '15',
                "administrative_area" => "16",
                "sub_administrative_area" => "17",
                "dependent_locality" => "18",
                "dependent_locality_name" => "19",
                "double_dependent_locality" => "20",
                "locality" => "21",
                "postal_code" => "22",
                "postal_code_short" => "23",
                "postal_code_extra" => "24",
                "premise" => "25",
                "premise_extra" => "26",
                "premise_number" => "27",
                "premise_prefix_number" => "27.5",
                "premise_type" => "28",
                "thoroughfare" => "29",
                "thoroughfare_predirection" => "30",
                "thoroughfare_postdirection" => "31",
                "thoroughfare_name" => "32",
                "thoroughfare_trailing_type" => "33",
                "thoroughfare_type" => "34",
                "dependent_thoroughfare" => "35",
                "dependent_thoroughfare_predirection" => "36",
                "dependent_thoroughfare_postdirection" => "37",
                "dependent_thoroughfare_name" => "38",
                "dependent_thoroughfare_trailing_type" => "39",
                "dependent_thoroughfare_type" => "40",
                "building" => "41",
                "building_leading_type" => "42",
                "building_name" => "43",
                "building_trailing_type" => "44",
                "sub_building_type" => "45",
                "sub_building_number" => "46",
                "sub_building_name" => "47",
                "sub_building" => "48",
                "post_box" => "49",
                "post_box_type" => "50",
                "post_box_number" => "51"
            ),
            "metadata" => array(
                "latitude" => 52.0,
                "longitude" => 53.0,
                "geocode_precision" => "54",
                "max_geocode_precision" => "55",
                "address_format" => "56"
            ),
            "analysis" => array(
                "verification_status" => "57",
                "address_precision" => "58",
                "max_address_precision" => "59",
                "changes" => array(
                    "organization" => "60",
                    "address1" => "61",
                    "address2" => "62",
                    "address3" => "63",
                    "address4" => "64",
                    "address5" => "65",
                    "address6" => "66",
                    "address7" => "67",
                    "address8" => "68",
                    "address9" => "69",
                    "address10" => "70",
                    "address11" => "71",
                    "address12" => "72",
                    "components" => array(
                        "country_iso_3" => "73",
                        "super_administrative_area" => "74",
                        "administrative_area" => "75",
                        "sub_administrative_area" => "76",
                        "dependent_locality" => "77",
                        "dependent_locality_name" => "78",
                        "double_dependent_locality" => "79",
                        "locality" => "80",
                        "postal_code" => "81",
                        "postal_code_short" => "82",
                        "postal_code_extra" => "83",
                        "premise" => "84",
                        "premise_extra" => "85",
                        "premise_number" => "86",
                        "premise_prefix_number" => "87",
                        "premise_type" => "88",
                        "thoroughfare" => "89",
                        "thoroughfare_predirection" => "90",
                        "thoroughfare_postdirection" => "91",
                        "thoroughfare_name" => "92",
                        "thoroughfare_trailing_type" => "93",
                        "thoroughfare_type" => "94",
                        "dependent_thoroughfare" => "95",
                        "dependent_thoroughfare_predirection" => "96",
                        "dependent_thoroughfare_postdirection" => "97",
                        "dependent_thoroughfare_name" => "98",
                        "dependent_thoroughfare_trailing_type" => "99",
                        "dependent_thoroughfare_type" => "100",
                        "building" => "101",
                        "building_leading_type" => "102",
                        "building_name" => "103",
                        "building_trailing_type" => "104",
                        "sub_building_type" => "105",
                        "sub_building_number" => "106",
                        "sub_building_name" => "107",
                        "sub_building" => "108",
                        "post_box" => "109",
                        "post_box_type" => "110",
                        "post_box_number" => "111"
                    )
                )
            )
        );
    }

    public function testAllFieldsFilledCorrectly() {
        $candidate = new Candidate($this->obj);

        //region [ Candidate ]
        $this->assertEquals("1234", $candidate->getInputId());
        $this->assertEquals("1", $candidate->getOrganization());
        $this->assertEquals("2", $candidate->getAddress1());
        $this->assertEquals("3", $candidate->getAddress2());
        $this->assertEquals("4", $candidate->getAddress3());
        $this->assertEquals("5", $candidate->getAddress4());
        $this->assertEquals("6", $candidate->getAddress5());
        $this->assertEquals("7", $candidate->getAddress6());
        $this->assertEquals("8", $candidate->getAddress7());
        $this->assertEquals("9", $candidate->getAddress8());
        $this->assertEquals("10", $candidate->getAddress9());
        $this->assertEquals("11", $candidate->getAddress10());
        $this->assertEquals("12", $candidate->getAddress11());
        $this->assertEquals("13", $candidate->getAddress12());
        //endregion

        //region [ Components ]
        $components = $candidate->getComponents();
        $this->assertNotNull($components);
        $this->assertEquals("14", $components->getCountryIso3());
        $this->assertEquals("15", $components->getSuperAdministrativeArea());
        $this->assertEquals("16", $components->getAdministrativeArea());
        $this->assertEquals("17", $components->getSubAdministrativeArea());
        $this->assertEquals("18", $components->getDependentLocality());
        $this->assertEquals("19", $components->getDependentLocalityName());
        $this->assertEquals("20", $components->getDoubleDependentLocality());
        $this->assertEquals("21", $components->getLocality());
        $this->assertEquals("22", $components->getPostalCode());
        $this->assertEquals("23", $components->getPostalCodeShort());
        $this->assertEquals("24", $components->getPostalCodeExtra());
        $this->assertEquals("25", $components->getPremise());
        $this->assertEquals("26", $components->getPremiseExtra());
        $this->assertEquals("27", $components->getPremiseNumber());
        $this->assertEquals("27.5", $components->getPremisePrefixNumber());
        $this->assertEquals("28", $components->getPremiseType());
        $this->assertEquals("29", $components->getThoroughfare());
        $this->assertEquals("30", $components->getThoroughfarePredirection());
        $this->assertEquals("31", $components->getThoroughfarePostdirection());
        $this->assertEquals("32", $components->getThoroughfareName());
        $this->assertEquals("33", $components->getThoroughfareTrailingType());
        $this->assertEquals("34", $components->getThoroughfareType());
        $this->assertEquals("35", $components->getDependentThoroughfare());
        $this->assertEquals("36", $components->getDependentThoroughfarePredirection());
        $this->assertEquals("37", $components->getDependentThoroughfarePostdirection());
        $this->assertEquals("38", $components->getDependentThoroughfareName());
        $this->assertEquals("39", $components->getDependentThoroughfareTrailingType());
        $this->assertEquals("40", $components->getDependentThoroughfareType());
        $this->assertEquals("41", $components->getBuilding());
        $this->assertEquals("42", $components->getBuildingLeadingType());
        $this->assertEquals("43", $components->getBuildingName());
        $this->assertEquals("44", $components->getBuildingTrailingType());
        $this->assertEquals("45", $components->getSubBuildingType());
        $this->assertEquals("46", $components->getSubBuildingNumber());
        $this->assertEquals("47", $components->getSubBuildingName());
        $this->assertEquals("48", $components->getSubBuilding());
        $this->assertEquals("49", $components->getPostBox());
        $this->assertEquals("50", $components->getPostBoxType());
        $this->assertEquals("51", $components->getPostBoxNumber());
        //endregion

        //region [ Metadata ]
        $metadata = $candidate->getMetadata();
        $this->assertNotNull($metadata);
        $this->assertEquals(52, $metadata->getLatitude());
        $this->assertEquals(53, $metadata->getLongitude());
        $this->assertEquals("54", $metadata->getGeocodePrecision());
        $this->assertEquals("55", $metadata->getMaxGeocodePrecision());
        $this->assertEquals("56", $metadata->getAddressFormat());
        //endregion

        //region [ Analysis ]
        $analysis = $candidate->getAnalysis();
        $this->assertNotNull($analysis);
        $this->assertEquals("57", $analysis->getVerificationStatus());
        $this->assertEquals("58", $analysis->getAddressPrecision());
        $this->assertEquals("59", $analysis->getMaxAddressPrecision());

        //region [ Changes ]
        $changes = $analysis->getChanges();
        $this->assertNotNull($changes);
        $this->assertEquals("60", $changes->getOrganization());
        $this->assertEquals("61", $changes->getAddress1());
        $this->assertEquals("62", $changes->getAddress2());
        $this->assertEquals("63", $changes->getAddress3());
        $this->assertEquals("64", $changes->getAddress4());
        $this->assertEquals("65", $changes->getAddress5());
        $this->assertEquals("66", $changes->getAddress6());
        $this->assertEquals("67", $changes->getAddress7());
        $this->assertEquals("68", $changes->getAddress8());
        $this->assertEquals("69", $changes->getAddress9());
        $this->assertEquals("70", $changes->getAddress10());
        $this->assertEquals("71", $changes->getAddress11());
        $this->assertEquals("72", $changes->getAddress12());

        //region [ Changes->Components ]
        $components = $changes->getComponents();
        $this->assertNotNull($components);
        $this->assertEquals("73", $components->getCountryIso3());
        $this->assertEquals("74", $components->getSuperAdministrativeArea());
        $this->assertEquals("75", $components->getAdministrativeArea());
        $this->assertEquals("76", $components->getSubAdministrativeArea());
        $this->assertEquals("77", $components->getDependentLocality());
        $this->assertEquals("78", $components->getDependentLocalityName());
        $this->assertEquals("79", $components->getDoubleDependentLocality());
        $this->assertEquals("80", $components->getLocality());
        $this->assertEquals("81", $components->getPostalCode());
        $this->assertEquals("82", $components->getPostalCodeShort());
        $this->assertEquals("83", $components->getPostalCodeExtra());
        $this->assertEquals("84", $components->getPremise());
        $this->assertEquals("85", $components->getPremiseExtra());
        $this->assertEquals("86", $components->getPremiseNumber());
        $this->assertEquals("87", $components->getPremisePrefixNumber());
        $this->assertEquals("88", $components->getPremiseType());
        $this->assertEquals("89", $components->getThoroughfare());
        $this->assertEquals("90", $components->getThoroughfarePredirection());
        $this->assertEquals("91", $components->getThoroughfarePostdirection());
        $this->assertEquals("92", $components->getThoroughfareName());
        $this->assertEquals("93", $components->getThoroughfareTrailingType());
        $this->assertEquals("94", $components->getThoroughfareType());
        $this->assertEquals("95", $components->getDependentThoroughfare());
        $this->assertEquals("96", $components->getDependentThoroughfarePredirection());
        $this->assertEquals("97", $components->getDependentThoroughfarePostdirection());
        $this->assertEquals("98", $components->getDependentThoroughfareName());
        $this->assertEquals("99", $components->getDependentThoroughfareTrailingType());
        $this->assertEquals("100", $components->getDependentThoroughfareType());
        $this->assertEquals("101", $components->getBuilding());
        $this->assertEquals("102", $components->getBuildingLeadingType());
        $this->assertEquals("103", $components->getBuildingName());
        $this->assertEquals("104", $components->getBuildingTrailingType());
        $this->assertEquals("105", $components->getSubBuildingType());
        $this->assertEquals("106", $components->getSubBuildingNumber());
        $this->assertEquals("107", $components->getSubBuildingName());
        $this->assertEquals("108", $components->getSubBuilding());
        $this->assertEquals("109", $components->getPostBox());
        $this->assertEquals("110", $components->getPostBoxType());
        $this->assertEquals("111", $components->getPostBoxNumber());
        //endregion
        //endregion
        //endregion
    }
}
