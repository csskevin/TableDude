<?php

namespace TableDude\Converter;

include_once __DIR__ . "/../Exceptions/MixedTableException.php";
include_once __DIR__ . "/../Tools/ArrayTool.php";
include_once __DIR__ . "/HorizontalTable.php";

class MixedTable
{
    private $table;
    private $headerColumnIndex;
    private $headerRowIndex;
    private $horizontalContainsVerticalTable = true;
    
    public function __construct($table)
    {
        if(is_array($table))
        {
            $this->table = $table;
        } else {
            throw new TableDude\Exceptions\MixedTableException("Table does not match type Array!");
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

    public function setHeaderColumnIndex($headerColumnIndex)
    {
        $this->headerColumnIndex = $headerColumnIndex;
    }

    public function nestHorizontalTableInVerticalTable()
    {
        $this->horizontalContainsVerticalTable = false;
    }

    public function nestVerticalTableInHorizontalTable()
    {
        $this->horizontalContainsVerticalTable = true;
    }
    
    public function getGroupedTable()
    {
        $table = $this->table;
        if($this->horizontalContainsVerticalTable === false)
        {
            $table = \TableDude\Tools\ArrayTool::swapArray($table);
        }
        $tableWithoutHorizontalHeader = $this->getTableWithoutHorizontalHeader($table);
        $tableWithoutAnyHeader = $this->getTableWithoutVerticalHeader($tableWithoutHorizontalHeader);

        $headerRow = $this->getHorizontalHeaderWithoutVerticalCrossedCell($table);
        $headerColumn = $this->getVerticalHeaderWithoutHorizontalCrossedCell($table);
        
        $horizontalTables = $this->createHorizontalTablesFromVerticalHeaderAndTableContent($headerColumn, $tableWithoutAnyHeader);

        $groupedTables = array();
        for($i = 0; $i < count($horizontalTables); $i++)
        {
            $horizontalTable = $horizontalTables[$i];
            $instance = new HorizontalTable($horizontalTable);
            $instance->setHeaderRowIndex(0);
            $entries = $instance->getGroupedTable();
            $entry = $entries[0];
            $groupedTables[$headerRow[$i]] = $entry;
        }
        return $groupedTables;
    }

    public function getTableWithoutHorizontalHeaderByCustomIndex($table, $index)
    {
        $realIndex = \TableDude\Tools\ArrayTool::getRealIndexFromHorizontalTable($table, $index);
        array_splice($table, $realIndex, 1);
        return $table;
    }

    public function getTableWithoutHorizontalHeader($table)
    {
        return $this->getTableWithoutHorizontalHeaderByCustomIndex($table, $this->headerRowIndex);  
    }

    public function getTableWithoutVerticalHeader($table)
    {
        $swappedArray = \TableDude\Tools\ArrayTool::swapArray($table);
        $horizontalTableWithoutColumnHeader = $this->getTableWithoutHorizontalHeaderByCustomIndex($swappedArray, $this->headerColumnIndex);
        $verticalTableWithoutColumnHeader = \TableDude\Tools\ArrayTool::swapArray($horizontalTableWithoutColumnHeader);
        return $verticalTableWithoutColumnHeader;
    }

    public function getHorizontalHeaderWithoutVerticalCrossedCellByCustomIndeces($table, $headerRowIndex, $headerColumnIndex)
    {
        $realHorizontalIndex = \TableDude\Tools\ArrayTool::getRealIndexFromHorizontalTable($table, $headerRowIndex);
        $realVerticalIndex = \TableDude\Tools\ArrayTool::getRealIndexFromVerticalTable($table, $headerColumnIndex);

        $header = array_slice($table, $realHorizontalIndex, 1)[0];
        array_splice($header, $realVerticalIndex, 1);
        return $header;
    }

    public function getHorizontalHeaderWithoutVerticalCrossedCell($table)
    {
        $header = $this->getHorizontalHeaderWithoutVerticalCrossedCellByCustomIndeces($table, $this->headerRowIndex, $this->headerColumnIndex);
        return $header;
    }

    public function getVerticalHeaderWithoutHorizontalCrossedCell($table)
    {
        $swappedTable = \TableDude\Tools\ArrayTool::swapArray($table);
        $header = $this->getHorizontalHeaderWithoutVerticalCrossedCellByCustomIndeces($swappedTable, $this->headerColumnIndex, $this->headerRowIndex);
        return $header;
    }

    public function createHorizontalTablesFromVerticalHeaderAndTableContent($verticalHeader, $tableContent)
    {
        $tables = array();
        $swappedTable = \TableDude\Tools\ArrayTool::swapArray($tableContent);
        foreach($swappedTable as $singleTable)
        {
            $tmpTable = array(
                $verticalHeader,
                $singleTable
            );
            array_push($tables, $tmpTable);
        }
        return $tables;
    }
}

?>