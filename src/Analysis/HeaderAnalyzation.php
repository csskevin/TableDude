<?php

namespace TableDude\Analysis;

include_once __DIR__ . "/../Converter/HorizontalTable.php";
include_once __DIR__ . "/../Converter/VerticalTable.php";
include_once __DIR__ . "/../Converter/MixedTable.php";
include_once __DIR__ . "/../Exceptions/HeaderAnalyzation.php";

class HeaderAnalyzation
{
    public static function sortArray(&$array)
    {
        foreach ($array as &$value) {
            if (is_array($value)) HeaderAnalyzation::sortArray($value);
         }
         return sort($array);
    }

    public static function getFingerPrintOfHeader($instance)
    {
        if($instance instanceof \TableDude\Converter\HorizontalTable || $instance instanceof \TableDude\Converter\VerticalTable)
        {
            $header = $instance->getHeader();
            HeaderAnalyzation::sortArray($header);
            $fingerprint = crc32(serialize($header));
            return $fingerprint;
        }
        else if($instance instanceof \TableDude\Converter\MixedTable)
        {
            $cellArray = $instance->getCrossedCellAsArray($instance->getTable());
            $horizontalHeader = $instance->getHorizontalHeaderWithoutVerticalCrossedCell($instance->getTable());
            $verticalHeader = $instance->getVerticalHeaderWithoutHorizontalCrossedCell($instance->getTable());
            $fullHeader = array(
                $cellArray,
                $horizontalHeader,
                $verticalHeader
            );
            HeaderAnalyzation::sortArray($fullHeader);
            $fingerprint = crc32(serialize($fullHeader));
            return $fingerprint;
        }
        else
        {
            throw new \TableDude\Exceptions\HeaderAnalyzation("\$instance must be an instance of HorizontalTable, VerticalTable or MixedTable");
        }
        
    }
}

?>