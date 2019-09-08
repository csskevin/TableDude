<?php

require __DIR__ . "/../src/autoload.php";

// Fetching HTML content
$content = file_get_contents("https://www.w3schools.com/html/html_tables.asp");

$simpleparser = new \TableDude\Parser\SimpleParser($content);
$tables = $simpleparser->parseHTMLTables();

foreach($tables as $table)
{
    // Creating an instance of horizontal table
    $horizontalTable = new \TableDude\Converter\HorizontalTable($table);
    // Setting Header Row Index
    $horizontalTable->setHeaderRowIndex(0);
    $groupedTable = $horizontalTable->getGroupedTable();
    $fingerprint = $horizontalTable->getFingerprint();
    // Identifying via fingerprint 
    if($fingerprint === 3377504250)
    {
        print_r($groupedTable);
    }
}

?>