<?php

namespace SmartyStreets\PhpSdk\US_Autocomplete_Pro;

define('GEOLOCATE_TYPE_CITY', 'city', false);
define('GEOLOCATE_TYPE_NONE', null, false);

/**
 * This field corresponds to the <b>prefer_geolocation</b> field in the US Autocomplete Pro API.
 *
 * @see "https://smartystreets.com/docs/cloud/us-autocomplete-api#http-request-input-fields"
 */
class GeolocateType {
    private $name;

    public function __construct($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }
}