<?php

namespace TableDude\Converter;

class HorizontalTable
{
    private $table;
    private $headerRowIndex;

    public function __construct($table)
    {
        if(is_array($table))
        {
            $this->table = $table;
        } else {
            throw new \Exception("Table is not of type array!");
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
                throw new \Exception("Sliced Header is not length 1");
            }
        } 
        else 
        {
            throw new \Exception("Header Row index out of range!");
        }
    }

    public function extendHeader($extend)
    {
        $header = $this->getHeader();
        $extendedHeader = array_merge($header, $extend);
        if(count($this->table) > $this->headerRowIndex && count($this->table) >= ($this->headerRowIndex * -1))
        {
            $headerIndex = 0;
            if($this->headerRowIndex >= 0)
            {
                $headerIndex = $this->headerRowIndex;
            } else {
                $headerIndex = count($this->table) + $this->headerRowIndex;
            }
            $this->table[$headerIndex] = $extendedHeader;
        } else {
            throw new \Exception("Header Row index out of range!");
        }
    }
}

?>