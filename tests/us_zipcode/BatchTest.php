<?php
require_once(dirname(dirname(dirname(__FILE__))) . '/src/smartystreets/api/us_zipcode/Batch.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/src/smartystreets/api/us_zipcode/Lookup.php');
use smartystreets\api\us_zipcode\Batch as Batch;
use smartystreets\api\us_zipcode\Lookup as Lookup;


class BatchTest extends \PHPUnit_Framework_TestCase {
    function testGetsLookupByInputId() {
        $batch = new Batch();
        $lookup = (new Lookup())->setInputId("hasInputId");

        $batch->add($lookup);

        $this->assertNotNull($batch->getLookupById("hasInputId"));
    }

    function testGetsLookupsByIndex() {
        $batch = new Batch();
        $lookup = new Lookup();
        $lookup->setCity("Provo");

        $batch->add($lookup);

        $this->assertEquals("Provo", $batch->getLookupByIndex(0)->getCity());
    }

    function testReturnsCorrectSize() {
        $batch = new Batch();

        $lookup = (new Lookup())->setInputId("inputId");
        $lookup1 = new Lookup();
        $lookup2 = new Lookup();

        $batch->add($lookup);
        $batch->add($lookup1);
        $batch->add($lookup2);

        $this->assertEquals(3, $batch->size());
    }

    function testAddingALookupWhenBatchIsFullThrowsException() {
        $batch = new Batch();
        $lookup = new Lookup();

        $exMessage = "";

        for ($i = 0; $i < $batch::MAX_BATCH_SIZE + 1; $i++) {
            $batch->add($lookup);
        }

        //TODO: implement exceptions/errors
    }

    function testClearMethodClearsBothLookupCollections() {
        $batch = new Batch();
        $lookup = new Lookup();

        $batch->add($lookup);
        $batch->add($lookup);

        $batch->clear();

        $this->assertEquals(0, count($batch->getAllLookups()));
        $this->assertEquals(0, count($batch->getNamedLookups()));
    }


}
