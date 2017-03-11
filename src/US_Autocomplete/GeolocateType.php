<?php

namespace SmartyStreets\PhpSdk\US_Autocomplete;

define('GEOLOCATE_TYPE_CITY', 'city', false);
define('GEOLOCATE_TYPE_STATE', 'state', false);
define('GEOLOCATE_TYPE_NONE', null, false);

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