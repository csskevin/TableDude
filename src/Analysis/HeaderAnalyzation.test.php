<?php

include_once "HeaderAnalyzation.php";
include_once __DIR__ . "/../Converter/HorizontalTable.php";
include_once __DIR__ . "/../Converter/VerticalTable.php";
include_once __DIR__ . "/../Converter/MixedTable.php";
include_once __DIR__ . "/../Exceptions/HeaderAnalyzation.php";

use PHPUnit\Framework\TestCase;

class TestHeaderAnalyzation extends TestCase
{
    public function testSortArray()
    {
        $array1 = array(
            array("Hello", "World", "123", "345"),
            array("Test", "Hello2", "Test3")
        );
        $expected1 = array(
            array("Hello2", "Test", "Test3"),
            array("123", "345", "Hello", "World")
        );
        \TableDude\Analysis\HeaderAnalyzation::sortArray($array1);
        $this->assertEquals($expected1, $array1);

        $array2 = array("866", "Hey", "456", "Second");
        $expected2 = array("456", "866", "Hey", "Second");
        \TableDude\Analysis\HeaderAnalyzation::sortArray($array2);
        $this->assertEquals($expected2, $array2);
    }

    public function testGetFingerPrintOfHeader()
    {
        try
        {
            \TableDude\Analysis\HeaderAnalyzation::getFingerPrintOfHeader(array());
            $this->fail("Invalid instance exception was not raised!");
        }
        catch(\TableDude\Exceptions\HeaderAnalyzation $e)
        {
            $this->assertTrue(true);
        }

        $array = array(
            array("1","2","3"),
            array("4","5","6"),
            array("7","8","9")
        );

        $ht = new \TableDude\Converter\HorizontalTable($array);
        $vt = new \TableDude\Converter\VerticalTable($array);
        $mt = new \TableDude\Converter\MixedTable($array);

        $ht->setHeaderRowIndex(0);
        $vt->setHeaderColumnIndex(0);
        $mt->setHeaderRowIndex(0);
        $mt->setHeaderColumnIndex(0);

        $string1 = \TableDude\Analysis\HeaderAnalyzation::getFingerPrintOfHeader($ht);
        $string2 = \TableDude\Analysis\HeaderAnalyzation::getFingerPrintOfHeader($vt);
        $string3 = \TableDude\Analysis\HeaderAnalyzation::getFingerPrintOfHeader($mt);

        $this->assertTrue(strlen($string1) > 0);
        $this->assertTrue(strlen($string2) > 0);
        $this->assertTrue(strlen($string2) > 0);
    }
}