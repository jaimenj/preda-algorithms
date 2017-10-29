<?php

define('NUMBER_OF_NODES', 12);
define('NUMBER_OF_EDGES_PER_NODE', 2);
define('MAX_COST', 5);

$adjacentList = array();
fillRandomCosts($adjacentList);
printToScreenAdjacentList($adjacentList);

$finalEdges = kruskal($adjacentList);

// Printing solution.
if (count($finalEdges) < NUMBER_OF_NODES - 1) {
    echo 'Not full connected graph!!'.PHP_EOL;
} else {
    echo 'Final edges: ';
    foreach ($finalEdges as $edge) {
        echo $edge['n1'].'-'.$edge['n2'].' ';
    }
    echo PHP_EOL;
}

function kruskal($adjacentList)
{
    $orderedEdges = orderEdgesWithCosts($adjacentList);
    $finalEdges = array();

    // Init each set with each node.
    $sets = array();
    for ($i = 0; $i < NUMBER_OF_NODES; ++$i) {
        $sets[] = array($i);
    }

    // Finding edges.
    while (count($finalEdges) < NUMBER_OF_NODES - 1
    and count($orderedEdges) > 0) {
        $nextEdge = array_shift($orderedEdges);

        $componentN1 = searchConnectedComponent($nextEdge['n1'], $sets);
        $componentN2 = searchConnectedComponent($nextEdge['n2'], $sets);

        echo $nextEdge['n1'].'-'.$nextEdge['n2'].'('.$nextEdge['cost'].') ';
        foreach ($sets as $set) {
            echo '{'.implode(',', $set).'}';
        }
        echo ' N1='.$componentN1.' N2='.$componentN2;

        if ($componentN1 != $componentN2) {
            // Fuse component 2 into 1.
            foreach ($sets[$componentN2] as $node) {
                $sets[$componentN1][] = $node;
            }
            unset($sets[$componentN2]);

            // Adds this edge to solution.
            $finalEdges[] = array(
                'n1' => $nextEdge['n1'],
                'n2' => $nextEdge['n2'],
            );

            echo ' using this edge!';
        } else {
            echo ' not using..';
        }

        echo PHP_EOL;
    }

    return $finalEdges;
}

function searchConnectedComponent($node, $sets)
{
    foreach ($sets as $key => $set) {
        if (in_array($node, $set)) {
            return $key;
        }
    }
}

function orderEdgesWithCosts($adjacentList)
{
    $orderedEdges = array();
    for ($i = 1; $i <= MAX_COST; ++$i) {
        foreach ($adjacentList as $nodeFromNumber => $nodeFromValues) {
            foreach ($nodeFromValues as $nodeToNumber => $nodeToCost) {
                if ($nodeToCost == $i) {
                    $orderedEdges[] = array(
                        'cost' => $nodeToCost,
                        'n1' => $nodeFromNumber,
                        'n2' => $nodeToNumber,
                    );
                }
            }
        }
    }

    return $orderedEdges;
}

function fillRandomCosts(&$adjacentList)
{
    for ($i = 0; $i < NUMBER_OF_NODES; ++$i) {
        $added = false;
        while (!$added) {
            for ($j = 0; $j < NUMBER_OF_EDGES_PER_NODE; ++$j) {
                $adjacentNode = rand(0, NUMBER_OF_NODES - 1);
                if ($adjacentNode != $i and $adjacentNode != $j) {
                    $adjacentNodeCost = rand(1, MAX_COST);
                    $adjacentList[$i][$adjacentNode] = $adjacentNodeCost;
                    $adjacentList[$adjacentNode][$i] = $adjacentNodeCost;
                    $added = true;
                }
            }
        }
    }
}

function printToScreenAdjacentList($adjacentList)
{
    for ($i = 0; $i < NUMBER_OF_NODES; ++$i) {
        echo $i;
        foreach ($adjacentList[$i] as $key => $value) {
            echo ' --> '.$key.'('.$value.')';
        }
        echo PHP_EOL;
    }
}
