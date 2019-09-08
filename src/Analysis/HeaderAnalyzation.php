<?php

namespace TableDude\Analysis;

include_once __DIR__ . "/../Tools/ArrayTool.php";
include_once __DIR__ . "/../Exceptions/HeaderAnalyzation.php";

class HeaderAnalyzation
{
    public static function getFingerPrintOfArray($array)
    {
        \TableDude\Tools\ArrayTool::sortArray($array);
        return crc32(serialize($array));
    }
}

?>