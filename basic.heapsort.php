<?php

include 'dataStructure.heaps.php';

define('NUMBER_OF_NODES', 10);

$minheap = new MyTNodesMinHeap();
$maxheap = new MyTNodesMaxHeap();

for ($i = 1; $i <= NUMBER_OF_NODES; ++$i) {
    $obj = new TNodo();
    $obj->setCost(rand(1, 10));
    $obj->setString('Task '.$i);
    $minheap->insert($obj);
    $maxheap->insert($obj);
    echo 'Inserted << '.$obj.' (cost '.$obj->getCost().')'.PHP_EOL;

    if ($i == 5) {
        $obj->setString('String5 changed!');
    }
}

echo 'Inserted '.NUMBER_OF_NODES.' nodes.'.PHP_EOL;

echo 'Sorting with minheap:'.PHP_EOL;
for ($i = 0; $i < NUMBER_OF_NODES; ++$i) {
    $obj = $minheap->extract();
    echo 'Extracted >> '.$obj.' (cost '.$obj->getCost().')'.PHP_EOL;
}
echo 'Sorting with maxheap:'.PHP_EOL;
for ($i = 0; $i < NUMBER_OF_NODES; ++$i) {
    $obj = $maxheap->extract();
    echo 'Extracted >> '.$obj.' (cost '.$obj->getCost().')'.PHP_EOL;
}
