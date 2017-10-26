<?php

define('NUMBER_OF_NODES', 20);
define('NUMBER_OF_EDGES_PER_NODE', 2);

$adjacentList = array();
fillRandomCosts($adjacentList);
printToScreen($adjacentList);

prim($adjacentList);

function prim($adjacentList)
{
    $nodesInTree = array(0);
    $nodesNotInTree = array();
    for ($i = 1; $i < NUMBER_OF_NODES; ++$i) {
        $nodesNotInTree[] = $i;
    }
    while (count($nodesNotInTree) > 0) {
        $nextNodeToAdd = getNextEdge($adjacentList, $nodesInTree, $nodesNotInTree);
        $nodesInTree[] = $nextNodeToAdd;
        unset($nodesNotInTree[array_search($nextNodeToAdd, $nodesNotInTree)]);
    }
}

function getNextEdge($adjacentList, $nodesInTree, $nodesNotInTree)
{
    $minCost = 100;
    $nextNode = null;
    $edge = '';

    foreach ($nodesInTree as $node) {
        foreach ($adjacentList[$node] as $key => $value) {
            if (in_array($key, $nodesNotInTree)) {
                if ($value < $minCost) {
                    $nextNode = $key;
                    $minCost = $value;
                    $edge = $node.'-'.$key;
                }
            }
        }
    }

    echo 'IN '.implode(',', $nodesInTree)
        .' NOT IN '.implode(',', $nodesNotInTree)
        .' NEXT EDGE TO ADD '.$edge.'('.$minCost.')'.PHP_EOL;

    return $nextNode;
}

function fillRandomCosts(&$adjacentList)
{
    for ($i = 0; $i < NUMBER_OF_NODES; ++$i) {
        $added = false;
        while (!$added) {
            for ($j = 0; $j < NUMBER_OF_EDGES_PER_NODE; ++$j) {
                $adjacentNode = rand(0, NUMBER_OF_NODES - 1);
                if ($adjacentNode != $i and $adjacentNode != $j) {
                    $adjacentNodeCost = rand(1, 5);
                    $adjacentList[$i][$adjacentNode] = $adjacentNodeCost;
                    $adjacentList[$adjacentNode][$i] = $adjacentNodeCost;
                    $added = true;
                }
            }
        }
    }
}
function printToScreen($adjacentList)
{
    for ($i = 0; $i < NUMBER_OF_NODES; ++$i) {
        echo $i;
        foreach ($adjacentList[$i] as $key => $value) {
            echo ' --> '.$key.'('.$value.')';
        }
        echo PHP_EOL;
    }
}
