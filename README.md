# TableDude

TableDude parses, converts and analyses HTML Tables. This software is written in plain PHP without any external libraries (except PHPUnit for testing). 

## Compatibility

You can use this software for `PHP version >= 7.3`

It might work with older versions, but I haven't tested it.

## Quick Start

To install this software you can either use composer or install it manually.

### Composer way

`composer require csskevin/tabledude`

```php
<?php
// If you are working with composer
require __DIR__ . '/vendor/autoload.php';
?>
```

### Manual way
`git clone https://github.com/csskevin/TableDude.git`
```php
<?php
// If you installed this software manual
require __DIR__ . "/<pathToTableDude>/src/autoload.php";
?>
```

### Examples

```php
require __DIR__ . "/../src/autoload.php";

// Fetching HTML content
$content = file_get_contents("https://github.com/csskevin/TableDude/");

$simpleparser = new \TableDude\Parser\SimpleParser($content);
// Parses HTML Tables to PHP Array
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
```

You can also identify table headers by getting their fingerprint.

```php
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
```

## Testing

This software was tested with PHPUnit. The `composer.json` includes a test script.

`composer install`

`composer run-script test`

# Documentation

There are two main components:

- Parser (This parses HTML Tables to PHP Arrays)
- Converter (Let's you convert and group PHP Arrays)

## Parser
### \TableDude\Parser\SimpleParser
```php
$htmlContent = "<html><body><table><tr><td>Cell<td></tr></table></body></html>";
// Initializes an SimpleParser instance with a HTML content.
// __constructor($htmlContent);
$simpleParser = new \TableDude\Parser\SimpleParser($htmlContent);

// Returns an array of parsed html tables
$parsedHTMLTables = $simpleParser->parseHTMLTables();

/*
$parsedHTMLTables would be:

array(
    // First Table
    array(
        // First row
        array(
            "Cell"
        )
    )
)
*/
```

## Converter
There are three different converter:
- HorizontalTable
- VerticalTable
- MixedTable

### \TableDude\Converter\HorizontalTable
This table converts out of a simple parsed HTML table, an associative array where the keys equals a defined header row.

The methods will be documented in the example below
```php

$parsedHTMLTable = array(
    array(
        "Cell1 in Row1",
        "Cell2 in Row1",
        "Cell3 in Row1"
    ),
    array(
        "Cell1 in Row2",
        "Cell2 in Row2",
        "Cell3 in Row2"
    ),
    array(
        "Cell1 in Row3",
        "Cell2 in Row3",
        "Cell3 in Row3"
    )
);

// __constructor($parsedHTMLTable)
$horizontalTable = \TableDude\Converter\HorizontalTable($parsedHTMLTable);

// Sets the first array in parsedHTMLTable as header row
/*
You can also set the index to -1, then the last row will be selected
*/
$horizontalTable->setHeaderRowIndex(0);
/*
Header would now be
array(
    "Cell1 in Row1",
    "Cell2 in Row1",
    "Cell3 in Row1"
)
*/

// convertes the array
$groupedTable = $horizontalTable->getGroupedTable();

/*
This would return

array(
    array(
        "Cell1 in Row1" => "Cell1 in Row2",
        "Cell2 in Row1" => "Cell2 in Row2",
        "Cell3 in Row1" => "Cell3 in Row2"
    ),
        array(
        "Cell1 in Row1" => "Cell1 in Row3",
        "Cell2 in Row1" => "Cell2 in Row3",
        "Cell3 in Row1" => "Cell3 in Row3"
    ),
)

*/

// You can also get an fingerprint by the header of an table with, which will be return as an integer
$fingerprint = $horizontalTable->getFingerprint();

// This can be used to identify tables by the header for the next time

```

### \TableDude\Converter\VerticalTable
This table converts out of a simple parsed HTML table, an associative array where the keys equals a defined header column.

The methods will be documented in the example below
```php

$parsedHTMLTable = array(
    array(
        "Cell1 in Row1",
        "Cell2 in Row1",
        "Cell3 in Row1"
    ),
    array(
        "Cell1 in Row2",
        "Cell2 in Row2",
        "Cell3 in Row2"
    ),
    array(
        "Cell1 in Row3",
        "Cell2 in Row3",
        "Cell3 in Row3"
    )
);

// __constructor($parsedHTMLTable)
$verticalTable = \TableDude\Converter\VerticalTable($parsedHTMLTable);

/*
You can also set the index to -1, then the last column will be selected
*/
$verticalTable->setHeaderColumnIndex(0);

// Sets the first column array in parsedHTMLTable as header column
/*
Header would now be
array(
    "Cell1 in Row1",
    "Cell1 in Row2",
    "Cell1 in Row3"
)

// convertes the array
$groupedTable = $verticalTable->getGroupedTable();

/*
This would return

array(
    array(
        "Cell1 in Row1" => "Cell2 in Row1",
        "Cell1 in Row2" => "Cell2 in Row2",
        "Cell1 in Row3" => "Cell2 in Row3"
    ),
        array(
        "Cell1 in Row1" => "Cell3 in Row1",
        "Cell1 in Row2" => "Cell3 in Row2",
        "Cell1 in Row3" => "Cell3 in Row3"
    ),
)

*/

// You can also get an fingerprint by the header of an table with, which will be return as an integer
$fingerprint = $verticalTable->getFingerprint();

// This can be used to identify tables by the header for the next time

```

### \TableDude\Converter\MixedTable
This table converts out of a simple parsed HTML table, an associative array where the keys equals a defined header row and header column.

The methods will be documented in the example below
```php

$parsedHTMLTable = array(
    array(
        "Cell1 in Row1",
        "Cell2 in Row1",
        "Cell3 in Row1"
    ),
    array(
        "Cell1 in Row2",
        "Cell2 in Row2",
        "Cell3 in Row2"
    ),
    array(
        "Cell1 in Row3",
        "Cell2 in Row3",
        "Cell3 in Row3"
    )
);

// __constructor($parsedHTMLTable)
$mixedTable = \TableDude\Converter\VerticalTable($parsedHTMLTable);

/*
You can also set the index to -1, then the last row will be selected
*/
$mixedTable->setHeaderRowIndex(0);
$mixedTable->setHeaderColumnIndex(0);

// Nests the vertical Table in the horizontal Table
$mixedTable->nestVerticalTableInHorizontalTable();


// Nests the horizontal Table in the vertical Table
// $mixedTable->nestHorizontalTableInVerticalTable();


// convertes the array
$groupedTable = $mixedTable->getGroupedTable();

/*
This would return

array(
    "Cell1 in Row1" => array(
        "Cell1 in Row2" => "Cell2 in Row2",
        "Cell1 in Row3" => "Cell2 in Row3"
    ),
    "Cell2 in Row1" => array(
        "Cell1 in Row2" => "Cell3 in Row2",
        "Cell1 in Row3" => "Cell3 in Row3"
    ),
)

*/

// You can also get an fingerprint by the header of an table with, which will be return as an integer

// In the mixed table there are different types of fingerprints
// There are 6 constants to get the fingerprint of the header you wish

/*
// TD_FINGERPRINT_VERTICAL_HEADER
Would take fingerprint of 
array(
    "Cell1 in Row2",
    "Cell1 in Row3"
)
The cell which overlaps with the horizontal header is not included

// TD_FINGERPRINT_HORIZONTAL_HEADER
Would take fingerprint of 
array(
    "Cell2 in Row1",
    "Cell3 in Row2"
)
The cell which overlaps with the vertical header is not included


// TD_FINGERPRINT_MIXED_HEADER
Would take fingerprint of 
array(
    array(
        "Cell1 in Row2",
        "Cell1 in Row3"
    ),
    array(
        "Cell2 in Row1",
        "Cell3 in Row2"
    )
)
The cell which overlaps with the vertical header is not included

------

The same as above but it includes the cell, which overlaps with the horizontal and the vertical header

// TD_FINGERPRINT_VERTICAL_HEADER_WITH_CROSSED_CELL
// TD_FINGERPRINT_HORIZONTAL_HEADER_WITH_CROSSED_CELL
// TD_FINGERPRINT_MIXED_HEADER_WITH_CROSSED_CELL
*/

$fingerprint = $mixedTable->getFingerprint();

// This can be used to identify tables by the header for the next time

```