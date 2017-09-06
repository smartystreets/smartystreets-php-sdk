<?php

namespace SmartyStreets\PhpSdk\Tests;

require_once(dirname(dirname(__FILE__)) . '/src/Batch.php');
require_once(dirname(dirname(__FILE__)) . '/src/US_ZIPCode/Lookup.php');
require_once(dirname(dirname(__FILE__)) . '/src/Exceptions/BatchFullException.php');
use SmartyStreets\PhpSdk\Batch;
use SmartyStreets\PhpSdk\US_ZIPCode\Lookup;
use SmartyStreets\PhpSdk\Exceptions\BatchFullException;
use PHPUnit\Framework\TestCase;

class BatchTest extends TestCase {
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

        try {
            for ($i = 0; $i < $batch::MAX_BATCH_SIZE + 1; $i++)
                $batch->add($lookup);
        }
        catch (BatchFullException $ex) {
            $exMessage = $ex->getMessage();
        }
        finally {
            $this->assertEquals($batch::MAX_BATCH_SIZE, $batch->size());
            $this->assertEquals("Batch size cannot exceed " . $batch::MAX_BATCH_SIZE, $exMessage);
        }
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
