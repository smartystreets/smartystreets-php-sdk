<?php

namespace SmartyStreets\PhpSdk\US_Reverse_Geo;

require_once('Result.php');
require_once(dirname(dirname(__FILE__)) . '/ArrayUtil.php');

/**
 * A response contains possible matches for coordinates that were submitted.<br>
 *
 * @see "https://smartystreets.com/docs/cloud/us-reverse-geo-api#response"
 */
class Response
{

    //region [ Fields ]

    private $results;

    //endregion

    public function __construct($obj = null)
    {
        if ($obj == null)
            return;

        foreach($obj['results'] as $result) {
            $this->results[] = new Result($result);
        }
    }

    //region [ Getters ]


    public function getResults()
    {
        return $this->results;
    }


    //endregion
}