<?php

define('NUMBER_OF_NODES', 17);
define('INITIAL_NODE', 3);
define('NUMBER_OF_EDGES_PER_NODE', 3);
define('IS_DIRECTED_GRAPH', true);

$adjacencyList = array();
fillRandomCosts($adjacencyList);
printToScreen($adjacencyList);

$special = $predecessor = array();
dijkstra($adjacencyList, $special, $predecessor);
echo 'FINAL> Special: '.implode('-', $special).PHP_EOL
    .'FINAL> Predecessor: '.implode('-', $predecessor).PHP_EOL;

function dijkstra($adjacencyList, &$special, &$predecessor)
{
    // Fill C with not used nodes.
    $C = array();
    for ($i = 0; $i < NUMBER_OF_NODES; ++$i) {
        if ($i != INITIAL_NODE) {
            $C[] = $i;
        }
    }

    // Fill special distances.
    for ($i = 0; $i < NUMBER_OF_NODES; ++$i) {
        if ($i != INITIAL_NODE) {
            $special[$i] = distanceFromTo($adjacencyList, INITIAL_NODE, $i);
            if ($special[$i] < INF) {
                $predecessor[$i] = INITIAL_NODE;
            } else {
                $predecessor[$i] = '#';
            }
        } else {
            $special[$i] = 'I';
            $predecessor[$i] = 'I';
        }
    }
    echo 'INITIAL_NODE = '.INITIAL_NODE.PHP_EOL
        .'INITIAL> Not used nodes: '.implode('-', $C).PHP_EOL
        .'INITIAL> Special: '.implode('-', $special).PHP_EOL
        .'INITIAL> Predecessor: '.implode('-', $predecessor).PHP_EOL;

    // Study nodes in C to update $special and predecessor vectors.
    while (count($C) > 1) {
        $v = selectNextNodeThatMinimizesSpecial($adjacencyList, $C, $special);
        $C = array_diff($C, array($v));

        if ($v == -1) {
            echo 'IMPOSSIBLE TO FIND DIJKSTRA WITH ALL NODES! Cannot achieve all nodes!'.PHP_EOL;
            exit;
        }

        foreach ($C as $w) {
            if ($special[$w] > $special[$v] + distanceFromTo($adjacencyList, $v, $w)) {
                $special[$w] = $special[$v] + distanceFromTo($adjacencyList, $v, $w);
                $predecessor[$w] = $v;
            }
        }

        echo 'Not used nodes: '.implode('-', $C).PHP_EOL
            .'Special: '.implode('-', $special).PHP_EOL
            .'Predecessor: '.implode('-', $predecessor).PHP_EOL;
    }
}

function selectNextNodeThatMinimizesSpecial($adjacencyList, &$C, &$special)
{
    $minCost = INF;
    $minNode = -1;

    for ($i = 0; $i < NUMBER_OF_NODES; ++$i) {
        foreach ($C as $node) {
            //echo $node.' '.$adjacencyList[$i][$node].PHP_EOL;
                if (!in_array($i, $C)
                and isset($adjacencyList[$i][$node])
                and $adjacencyList[$i][$node] < $minCost) {
                    echo '>>>> Found min edge! $adjacencyList['.$i.']['.$node.']='.$adjacencyList[$i][$node].PHP_EOL;
                    $minCost = $adjacencyList[$i][$node];
                    $minNode = $node;
                }
        }
    }

    echo '>>>> Next min node to use is '.$minNode.PHP_EOL;

    return $minNode;
}

function distanceFromTo($adjacencyList, $from, $to)
{
    if (isset($adjacencyList[$from][$to])) {
        return $adjacencyList[$from][$to];
    } else {
        return INF;
    }
}

function fillRandomCosts(&$adjacencyList)
{
    for ($i = 0; $i < NUMBER_OF_NODES; ++$i) {
        $added = false;
        while (!$added) {
            for ($j = 0; $j < NUMBER_OF_EDGES_PER_NODE; ++$j) {
                $adjacentNode = rand(0, NUMBER_OF_NODES - 1);
                if ($adjacentNode != $i and $adjacentNode != $j) {
                    $adjacentNodeCost = rand(1, 5);
                    $adjacencyList[$i][$adjacentNode] = $adjacentNodeCost;
                    if (!IS_DIRECTED_GRAPH) {
                        $adjacencyList[$adjacentNode][$i] = $adjacentNodeCost;
                    }
                    $added = true;
                }
            }
        }
        ksort($adjacencyList[$i]);
    }
}
function printToScreen($adjacencyList)
{
    for ($i = 0; $i < NUMBER_OF_NODES; ++$i) {
        echo $i;
        foreach ($adjacencyList[$i] as $key => $value) {
            echo ' --> '.$key.'('.$value.')';
        }
        echo PHP_EOL;
    }
}
