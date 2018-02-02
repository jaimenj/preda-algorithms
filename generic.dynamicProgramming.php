<?php

function fibonnaciDinamica($n)
{
    $tabla = array();

    if ($n <= 1) {
        return 1;
    } else {
        $tabla[0] = $tabla[1] = 1;

        for ($i = 2; $i <= $n; ++$i) {
            $tabla[$i] = $tabla[$i - 1] + $tabla[$i - 2];
        }

        return $tabla[n];
    }
}

function fibonnaciRecursiva($n)
{
    if ($n <= 1) {
        return 1;
    } else {
        return fibonnaci($n - 1) + fibonnaci($n - 2);
    }
}
