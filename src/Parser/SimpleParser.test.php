<?php

require("SimpleParser.php");

use PHPUnit\Framework\TestCase;
class SimpleParserTest extends TestCase
{
    public function testMultipleTables()
    {
        $html = "<html>
            <table>
                <thead>
                    <tr>
                        <th>Head1</th>
                        <th>Head2</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Value1</td>
                        <td>Value2</td>
                        <td>Value3</td>
                    </tr>
                    <tr>
                        <td>Value4</td>
                        <td>Value5</td>
                        <td>Value6</td>
                    </tr>
                </tbody>
            </table>
            <table>
                <tr>
                    <td>1Head1</td>
                    <td>1Head2</td>
                    <td>1Head3</td>
                </tr>
                <tr>
                    <td>1Value1</td>
                    <td>1Value2</td>
                    <td>1Value3</td>
                </tr>
                <tr>
                    <td>1Value4</td>
                    <td>1Value5</td>
                    <td>1Value6</td>
                </tr>
            </table>
        </html>";
        $expected = array(
            array(
                array(
                    "Head1",
                    "Head2"
                ),
                array(
                    "Value1",
                    "Value2",
                    "Value3"
                ),
                array(
                    "Value4",
                    "Value5",
                    "Value6"
                )
            ),
            array(
                array(
                    "1Head1",
                    "1Head2",
                    "1Head3"
                ),
                array(
                    "1Value1",
                    "1Value2",
                    "1Value3"
                ),
                array(
                    "1Value4",
                    "1Value5",
                    "1Value6"
                )
            )
        );
        $tabledude = new TableDude\Parser\SimpleParser($html);
        $tables = $tabledude->parseHTMLTables();
        $this->assertEquals($tables, $expected);
    }

    public function testSingleTable()
    {
        $html = "<html>
            <table>
                <thead>
                    <tr>
                        <td>Head1</td>
                        <td>Head2</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td> Value1</td>
                        <td>Value2 </td>
                    </tr>
                    <tr>
                        <td>Value4<i>Content</i></td>
                        <td>Value5</td>
                    </tr>
                </tbody>
            </table>
        </html>";
        $expected = array(
            array(
                array(
                    "Head1",
                    "Head2"
                ),
                array(
                    "Value1",
                    "Value2"
                ),
                array(
                    "Value4Content",
                    "Value5"
                )
            )
        );
        $tabledude = new TableDude\Parser\SimpleParser($html);
        $tables = $tabledude->parseHTMLTables();
        $this->assertEquals($tables, $expected);
    }
}
?>