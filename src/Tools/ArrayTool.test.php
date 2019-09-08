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

    public function testValidateHorizontalTable()
    {
        $array1 = array(
            array("1", "2", "3")
        );
        $expected1 = false;
        $result1 = \TableDude\Tools\ArrayTool::validateHorizontalTable($array1);
        $this->assertEquals($result1, $expected1);

        $array2 = array(
            array("1"),
            array("2")
        );
        $expected2 = true;
        $result2 = \TableDude\Tools\ArrayTool::validateHorizontalTable($array2);
        $this->assertEquals($result2, $expected2);

        $array3 = array(
            array("1", "2", "3"),
            array("4", "5", "6")
        );
        $expected3 = true;
        $result3 = \TableDude\Tools\ArrayTool::validateHorizontalTable($array3);
        $this->assertEquals($result3, $expected3);

        $array4 = array(
            array("1", "2", "3"),
            array(null, "5", "6")
        );
        $expected4 = true;
        $result4 = \TableDude\Tools\ArrayTool::validateHorizontalTable($array4);
        $this->assertEquals($result4, $expected4);

        $array5 = array(
            array("1", "2", "3"),
            array(array(), "5", "6")
        );
        $expected5 = false;
        $result5 = \TableDude\Tools\ArrayTool::validateHorizontalTable($array5);
        $this->assertEquals($result5, $expected5);

        $array6 = array(
            array("1", "2", "3"),
            array((object)array(), "5", "6")
        );
        $expected6 = false;
        $result6 = \TableDude\Tools\ArrayTool::validateHorizontalTable($array6);
        $this->assertEquals($result6, $expected6);

        $array7 = array(
            array("1", "2", "3"),
            "Test",
            array("4", "5", "6")
        );
        $expected7 = false;
        $result7 = \TableDude\Tools\ArrayTool::validateHorizontalTable($array7);
        $this->assertEquals($result7, $expected7);
    }

    public function testValidateVerticalTable()
    {
        $array1 = array(
            array("1"),
            array("2"),
            array("3")
        );
        $expected1 = false;
        $result1 = \TableDude\Tools\ArrayTool::validateVerticalTable($array1);
        $this->assertEquals($result1, $expected1);

        $array2 = array(
            array("1", "2"),
        );
        $expected2 = true;
        $result2 = \TableDude\Tools\ArrayTool::validateVerticalTable($array2);
        $this->assertEquals($result2, $expected2);

        $array3 = array(
            array("1", "2", "3"),
            array("4", "5", "6")
        );
        $expected3 = true;
        $result3 = \TableDude\Tools\ArrayTool::validateVerticalTable($array3);
        $this->assertEquals($result3, $expected3);
    }

    public function testValidateMixedTable()
    {
        $array1 = array(
            array("1"),
            array("2"),
            array("3")
        );
        $expected1 = false;
        $result1 = \TableDude\Tools\ArrayTool::validateMixedTable($array1);
        $this->assertEquals($result1, $expected1);

        $array2 = array(
            array("1", "2"),
        );
        $expected2 = false;
        $result2 = \TableDude\Tools\ArrayTool::validateMixedTable($array2);
        $this->assertEquals($result2, $expected2);

        $array3 = array(
            array("1", "2", "3"),
            array("4", "5", "6")
        );
        $expected3 = true;
        $result3 = \TableDude\Tools\ArrayTool::validateMixedTable($array3);
        $this->assertEquals($result3, $expected3);
    }

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
        \TableDude\Tools\ArrayTool::sortArray($array1);
        $this->assertEquals($expected1, $array1);

        $array2 = array("866", "Hey", "456", "Second");
        $expected2 = array("456", "866", "Hey", "Second");
        \TableDude\Tools\ArrayTool::sortArray($array2);
        $this->assertEquals($expected2, $array2);
    }
}

?>