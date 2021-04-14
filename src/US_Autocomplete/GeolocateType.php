<?php

namespace SmartyStreets\PhpSdk\US_Autocomplete;

if (!defined('GEOLOCATE_TYPE_CITY')) {
    define('GEOLOCATE_TYPE_CITY', 'city');
}
if (!defined('GEOLOCATE_TYPE_NONE')) {
    define('GEOLOCATE_TYPE_NONE', null);
}
define('GEOLOCATE_TYPE_STATE', 'state');

/**
 * This field corresponds to the <b>geolocate</b> and <b>geolocate_precision</b> fields in the US Autocomplete API.
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