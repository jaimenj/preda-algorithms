<?php

define('SIZE_OF_ARRAY', 30);
define('TRACE', true);
define('WAIT_TIME', 0);

$theArray = array();
for ($i = 0; $i < SIZE_OF_ARRAY; ++$i) {
    $theArray[$i] = rand(0, 9);
}

$initialArray = $theArray;
$theArray = quicksort($theArray);
echo 'Initial array:     '.implode('-', $initialArray).PHP_EOL;
echo 'Final array:       '.implode('-', $theArray).PHP_EOL;

function quicksort($theArray)
{
    printToScreen('>> quicksorting', $theArray, '');

    $positionPivot = 0;
    if (count($theArray) <= 1) {
        return $theArray;
    } else {
        pivoting($theArray, $positionPivot);

        printToScreen('>> after pivoting', $theArray, 'pivot='.$positionPivot);

        $nItems1 = $positionPivot;
        $array1 = quicksort(array_slice($theArray, 0, $nItems1));
        $nItems2 = count($theArray) - $positionPivot - 1;
        $array2 = quicksort(array_slice($theArray, $positionPivot + 1, $nItems2));

        return array_merge($array1, array($theArray[$positionPivot]), $array2);
    }
}

function pivoting(&$theArray, &$positionPivot)
{
    $p = $theArray[0];

    printToScreen('>> pivoting', $theArray, 'using pivot [0]='.$p);

    $k = 0;
    $l = count($theArray);

    do {
        ++$k;
    } while (!($theArray[$k] > $p or $k >= count($theArray) - 1));
    do {
        --$l;
    } while (!($theArray[$l] <= $p));

    while ($k < $l) {
        // interchange
        $aux = $theArray[$k];
        $theArray[$k] = $theArray[$l];
        $theArray[$l] = $aux;

        printToScreen('>> pivoting', $theArray, 'changed ['.$k.'] with ['.$l.']');

        do {
            ++$k;
        } while (!($theArray[$k] > $p));
        do {
            --$l;
        } while (!($theArray[$l] <= $p));
    }

    // interchange
    $aux = $theArray[0];
    $theArray[0] = $theArray[$l];
    $theArray[$l] = $aux;

    printToScreen('>> pivoting', $theArray, 'changed [0] with ['.$l.']');

    $positionPivot = $l;
}

function printToScreen($preStr, $theArray, $postStr)
{
    echo str_pad($preStr, 20, ' ');
    foreach ($theArray as $item) {
        echo str_pad($item, 3, ' ');
    }
    echo $postStr.PHP_EOL;
    sleep(WAIT_TIME);
}
