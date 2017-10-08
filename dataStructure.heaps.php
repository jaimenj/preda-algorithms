<?php

class TNodo
{
    private $cost;
    private $string; // The object stored is a simple String.

    public function setCost($cost)
    {
        $this->cost = $cost;
    }

    public function getCost()
    {
        return $this->cost;
    }

    public function setString($string)
    {
        $this->string = $string;
    }

    public function __toString()
    {
        return $this->string;
    }
}

class MyTNodesMinHeap extends SplHeap
{
    public function compare($a, $b)
    {
        if ($a->getCost() < $b->getCost()) {
            return 1; // a is better
        } elseif ($a->getCost() > $b->getCost()) {
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
        if ($a->getCost() > $b->getCost()) {
            return 1; // a is better
        } elseif ($a->getCost() < $b->getCost()) {
            return -1; // b is better
        } else {
            return 0;
        }
    }
}
