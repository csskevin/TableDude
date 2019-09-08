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

There are three main components:

- Parser (This parses HTML Tables to PHP Arrays)
- Converter (Let's you convert and group PHP Arrays)
- Analysis (Let's you analyze PHP Arrays)

Documentation in progress!