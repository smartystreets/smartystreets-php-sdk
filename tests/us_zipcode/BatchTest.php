<?php
require_once(dirname(dirname(__FILE__)) . '/src/smartystreets/api/us_zipcode/Batch.php');
use smartystreets\api\us_zipcode\Batch as Batch;


class BatchTest extends \PHPUnit_Framework_TestCase {
    function testGetsLookupByInput() {
        $batch = new Batch();
    }

}
