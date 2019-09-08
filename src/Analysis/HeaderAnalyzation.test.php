<?php

include_once "HeaderAnalyzation.php";
include_once __DIR__ . "/../Converter/HorizontalTable.php";
include_once __DIR__ . "/../Converter/VerticalTable.php";
include_once __DIR__ . "/../Converter/MixedTable.php";
include_once __DIR__ . "/../Exceptions/HeaderAnalyzation.php";

use PHPUnit\Framework\TestCase;

class TestHeaderAnalyzation extends TestCase
{
    public function testGetFingerPrintOfHeader()
    {
        $fingerprint = \TableDude\Analysis\HeaderAnalyzation::getFingerPrintOfArray(array());
        $this->assertIsInt($fingerprint);
    }
}