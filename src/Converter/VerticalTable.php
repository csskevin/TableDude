<?php

namespace TableDude\Converter;
require __DIR__ . "/../Exceptions/VerticalTableException.php";
require __DIR__."/HorizontalTable.php";

class VerticalTable
{
    private $table;
    private $headerColumnIndex;

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
        $swappedArray = $this->swapArray();
        $horizontalTable = new \TableDude\Converter\HorizontalTable($swappedArray);
        $horizontalTable->setHeaderRowIndex($this->headerColumnIndex);
        return $horizontalTable->getGroupedTable();
    }

    public function swapArray()
    {
        $swappedTable = array();
        $longestRowLength = $this->countLongestRow();
        for($i = 0; $i < count($this->table); $i++)
        {
            for($j = 0; $j < $longestRowLength; $j++)
            {
                if(empty($swappedTable[$j])) { $swappedTable[$j] = array(); }
                $value = (empty($this->table[$i][$j])) ? '' : $this->table[$i][$j];
                $swappedTable[$j][$i] = $value;
            }
        }
        return $swappedTable;
    }

    public function countLongestRow()
    {
        $longestRow = array();
        foreach($this->table as $element)
        {
            if(count($element) > count($longestRow))
            {
                $longestRow = $element;
            }
        }
        return count($longestRow);
    }
}

?>