<?php

include_once "MixedTable.php";

use PHPUnit\Framework\TestCase;

class MixedTableTest extends TestCase
{    
    public function testGetTableWithoutHorizontalHeader()
    {
        $mt = new \TableDude\Converter\MixedTable(array());
        $array = array(
            array("H1", "H2", "H3"),
            array("V1", "V2", "V3"),
            array("V2", "V3", "V3")
        );
        $mt->setHeaderRowIndex(0);
        $expected1 = array(
            array("V1", "V2", "V3"),
            array("V2", "V3", "V3")
        );
        $tableWithoutHeader1 = $mt->getTableWithoutHorizontalHeader($array);
        $this->assertEquals($expected1, $tableWithoutHeader1);

        $mt->setHeaderRowIndex(-1);
        $expected2 = array(
            array("H1", "H2", "H3"),
            array("V1", "V2", "V3")
        );
        $tableWithoutHeader2 = $mt->getTableWithoutHorizontalHeader($array);
        $this->assertEquals($expected2, $tableWithoutHeader2);
    }

    public function testGetTableWithoutVerticalHeader()
    {
        $mt = new \TableDude\Converter\MixedTable(array());
        $array = array(
            array("H1", "H2", "H3"),
            array("V1", "V2", "V3"),
            array("V2", "V3", "V3")
        );
        $mt->setHeaderColumnIndex(0);
        $expected1 = array(
            array("H2", "H3"),
            array("V2", "V3"),
            array("V3", "V3")
        );
        $tableWithoutHeader1 = $mt->getTableWithoutVerticalHeader($array);
        $this->assertEquals($expected1, $tableWithoutHeader1);

        $mt->setHeaderColumnIndex(-1);
        $expected2 = array(
            array("H1", "H2"),
            array("V1", "V2"),
            array("V2", "V3")
        );
        $tableWithoutHeader2 = $mt->getTableWithoutVerticalHeader($array);
        $this->assertEquals($expected2, $tableWithoutHeader2);
    }

    public function testGetHorizontalHeaderWithoutVerticalCrossedCell()
    {
        $mt = new \TableDude\Converter\MixedTable(array());
        $array = array(
            array("H1", "H2", "H3"),
            array("V1", "V2", "V3"),
            array("V2", "V3", "V4")
        );
        $mt->setHeaderRowIndex(0);
        $mt->setHeaderColumnIndex(0);
        $expected1 = array("H2", "H3");
        $header1 = $mt->getHorizontalHeaderWithoutVerticalCrossedCell($array);
        $this->assertEquals($expected1, $header1);

        $mt->setHeaderRowIndex(-1);
        $mt->setHeaderColumnIndex(-2);
        $expected2 = array("V2", "V4");
        $header2 = $mt->getHorizontalHeaderWithoutVerticalCrossedCell($array);
        $this->assertEquals($expected2, $header2);
    }

    public function testGetVerticalHeaderWithoutHorizontalCrossedCell()
    {
        $mt = new \TableDude\Converter\MixedTable(array());
        $array = array(
            array("H1", "H2", "H3"),
            array("V1", "V2", "V3"),
            array("V2", "V3", "V4")
        );
        $mt->setHeaderRowIndex(0);
        $mt->setHeaderColumnIndex(0);
        $expected1 = array("V1", "V2");
        $header1 = $mt->getVerticalHeaderWithoutHorizontalCrossedCell($array);
        $this->assertEquals($expected1, $header1);

        $mt->setHeaderRowIndex(-1);
        $mt->setHeaderColumnIndex(-2);
        $expected2 = array("H2", "V2");
        $header2 = $mt->getVerticalHeaderWithoutHorizontalCrossedCell($array);
        $this->assertEquals($expected2, $header2);
    }

    public function testCreateHorizontalTablesFromVerticalHeaderAndTableContent()
    {
        $mt = new \TableDude\Converter\MixedTable(array());
        $verticalHeader = array("VH1", "VH2", "VH3");
        $array = array(
            array("V1", "V2", "V3"),
            array("V11", "V22", "V33"),
            array("V111", "V222", "V333")
        );
        $tables = $mt->createHorizontalTablesFromVerticalHeaderAndTableContent($verticalHeader, $array);
        $expected = array(
            array(
                array("VH1", "VH2", "VH3"),
                array("V1", "V11", "V111")
            ),
            array(
                array("VH1", "VH2", "VH3"),
                array("V2", "V22", "V222")
            ),
            array(
                array("VH1", "VH2", "VH3"),
                array("V3", "V33", "V333")
            )
        );
        $this->assertEquals($tables, $expected);
    }

    public function testGetGroupedTable()
    {
        $array = array(
            array("V1", "V2", "V3"),
            array("V11", "V22", "V33"),
            array("V111", "V222", "V333")
        );
        $mt = new \TableDude\Converter\MixedTable($array);

        $mt->setHeaderRowIndex(0);
        $mt->setHeaderColumnIndex(0);
        $groupedTable1 = $mt->getGroupedTable();
        $expected1 = array(
            "V2" => array(
                "V11" => "V22",
                "V111" => "V222"
            ),
            "V3" => array(
                "V11" => "V33",
                "V111" => "V333"
            )
        );
        $this->assertEquals($groupedTable1, $expected1);

        $mt->setHeaderRowIndex(-2);
        $mt->setHeaderColumnIndex(-2);
        $groupedTable2 = $mt->getGroupedTable();
        $expected2 = array(
            "V11" => array(
                "V2" => "V1",
                "V222" => "V111"
            ),
            "V33" => array(
                "V2" => "V3",
                "V222" => "V333"
            )
        );
        $this->assertEquals($groupedTable2, $expected2);

        $mt->nestHorizontalTableInVerticalTable();

        $mt->setHeaderRowIndex(0);
        $mt->setHeaderColumnIndex(0);
        $groupedTable3 = $mt->getGroupedTable();
        $expected3 = array(
            "V11" => array(
                "V2" => "V22",
                "V3" => "V33"
            ),
            "V111" => array(
                "V2" => "V222",
                "V3" => "V333"
            )
        );
        $this->assertEquals($groupedTable3, $expected3);

        $mt->setHeaderRowIndex(-2);
        $mt->setHeaderColumnIndex(-2);
        $groupedTable4 = $mt->getGroupedTable();
        $expected4 = array(
            "V2" => array(
                "V11" => "V1",
                "V33" => "V3"
            ),
            "V222" => array(
                "V11" => "V111",
                "V33" => "V333"
            )
        );
        $this->assertEquals($groupedTable4, $expected4);
    }
}

?>