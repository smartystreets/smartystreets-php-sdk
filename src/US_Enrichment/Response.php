<?php

namespace SmartyStreets\PhpSdk\US_Enrichment;

require_once('Result.php');
require_once(dirname(dirname(__FILE__)) . '/ArrayUtil.php');

/**
 * documentation here
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