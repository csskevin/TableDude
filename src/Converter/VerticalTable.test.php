<?php

include_once __DIR__ . "/VerticalTable.php";

use PHPUnit\Framework\TestCase;

class VerticalTableTest extends TestCase
{
    public function testExtendedGroup()
    {
        $array = array(
            array(
                "Header1",
                "Value1",
                "Value2"
            ),
            array(
                "Header2",
                "Value11",
                "Value22"
            ),
            array(
                "Header3",
                "Value111"
            )
        );
        $expected = array(
            array(
                "Header1" => "Value1",
                "Header2" => "Value11",
                "Header3" => "Value111"
            ),
            array(
                "Header1" => "Value2",
                "Header2" => "Value22",
                "Header3" => ""
            )
        );
        $verticalTable = new \TableDude\Converter\VerticalTable($array);
        $verticalTable->setHeaderColumnIndex(0);
        $groupedTable = $verticalTable->getGroupedTable();
        $this->assertEquals($expected, $groupedTable);

        $array2 = array(
            array(
                "Header1",
                "Value1",
                "Value2"
            ),
            array(
                "Header2",
                "Value11",
                "Value22"
            ),
            array(
                "Header3",
                "Value111"
            )
        );
        $expected2 = array(
            array(
                "Value2" => "Header1",
                "Value22" => "Header2",
                "" => "Header3"
            ),
            array(
                "Value2" => "Value1",
                "Value22" => "Value11",
                "" => "Value111"
            )
        );
        $verticalTable2 = new \TableDude\Converter\VerticalTable($array2);
        $verticalTable2->setHeaderColumnIndex(2);
        $groupedTable2 = $verticalTable2->getGroupedTable();
        $this->assertEquals($expected2, $groupedTable2);
    }
    
    public function testSimpleGroup()
    {
        $array = array(
            array(
                "Header1",
                "Value1",
                "Value2"
            ),
            array(
                "Header2",
                "Value11",
                "Value22"
            ),
            array(
                "Header3",
                "Value111",
                "Value222"
            )
        );
        $expected = array(
            array(
                "Header1" => "Value1",
                "Header2" => "Value11",
                "Header3" => "Value111"
            ),
            array(
                "Header1" => "Value2",
                "Header2" => "Value22",
                "Header3" => "Value222"
            )
        );
        $verticalTable = new \TableDude\Converter\VerticalTable($array);
        $verticalTable->setHeaderColumnIndex(0);
        $groupedTable = $verticalTable->getGroupedTable();
        $this->assertEquals($expected, $groupedTable);
    }
}

?>