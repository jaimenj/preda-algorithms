<?php

define('SIZE_OF_ARRAY', 30);
define('TRACE', true);
define('WAIT_TIME', 0);

$theArray = array();
for ($i = 0; $i < SIZE_OF_ARRAY; ++$i) {
    $theArray[$i] = rand(0, 9);
}

$initialArray = $theArray;
$theArray = mergesort($theArray);
echo 'Initial array:     '.implode('-', $initialArray).PHP_EOL;
echo 'Final array:       '.implode('-', $theArray).PHP_EOL;

function mergesort($theArray)
{
    printToScreen('>> mergesorting', $theArray, '');

    if (count($theArray) <= 1) {
        return $theArray;
    } else {
        $middlePos = count($theArray) / 2;

        $U = mergesort(array_slice($theArray, 0, $middlePos));
        $V = mergesort(array_slice($theArray, $middlePos, count($theArray) + 1 - $middlePos));

        return Fussion($U, $V);
    }
}

function Fussion($U, $V)
{
    printToScreen('>> fussioning U', $U, '');
    printToScreen('>> fussioning V', $V, '');

    $i = $j = 0;
    $finalArray = array();
    while (count($U) > 0 and count($V) > 0) {
        if ($U[0] < $V[0]) {
            $finalArray[] = array_shift($U);
        } else {
            $finalArray[] = array_shift($V);
        }
    }
    if (count($U) > 0) {
        $finalArray = array_merge($finalArray, $U);
    } else {
        $finalArray = array_merge($finalArray, $V);
    }

    printToScreen('>> fussion', $finalArray, '');

    return $finalArray;
}

function printToScreen($preStr, $theArray, $postStr)
{
    if (TRACE) {
        echo str_pad($preStr, 20, ' ');
        foreach ($theArray as $item) {
            echo str_pad($item, 3, ' ');
        }
        echo $postStr.PHP_EOL;
        sleep(WAIT_TIME);
    }
}
