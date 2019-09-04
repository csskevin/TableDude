<?php

namespace TableDude\Parser;

class SimpleParser
{
    private $html;
    private $doc;
    private $xpath;
    
    public function __construct($html)
    {
        $this->html = $html;
    }

    public function parseHTMLTables()
    {
        $this->doc = new \DOMDocument();
        @$this->doc->loadHTML($this->html);
        $this->xpath = new \DOMXpath($this->doc);
        $tables = $this->xpath->query("//table");
        $parsedTables = array();
        foreach($tables as $table)
        {
            array_push($parsedTables, $this->parseTable($table));
        }
        return $parsedTables;
    }

    public function parseTable($table)
    {
        $parsedRows = array();
        $rows = $this->xpath->query("*/tr|tr", $table);
        foreach($rows as $row)
        {
            array_push($parsedRows, $this->parseRow($row));
        }
        return $parsedRows;
    }

    public function parseRow($row)
    {
        $parsedCells = array();
        $cells = $this->xpath->query("td|th", $row);
        foreach($cells as $cell)
        {
            array_push($parsedCells, $this->parseCell($cell));
        }
        return $parsedCells;
    }

    public function parseCell($cell)
    {
        $content = $cell->textContent;
        $trimmedContent = trim($content);
        return $trimmedContent;
    }
}

?>