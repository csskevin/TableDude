<?php

require __DIR__ . "/../src/autoload.php";

// Fetching HTML content
$content = file_get_contents("https://github.com/csskevin/TableDude/");

$simpleparser = new \TableDude\Parser\SimpleParser($content);
$tables = $simpleparser->parseHTMLTables();

foreach($tables as $table)
{
    // Creating an instance of horizontal table
    $horizontalTable = new \TableDude\Converter\HorizontalTable($table);
    // Setting Header Row Index
    $horizontalTable->setHeaderRowIndex(0);
    $groupedTable = $horizontalTable->getGroupedTable();
    foreach($groupedTable as $row)
    {
        echo "Type: " . $row["Type"] . "\n";
        echo "Name: " . $row["Name"] . "\n";
        echo "Commit Message: " . $row["Latest commit message"] . "\n";
        echo "Commit Time: " . $row["Commit time"] . "\n";
        echo "----------------\n";
    }
}

?>