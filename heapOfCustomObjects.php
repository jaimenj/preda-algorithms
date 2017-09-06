<?php

define('NUMBER_OF_NODES', 30);

class TNodo
{
    public $cost;
    public $name;
}

class MyTNodesHeap extends SplHeap
{
    public function compare($a, $b)
    {
        if ($a->cost < $b->cost) {
            return 1; // a is better
        } elseif ($a->cost > $b->cost) {
            return -1; // b is better
        } else {
            return 0;
        }
    }
}

$heap = new MyTNodesHeap();

for ($i = 1; $i <= NUMBER_OF_NODES; ++$i) {
    $obj = new TNodo();
    $obj->cost = rand(1, 10);
    $obj->name = 'Node '.$i;
    $heap->insert($obj);
    echo 'Inserted << '.$obj->name.' (cost '.$obj->cost.')'.PHP_EOL;
}

echo 'Inserted '.NUMBER_OF_NODES.' nodes.'.PHP_EOL;

for ($i=0; $i < NUMBER_OF_NODES; $i++) {
    $obj = $heap->extract();
    echo 'Extracted >> '.$obj->name.' (cost '.$obj->cost.')'.PHP_EOL;
}
