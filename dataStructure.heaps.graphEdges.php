<?php

class TEdge
{
    private $cost;
    private $n1;
    private $n2;

    public function setCost($cost)
    {
        $this->cost = $cost;
    }

    public function getCost()
    {
        return $this->cost;
    }

    public function setN1($n1)
    {
        $this->n1 = $n1;
    }

    public function getN1()
    {
        return $this->n1;
    }

    public function setN2($n2)
    {
        $this->n2 = $n2;
    }

    public function getN2()
    {
        return $this->n2;
    }
}

class MyTEdgesMinHeap extends SplHeap
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
