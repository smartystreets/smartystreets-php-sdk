<?php

namespace SmartyStreets\PhpSdk\US_Reverse_Geo;

/**
 * In addition to holding all of the input data for this lookup, this class also<br>
 *     will contain the result of the lookup after it comes back from the API.
 */
class Lookup {
    //region [ Fields ]
    private $response,
            $latitude,
            $longitude;

    //endregion

    //region [ Constructors ]

    public function __construct($latitude, $longitude) {
        $this->response = null;
        $this->latitude = round($latitude, 8);
        $this->longitude = round($longitude, 8);
    }

    //endregion

    //region [ Getters ]

    public function getResponse() {
        return $this->response;
    }

    public function getLatitude() {
        return $this->latitude;
    }

    public function getLongitude() {
        return $this->longitude;
    }

    //endregion

    //region [ Setters ]

    public function setResponse($response) {
        $this->response = $response;
    }

    //endregion
}