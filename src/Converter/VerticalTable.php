<?php

namespace TableDude\Converter;
include_once __DIR__ . "/../Analysis/HeaderAnalyzation.php";
include_once __DIR__ . "/../Exceptions/VerticalTableException.php";
include_once __DIR__."/HorizontalTable.php";
include_once __DIR__ . "/../Tools/ArrayTool.php";

class VerticalTable
{
    private $table;
    private $headerColumnIndex = 0;

    public function __construct($table)
    {
        if(is_array($table))
        {
            $this->table = $table;
        } else {
            throw new TableDude\Exceptions\VerticalTableException("Table does not match type Array!");
        }
    }

    public function getTable()
    {
        return $this->table;
    }

    public function setHeaderColumnIndex($headerColumnIndex)
    {
        $this->headerColumnIndex = $headerColumnIndex;
    }
    
    public function getGroupedTable()
    {
        if(!\TableDude\Tools\ArrayTool::validateVerticalTable($this->table)) { return array(); }
        $swappedArray = \TableDude\Tools\ArrayTool::swapArray($this->table);
        $horizontalTable = new \TableDude\Converter\HorizontalTable($swappedArray);
        $horizontalTable->setHeaderRowIndex($this->headerColumnIndex);
        return $horizontalTable->getGroupedTable();
    }

    public function getHeader()
    {
        $swappedArray = \TableDude\Tools\ArrayTool::swapArray($this->table);
        $horizontalTable = new \TableDude\Converter\HorizontalTable($swappedArray);
        $horizontalTable->setHeaderRowIndex($this->headerColumnIndex);
        return $horizontalTable->getHeader();
    }

    public function getFingerprint()
    {
        $fingerPrintArray = $this->getHeader();
        return \TableDude\Analysis\HeaderAnalyzation::getFingerPrintOfArray($fingerPrintArray);
    }
}

?>