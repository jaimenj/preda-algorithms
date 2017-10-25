<?php
/**
 * This script makes a random map filled with costs of walking throw each box. Moving from
 * a position to an adjacent are the only possible movements. Then, is calculated an adjacent list
 * to represent the graph.
 */
define('NUMBER_OF_ROWS', 6);
define('NUMBER_OF_COLS', 16);
define('NUMBER_OF_NODES', NUMBER_OF_ROWS * NUMBER_OF_COLS);

// Fill random map.
$randomMap = array();
for ($row = 0; $row < NUMBER_OF_ROWS; ++$row) {
    for ($col = 0; $col < NUMBER_OF_COLS; ++$col) {
        $randomMap[$row][$col] = rand(0, 9);
    }
}

// Fill adjacent list.
$adjacentList = array();
for ($from = 0; $from < NUMBER_OF_NODES; ++$from) {
    for ($to = 0; $to < NUMBER_OF_NODES; ++$to) {
        if ($from == $to) {
            //$adjacentList[$from][$to] = 0;
        } else {
            $fromRow = floor($from / NUMBER_OF_COLS);
            $fromCol = $from % NUMBER_OF_COLS;
            $toRow = floor($to / NUMBER_OF_COLS);
            $toCol = $to % NUMBER_OF_COLS;

            //echo 'from '.$from.' to '.$to.': fromRow '.$fromRow.' fromCol '.$fromCol.', toRow '.$toRow.' toCol '.$toCol.PHP_EOL;

            // If is adjacent box, save node to list..
            if (abs($fromCol - $toCol) <= 1
            and abs($fromRow - $toRow) <= 1) {
                $adjacentList[$from][$to] = $randomMap[$toRow][$toCol];
            } else {
                //$adjacentList[$from][$to] = 0;
            }
        }
    }
}

// Print map.
echo PHP_EOL;
echo '   |  ';
for ($col = 0; $col < NUMBER_OF_COLS; ++$col) {
    echo str_pad($col, 4, ' ');
}
echo PHP_EOL;
echo '------';
for ($col = 0; $col < NUMBER_OF_COLS; ++$col) {
    echo '----';
}
echo PHP_EOL;
for ($row = 0; $row < NUMBER_OF_ROWS; ++$row) {
    echo str_pad($row, 3, ' ').'|  ';
    for ($col = 0; $col < NUMBER_OF_COLS; ++$col) {
        echo str_pad($randomMap[$row][$col], 4, ' ');
    }
    echo PHP_EOL;
}

// Print map positions.
$currentPosition = 0;
echo PHP_EOL;
echo '   |  ';
for ($col = 0; $col < NUMBER_OF_COLS; ++$col) {
    echo str_pad($col, 4, ' ');
}
echo PHP_EOL;
echo '------';
for ($col = 0; $col < NUMBER_OF_COLS; ++$col) {
    echo '----';
}
echo PHP_EOL;
for ($row = 0; $row < NUMBER_OF_ROWS; ++$row) {
    echo str_pad($row, 3, ' ').'|  ';
    for ($col = 0; $col < NUMBER_OF_COLS; ++$col) {
        echo str_pad($currentPosition, 4, ' ');
        ++$currentPosition;
    }
    echo PHP_EOL;
}

// Print adjacent list.
echo PHP_EOL;
for ($from = 0; $from < NUMBER_OF_NODES; ++$from) {
    echo str_pad($from, 3, ' ');
    foreach ($adjacentList[$from] as $node => $cost) {
        echo ' --> '.$node.'('.$cost.')';
    }
    echo PHP_EOL;
}
