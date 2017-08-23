<?php

define('NUMBER_OF_THINGS', 4);
define('TRACE', false);
$thingsValues = array();
$solution = array();
$valuesSum = array(0, 0);
for ($i = 0; $i < NUMBER_OF_THINGS; ++$i) {
    $thingsValues[$i] = rand(1, 2); // value for each thing
    $solution[$i] = '#';
}
echo 'Value of '.NUMBER_OF_THINGS.' things: '.implode('-', $thingsValues).PHP_EOL;

startDistributeThingsWithDifferentValues($thingsValues, $solution, $valuesSum);

function startDistributeThingsWithDifferentValues($thingsValues, $solution, $valuesSum)
{
    $totalValuesSum = 0;
    foreach ($thingsValues as $key => $value) {
        $totalValuesSum += $value;
    }
    if ($totalValuesSum % 2 == 0) {
        distributeThingsWithDifferentValues($thingsValues, $solution, $valuesSum, $totalValuesSum, 0);
    } else {
        echo 'We can not divide things in equal parts!'.PHP_EOL;
    }
}

function distributeThingsWithDifferentValues($thingsValues, $solution, $valuesSum, $totalValuesSum, $k)
{
    if (isSolution($k, $valuesSum, $solution)) {
        echo '    ==>> SOLUTION FOUND! This one: '.implode('-', $solution).PHP_EOL;
    } else {
        for ($i = 0; $i < 2; ++$i) {
            $solution[$k] = $i;
            $valuesSum[$i] += $thingsValues[$k];

            if (TRACE) {
                echo 'Searching with $k='.$k
                .', $solution='.implode('-', $solution)
                .', $valuesSum='.implode('-', $valuesSum)
                .', $totalValuesSum='.$totalValuesSum
                .PHP_EOL;
            }

            if ($valuesSum[$i] <= $totalValuesSum / 2) {
                //echo '  Yet in allowed values.. $valuesSum='.implode('-', $valuesSum).PHP_EOL;
                if ($k < NUMBER_OF_THINGS) {
                    //echo '  going down..'.PHP_EOL;
                    distributeThingsWithDifferentValues($thingsValues, $solution, $valuesSum, $totalValuesSum, $k + 1);
                }
            }

            $valuesSum[$i] -= $thingsValues[$k];
        }
    }
}

function isSolution($k, $valuesSum, $solution)
{
    if (TRACE) {
        echo '  checking solution.. $k='.$k.', $valuesSum='.implode('-', $valuesSum).', $solution='.implode('-', $solution).PHP_EOL;
    }
    if ($k == NUMBER_OF_THINGS and $valuesSum[0] == $valuesSum[1]) {
        return true;
    } else {
        return false;
    }
}
