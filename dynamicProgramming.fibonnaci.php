<?php

define('MAX_N', 100);

for ($i = 0; $i <= MAX_N; ++$i) {
    $timeStart = microtime(true);
    $theNumber = fibonnaciRecursive($i);
    //echo 'fibonnaciRecursive('.$i.') = '.$theNumber.PHP_EOL;
    $timeEnd = microtime(true);
    echo 'RECURSIVE fibonnaci('.$i.'): Calculated in '.number_format($timeEnd - $timeStart, 9).' seconds.'.PHP_EOL;

    $timeStart = microtime(true);
    $theNumber = fibonnaciDynamic($i);
    //echo 'fibonnaciDynamic('.$i.') = '.$theNumber.PHP_EOL;
    $timeEnd = microtime(true);
    echo '  DYNAMIC fibonnaci('.$i.'): Calculated in '.number_format($timeEnd - $timeStart, 9).' seconds.'.PHP_EOL;
}

function fibonnaciDynamic($n)
{
    $tabla = array();

    if ($n <= 1) {
        return 1;
    } else {
        $tabla[0] = $tabla[1] = 1;

        for ($i = 2; $i <= $n; ++$i) {
            $tabla[$i] = $tabla[$i - 1] + $tabla[$i - 2];
        }

        return $tabla[$n];
    }
}

function fibonnaciRecursive($n)
{
    if ($n <= 1) {
        return 1;
    } else {
        return fibonnaciRecursive($n - 1) + fibonnaciRecursive($n - 2);
    }
}
