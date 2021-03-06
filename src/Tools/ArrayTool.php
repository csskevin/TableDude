<?php

namespace TableDude\Tools;

include_once __DIR__.'/../Exceptions/ArrayToolException.php';

class ArrayTool
{
    public static function swapArray($array)
    {
        $swappedTable = array();
        $longestRowLength = ArrayTool::countLongestRowOfArrayTable($array);
        for($i = 0; $i < count($array); $i++)
        {
            for($j = 0; $j < $longestRowLength; $j++)
            {
                if(empty($swappedTable[$j])) { $swappedTable[$j] = array(); }
                $value = (empty($array[$i][$j])) ? '' : $array[$i][$j];
                $swappedTable[$j][$i] = $value;
            }
        }
        return $swappedTable;
    }

    public static function countLongestRowOfArrayTable($table)
    {
        if(!is_array($table)) 
        {
            throw new \TableDude\Exceptions\ArrayToolException("Table does not match type Array!");
        }
        $longestRow = array();
        foreach($table as $element)
        {
            if(count($element) > count($longestRow))
            {
                $longestRow = $element;
            }
        }
        return count($longestRow);
    }

    public static function getRealIndexFromHorizontalTable($table, $index)
    {
        if(count($table) > $index && count($table) >= ($index * -1))
        {
            $headerIndex = 0;
            if($index >= 0)
            {
                $headerIndex = $index;
            } else {
                $headerIndex = count($table) + $index;
            }
            return $headerIndex;
        } else {
            throw new \TableDude\Exceptions\ArrayToolException("Array out of range!");
        }
    }

    public static function getRealIndexFromVerticalTable($table, $index)
    {
        $swappedTable = ArrayTool::swapArray($table);
        return ArrayTool::getRealIndexFromHorizontalTable($table, $index);
    }

    public static function validateHorizontalTable($table)
    {
        if(!is_array($table)) { return false; }
        if(count($table) <= 1) { return false; }

        foreach($table as $item)
        {
            if(!is_array($item)) { return false; }
            foreach($item as $value)
            {
                if(is_array($value) || is_object($value)) { return false; }
            }
        }
        return true;
    }

    public static function validateVerticalTable($table)
    {
        if(!is_array($table)) { return false; }
        return ArrayTool::validateHorizontalTable(ArrayTool::swapArray($table));
    }

    public static function validateMixedTable($table)
    {
        if(!is_array($table)) { return false; }
        return ArrayTool::validateHorizontalTable($table) && ArrayTool::validateVerticalTable($table);
    }

    public static function sortArray(&$array)
    {
        foreach ($array as &$value) {
            if (is_array($value)) ArrayTool::sortArray($value);
         }
         return sort($array);
    }
}

?>