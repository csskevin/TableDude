<?php

namespace TableDude\Converter;
include_once __DIR__ . "/../Analysis/HeaderAnalyzation.php";
include_once __DIR__ . "/../Exceptions/HorizontalTableException.php";
include_once __DIR__ . "/../Tools/ArrayTool.php";

class HorizontalTable
{
    private $table;
    private $headerRowIndex = 0;

    public function __construct($table)
    {
        if(is_array($table))
        {
            $this->table = $table;
        } else {
            throw new TableDude\Exceptions\HorizontalTableException("Table does not match type Array!");
        }
    }

    public function getTable()
    {
        return $this->table;
    }

    public function setHeaderRowIndex($headerRowIndex)
    {
        $this->headerRowIndex = $headerRowIndex;
    }


    public function getGroupedTable()
    {
        if(!\TableDude\Tools\ArrayTool::validateHorizontalTable($this->table)) { return array(); }
        $groupedTable = array();
        $this->trimTableToHeaderLength();
        $header = $this->getHeader();
        for($i = 0; $i < count($this->table); $i++)
        {
            $tmpGroupedTable = array();
            $tmpTable = $this->table[$i];
            if($tmpTable !== $header)
            {
                for($j = 0; $j < count($tmpTable); $j++)
                {
                    $tmpGroupedTable[$header[$j]] = $tmpTable[$j];
                }
                array_push($groupedTable, $tmpGroupedTable);
            }
        }
        return $groupedTable;
    }

    public function trimTableToHeaderLength()
    {
        $header = $this->getHeader();
        $headerLength = count($this->getHeader());
        for($index = 0; $index < count($this->table); $index++)
        {
            if($index !== $this->headerRowIndex)
            {
                if(count($this->table[$index]) < $headerLength)
                {
                    $this->table[$index] = array_pad($this->table[$index], $headerLength, "");
                } 
                else 
                {
                    $this->table[$index] = array_slice($this->table[$index], 0, $headerLength);
                }
            }
        }
    }

    public function getHeader()
    {
        if(count($this->table) > $this->headerRowIndex)
        {
            $slicedArray = array_slice($this->table, $this->headerRowIndex, 1);
            if(count($slicedArray) === 1)
            {
                return $slicedArray[0];
            }
            else
            {
                throw new TableDude\Exceptions\HorizontalTableException("Sliced element does not equal lenght 1");
            }
        } 
        else 
        {
            throw new TableDude\Exceptions\HorizontalTableException("Array out of range!");
        }
    }

    public function extendHeader($extend)
    {
        $header = $this->getHeader();
        $extendedHeader = array_merge($header, $extend);
        $realIndex = \TableDude\Tools\ArrayTool::getRealIndexFromHorizontalTable($this->table, $this->headerRowIndex);
        $this->table[$realIndex] = $extendedHeader;
    }

    public function getFingerprint()
    {
        $fingerPrintArray = $this->getHeader();
        return \TableDude\Analysis\HeaderAnalyzation::getFingerPrintOfArray($fingerPrintArray);
    }
}

?>