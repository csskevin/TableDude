<?php

require __DIR__ . "/../src/autoload.php";

$html = "<html>
<head>
</head>
<body>
<table>
<tbody>
    <tr>
        <td>header</td>
        <td>header</td>
    <td>header</td>
</tr>
<tr>
    <td>content</td>
    <td>content</td>
    <td>content</td>
</tr>
<tr>
<td>test</td>
<td>test</td>
<td>test</td>
</tr>
</tbody>
</table>
</body>
</html>";

$simpleParser = new \TableDude\Parser\SimpleParser($html);
$parsedTables = $simpleParser->parseHTMLTables();

if(count($parsedTables) > 0)
{
    $firstTable = $parsedTables[0];
    $tableOrderedByColumn = \TableDude\Tools\ArrayTool::swapArray($firstTable);
    print_r($tableOrderedByColumn);
}

?>