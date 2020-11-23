<?php

namespace SmartyStreets\PhpSdk\US_Reverse_Geo;

require_once(dirname(dirname(__FILE__)) . '/ArrayUtil.php');
use SmartyStreets\PhpSdk\ArrayUtil;

/**
 * @see "https://smartystreets.com/docs/cloud/us-reverse-geo-api#coordinate"
 */
class Coordinate {
    //region [ Fields ]

    private $latitude,
            $longitude,
            $accuracy,
            $license;

    //endregion

    //region [ Constructor ]

    public function __construct($obj = null) {
        if ($obj == null)
            return;

        $this->latitude = ArrayUtil::setField($obj, 'latitude');
        $this->longitude = ArrayUtil::setField($obj, 'longitude');
        $this->accuracy = ArrayUtil::setField($obj, 'accuracy');
        $this->license = ArrayUtil::setField($obj, 'license');
    }

    //endregion

    //region [ Getters ]

    public function getLatitude() {
        return $this->latitude;
    }

    public function getLongitude() {
        return $this->longitude;
    }

    public function getAccuracy() {
        return $this->accuracy;
    }

    public function getLicense() {
        switch ($this->license) {
            case 1:
                return "SmartyStreets Proprietary";
            default:
                return "SmartyStreets";
        }
    }

    //endregion
}