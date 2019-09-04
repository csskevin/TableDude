<?php

require "HorizontalTable.php";

use PHPUnit\Framework\TestCase;

class HorizontalTableTest extends TestCase
{
    
    public function testSimpleGroup()
    {
        $table = array(
            array(
                "Header1",
                "Header2"
            ),
            array(
                "Value1",
                "Value2"
            ),
            array(
                "Value3",
                "Value4"
            )
        );
        $expectedResult = array(
            array(
                "Header1" => "Value1",
                "Header2" => "Value2"
            ),
            array(
                "Header1" => "Value3",
                "Header2" => "Value4"
            )
        );
        $horizontalTable = new TableDude\Converter\HorizontalTable($table);
        $horizontalTable->setHeaderRowIndex(0);
        $groupedTable = $horizontalTable->getGroupedTable();
        $this->assertEquals($groupedTable, $expectedResult);

        $table2 = array(
            array(
                "Value1",
                "Value2",
                "Value3",
                "Value4",
                "Value5",
                "Value6"
            ),
            array(
                "Value7",
                "Value8",
                "Value9",
                "Value10",
                "Value11",
                "Value12",
                "Value13"
            ),
            array(
                "Value14"
            ),
            array(
                "Header1",
                "Header2"
            )
        );
        $expectedResult2 = array(
            array(
                "Header1" => "Value1",
                "Header2" => "Value2",
                "Header3" => "Value3",
                "Header4" => "Value4",
                "Header5" => "Value5",
                "Header6" => "Value6"
            ),
            array(
                "Header1" => "Value7",
                "Header2" => "Value8",
                "Header3" => "Value9",
                "Header4" => "Value10",
                "Header5" => "Value11",
                "Header6" => "Value12"
            ),
            array(
                "Header1" => "Value14",
                "Header2" => "",
                "Header3" => "",
                "Header4" => "",
                "Header5" => "",
                "Header6" => ""
            )
        );
        $horizontalTable2 = new TableDude\Converter\HorizontalTable($table2);
        $horizontalTable2->setHeaderRowIndex(-1);
        $horizontalTable2->extendHeader(array("Header3", "Header4", "Header5", "Header6"));
        $groupedTable2 = $horizontalTable2->getGroupedTable();
        $this->assertEquals($groupedTable2, $expectedResult2);
    }
    
    
    public function testTrimTableToHeaderLength()
    {
        $table = array(
            array(
                "Header1",
                "Header2"
            ),
            array(
                "Value1",
                "Value2",
                "Value3"
            ),
            array(
                "Value11",
                "Value22"
            ),
            array(
                "Value1"
            )
        );
        $horizontalTable = new TableDude\Converter\HorizontalTable($table);
        $horizontalTable->setHeaderRowIndex(0);
        $horizontalTable->trimTableToHeaderLength();
        $expected = array(
            array(
                "Header1",
                "Header2"
            ),
            array(
                "Value1",
                "Value2"
            ),
            array(
                "Value11",
                "Value22"
            ),
            array(
                "Value1",
                ""
            )
        );
        $this->assertEquals($expected, $horizontalTable->getTable());
    }
    
    public function testGetHeader()
    {
        $table = array(
            "1",
            "2",
            "3",
            "4"
        );
        $horizontalTable = new TableDude\Converter\HorizontalTable($table);

        $horizontalTable->setHeaderRowIndex(0);
        $header = $horizontalTable->getHeader();
        $this->assertEquals($header, "1");

        $horizontalTable->setHeaderRowIndex(-1);
        $header = $horizontalTable->getHeader();
        $this->assertEquals($header, "4");

        $horizontalTable->setHeaderRowIndex(2);
        $header = $horizontalTable->getHeader();
        $this->assertEquals($header, "3");
    }
    
    public function testExtendedHeader()
    {
        $table = array(
            array("Value1", "Value2", "Value3"),
            array("Header1", "Header2"),
            array("Value3", "Value4", "Value7")
        );
        $horizontalTable = new TableDude\Converter\HorizontalTable($table);
        $horizontalTable->setHeaderRowIndex(1);
        $horizontalTable->extendHeader(array("Header3", "Header4"));
        $header = $horizontalTable->getHeader();
        $this->assertEquals($header, array("Header1", "Header2", "Header3", "Header4"));

        $horizontalTable2 = new TableDude\Converter\HorizontalTable($table);
        $horizontalTable2->setHeaderRowIndex(-2);
        $horizontalTable2->extendHeader(array("Header3", "Header4"));
        $header2 = $horizontalTable2->getHeader();
        $this->assertEquals($header2, array("Header1", "Header2", "Header3", "Header4"));

        $horizontalTable3 = new TableDude\Converter\HorizontalTable($table);
        $horizontalTable3->setHeaderRowIndex(-1);
        $horizontalTable3->extendHeader(array("Header3", "Header4"));
        $header3 = $horizontalTable3->getHeader();
        $this->assertEquals($header3, array("Value3", "Value4", "Value7", "Header3", "Header4"));
    }
}

?>