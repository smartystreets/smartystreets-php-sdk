<?php

namespace SmartyStreets\PhpSdk\US_Autocomplete_Pro;

if (!defined('GEOLOCATE_TYPE_CITY')) {
    define('GEOLOCATE_TYPE_CITY', 'city');
}
if (!defined('GEOLOCATE_TYPE_NONE')) {
    define('GEOLOCATE_TYPE_NONE', null);
}

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