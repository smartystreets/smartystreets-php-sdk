<?php

namespace SmartyStreets\PhpSdk\US_Reverse_Geo;

require_once('Address.php');
require_once('Coordinate.php');
require_once(dirname(dirname(__FILE__)) . '/ArrayUtil.php');
use SmartyStreets\PhpSdk\ArrayUtil;

/**
 * A result is a possible match for an coordinates that were submitted.<br>
 *     A response can have multiple results.
 *
 * @see "https://smartystreets.com/docs/cloud/us-reverse-geo-api#address"
 */
class Result  {

    //region [ Fields ]

    private $address,
        $distance,
        $coordinate;

    //endregion

    public function __construct($obj = null) {
        if ($obj == null)
            return;

        $this->address = new Address(ArrayUtil::setField($obj, 'address', array()));
        $this->distance = ArrayUtil::setField($obj,'distance');
        $this->coordinate = new Coordinate(ArrayUtil::setField($obj, 'coordinate', array()));
    }

    //region [ Getters ]


    public function getAddress() {
        return $this->address;
    }

    public function getDistance() {
        return $this->distance;
    }

    public function getCoordinate() {
        return $this->coordinate;
    }


    //endregion
}