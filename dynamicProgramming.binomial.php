<?php

define('MAX_N', 100);

for ($n = 3; $n <= MAX_N; ++$n) {
    $k = intval($n / 2);
    $timeStart = microtime(true);
    $theNumber = binomialRecursive($n, $k);
    //echo 'binomialRecursive('.$n.', '.$k.') = '.$theNumber.PHP_EOL;
    $timeEnd = microtime(true);
    echo 'RECURSIVE binomial('.$n.','.$k.'): Calculated in '.number_format($timeEnd - $timeStart, 9).' seconds.'.PHP_EOL;

    $timeStart = microtime(true);
    $theNumber = binomialDynamic($n, $k);
    //echo 'binomialDynamic('.$n.', '.$k.') = '.$theNumber.PHP_EOL;
    $timeEnd = microtime(true);
    echo '  DYNAMIC binomial('.$n.','.$k.'): Calculated in '.number_format($timeEnd - $timeStart, 9).' seconds.'.PHP_EOL;
}

function binomialDynamic($n, $k)
{
    $tablaNK = array();

    if ($k <= 0 or $k == $n) {
        return 1;
    } else {
        for ($i = 0; $i <= $n; ++$i) {
            $tablaNK[$i][0] = 1;
        }
        /*for ($i = 1; $i <= $n; ++$i) {
            $tablaNK[$i][1] = 1;
        }*/
        for ($i = 1; $i <= $k; ++$i) {
            $tablaNK[$i][$i] = 1;
        }
        for ($i = 2; $i <= $n; ++$i) {
            for ($j = 1; $j < $i; ++$j) {
                if ($j <= $k) {
                    $tablaNK[$i][$j] = $tablaNK[$i - 1][$j - 1] + $tablaNK[$i - 1][$j];
                }
            }
        }

        /*for ($i = 0; $i < $n; ++$i) {
            for ($j = 0; $j < $k; ++$j) {
                if ($j <= $i) {
                    echo str_pad($tablaNK[$i][$j], 3);
                }
            }
            echo PHP_EOL;
        }*/

        return $tablaNK[$n][$k];
    }
}

function binomialRecursive($n, $k)
{
    if ($k == 0 or $k == $n) {
        return 1;
    } else {
        return binomialRecursive($n - 1, $k - 1) + binomialRecursive($n - 1, $k);
    }
}
