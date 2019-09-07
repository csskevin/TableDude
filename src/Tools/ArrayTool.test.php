<?php

include_once __DIR__."/ArrayTool.php";
include_once __DIR__.'/../Exceptions/ArrayToolException.php';

use PHPUnit\Framework\TestCase;

class ArrayToolTest extends TestCase
{
    public function testSwapArray()
    {
        $array = array(
            array(
                "Value1",
                "Value2",
                "Value3"
            ),
            array(
                "Value4",
                "Value5",
                "Value6"
            ),
            array(
                "Value7",
                "Value8",
                "Value9"
            )
        );
        $swappedArray = \TableDude\Tools\ArrayTool::swapArray($array);
        $expected = array(
            array(
                "Value1",
                "Value4",
                "Value7"
            ),
            array(
                "Value2",
                "Value5",
                "Value8"
            ),
            array(
                "Value3",
                "Value6",
                "Value9"
            )
        );
        $this->assertEquals($expected, $swappedArray);

        $array2 = array(
            array(
                "Value1",
                "Value3"
            ),
            array(
                "Value4",
                "Value5",
                "Value6"
            ),
            array(
                "Value7",
                "Value8",
                "Value9"
            )
        );
        $swappedArray2 = \TableDude\Tools\ArrayTool::swapArray($array2);
        $expected2 = array(
            array(
                "Value1",
                "Value4",
                "Value7"
            ),
            array(
                "Value3",
                "Value5",
                "Value8"
            ),
            array(
                "",
                "Value6",
                "Value9"
            )
        );
        $this->assertEquals($expected2, $swappedArray2);
    }

    public function testCountLongestRow()
    {
        $array = array(
            array(
                "Value1",
                "Value2",
                "Value3",
                "Val4"
            ),
            array(
                "Value5",
                "Value6"
            ),
            array(
                "Value7",
            ),
            array(
                "Value13",
                "Value21",
                "Value32",
                "Val7"
            )
        );
        $longestRow = \TableDude\Tools\ArrayTool::countLongestRowOfArrayTable($array);
        $this->assertEquals($longestRow, 4);
    }

    public function testGetRealIndexFromHorizontalTable()
    {
        $table = array(
            array("H1","H2","H3"),
            array("V1","V2","V3"),
            array("V2","V3","V4")
        );

        $realIndex = \TableDude\Tools\ArrayTool::getRealIndexFromHorizontalTable($table, 1);
        $this->assertEquals($realIndex, 1);

        $realIndex2 = \TableDude\Tools\ArrayTool::getRealIndexFromHorizontalTable($table, -1);
        $this->assertEquals($realIndex2, 2);

        $realIndex3 = \TableDude\Tools\ArrayTool::getRealIndexFromHorizontalTable($table, -2);
        $this->assertEquals($realIndex3, 1);

        try {
            $realIndexThrowError = \TableDude\Tools\ArrayTool::getRealIndexFromHorizontalTable($table, -5);
            $this->fail("Out of range exception was not raised");
        } catch(\TableDude\Exceptions\ArrayToolException $e)
        {
            $this->assertTrue(true);
        }
        
    }

    public function testGetRealIndexFromVerticalTable()
    {
        $table = array(
            array("H1","H2","H3"),
            array("V1","V2","V3"),
            array("V2","V3","V4")
        );

        $realIndex = \TableDude\Tools\ArrayTool::getRealIndexFromVerticalTable($table, 1);
        $this->assertEquals($realIndex, 1);

        $realIndex2 = \TableDude\Tools\ArrayTool::getRealIndexFromVerticalTable($table, -1);
        $this->assertEquals($realIndex2, 2);

        $realIndex3 = \TableDude\Tools\ArrayTool::getRealIndexFromVerticalTable($table, -2);
        $this->assertEquals($realIndex3, 1);

        try {
            $realIndexThrowError = \TableDude\Tools\ArrayTool::getRealIndexFromVerticalTable($table, -5);
        } catch(\TableDude\Exceptions\ArrayToolException $e)
        {
            $this->assertTrue(true);
            return;
        }
        $this->fail("Out of range exception was not raised");
    }
}

?>