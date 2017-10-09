<?php

define('NUMBER_OF_NODES', 5);
define('TRACE', true);
define('WAIT_TIME', 1);
define('NINF', 100);

$graph[NUMBER_OF_NODES - 1] = array();
fillRandomCosts($graph);
printToScreen($graph);

$special = $ancestor = array();
dijkstra($graph, $special, $ancestor);
echo 'Special: '.implode('-', $special).PHP_EOL
    .'Ancestor: '.implode('-', $ancestor).PHP_EOL;

function dijkstra($graph, &$special, &$ancestor)
{
    $notUsedNodes = array();
    for ($i = 1; $i < NUMBER_OF_NODES; ++$i) {
        $notUsedNodes[] = $i;
        if ($graph[0][$i] == 0) {
            $special[$i] = NINF;
        } else {
            $special[$i] = $graph[0][$i];
        }
        $ancestor[$i] = 0;
    }
    while (count($notUsedNodes) > 1) {
        echo 'Not used nodes: '.implode('-', $notUsedNodes).PHP_EOL;
        echo 'Special: '.implode('-', $special).PHP_EOL;
        echo 'Ancestor: '.implode('-', $ancestor).PHP_EOL;

        $v = selectNextV($graph, $notUsedNodes, $special, $ancestor);
        $notUsedNodes = deleteValue($notUsedNodes, $v);

        if ($v == -1) {
            echo 'Cannot achieve all nodes!'.PHP_EOL;
            exit;
        }

        foreach ($notUsedNodes as $w) {
            if ($special[$w] > $special[$v] + $graph[$v][$w]
            and $graph[$v][$w] < NINF
            and $special[$w] < NINF) {
                $special[$w] = $special[$v] + $graph[$v][$w];
                $ancestor[$w] = $v;
            }
        }
        sleep(WAIT_TIME);
        //exit;
    }
}

// Finds node with lowes distance and returns it
function selectNextV($graph, &$notUsedNodes, &$special, &$ancestor)
{
    $minCost = NINF;
    $minNode = -1;

    for ($i = 0; $i < NUMBER_OF_NODES; ++$i) {
        foreach ($notUsedNodes as $node) {
            if (!in_array($i, $notUsedNodes)
            and $graph[$i][$node] < $minCost
            and $graph[$i][$node] < NINF) {
                echo '>>>> Found! $graph['.$i.']['.$node.']='.$graph[$i][$node].PHP_EOL;
                $minCost = $graph[$i][$node];
                $minNode = $node;
                $ancestor[$node] = $i;
            }
        }
    }

    echo '>>>> Next min node is '.$minNode.PHP_EOL;

    return $minNode;
}

function deleteValue($notUsedNodes, $v)
{
    return array_diff($notUsedNodes, array($v));
}

function fillRandomCosts(&$graph)
{
    for ($i = 0; $i < NUMBER_OF_NODES; ++$i) {
        $graph[$i][$i] = NINF;
    }
    for ($i = 0; $i < NUMBER_OF_NODES; ++$i) {
        for ($j = $i + 1; $j < NUMBER_OF_NODES; ++$j) {
            $graph[$i][$j] = rand(0, 5);
            if ($graph[$i][$j] < 3) {
                $graph[$i][$j] = NINF;
            }
            $graph[$j][$i] = rand(0, 3);
            if ($graph[$j][$i] < 3) {
                $graph[$j][$i] = NINF;
            }
        }
    }
}
function printToScreen($graph)
{
    for ($i = 0; $i < NUMBER_OF_NODES; ++$i) {
        for ($j = 0; $j < NUMBER_OF_NODES; ++$j) {
            echo str_pad($graph[$i][$j], 4, ' ');
        }
        echo PHP_EOL;
    }
}
