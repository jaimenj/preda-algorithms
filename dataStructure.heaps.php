<?php

class TNodo
{
    public $cost;
    public $name;
}

class MyTNodesMinHeap extends SplHeap
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

class MyTNodesMaxHeap extends SplHeap
{
    public function compare($a, $b)
    {
        if ($a->cost > $b->cost) {
            return 1; // a is better
        } elseif ($a->cost < $b->cost) {
            return -1; // b is better
        } else {
            return 0;
        }
    }
}
