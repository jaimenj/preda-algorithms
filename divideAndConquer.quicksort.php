<?php

define('SIZE_OF_ARRAY', 10);
$theArray = array();
for ($i = 0; $i < SIZE_OF_ARRAY; ++$i) {
    $theArray[$i] = rand(0, 9);
}

echo 'Initial array:     '.implode('-', $theArray).PHP_EOL;
$theArray = quicksort($theArray);
echo 'Final array:       '.implode('-', $theArray).PHP_EOL;

function quicksort($theArray)
{
    echo '>> quicksorting:   '.implode('-', $theArray).PHP_EOL;

    $positionPivot = 0;
    if (count($theArray) <= 1) {
        return $theArray;
    } else {
        pivoting($theArray, $positionPivot);

        echo '>> after pivoting: '.implode('-', $theArray).' pivot='.$positionPivot.PHP_EOL;
        sleep(3);

        $nItems1 = $positionPivot;
        $array1 = quicksort(array_slice($theArray, 0, $nItems1));
        $nItems2 = count($theArray) - $positionPivot - 1;
        $array2 = quicksort(array_slice($theArray, $positionPivot + 1, $nItems2));

        return array_merge($array1, array($theArray[$positionPivot]), $array2);
    }

    sleep(3);
}

function pivoting(&$theArray, &$positionPivot)
{
    echo '>> pivoting:       '.implode('-', $theArray).PHP_EOL;
    sleep(3);

    $p = $theArray[0];
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

        echo '>> pivoting:       '.implode('-', $theArray).PHP_EOL;
        sleep(3);

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

    echo '>> pivoting:       '.implode('-', $theArray).PHP_EOL;
    sleep(3);

    $positionPivot = $l;
}
