<?php

define('NUMBER_OF_THINGS', 7);
define('NUMBER_OF_PACKAGES', 7);
define('MAX_VOLUME', 9);
$thingsVolume = array();
$packagingCapacity = array();
$solutionThingsPackage = array();
$GLOBALS['betterSolution'] = array();
for ($i = 0; $i < NUMBER_OF_THINGS; ++$i) {
    $thingsVolume[$i] = rand(1, MAX_VOLUME);
    $packagingCapacity[$i] = MAX_VOLUME;
    $solutionThingsPackage[$i] = $GLOBALS['betterSolution'][$i] = '#';
}
echo '########################################################################################'.PHP_EOL
    .'Things volume: '.implode('-', $thingsVolume).PHP_EOL
    .'   packaging capacity: '.implode('-', $packagingCapacity).PHP_EOL
    .'   things package: '.implode('-', $solutionThingsPackage).PHP_EOL
    .'   initial optimistic estimation: '.optimisticEstimation($solutionThingsPackage).PHP_EOL
    .'   initial pessimistic estimation: '.pessimisticEstimation($solutionThingsPackage, $packagingCapacity, $thingsVolume).PHP_EOL
    .PHP_EOL;
$GLOBALS['cota'] = pessimisticEstimation($solutionThingsPackage, $packagingCapacity, $thingsVolume);

minimizeAmountOfPackaging($solutionThingsPackage, $packagingCapacity, $thingsVolume, 0);

echo PHP_EOL.PHP_EOL.'FINALLY BETTER SOLUTION: '.implode('-', $GLOBALS['betterSolution']).PHP_EOL
    .'Using '.solutionCost($GLOBALS['betterSolution']).' packages from a total of '.NUMBER_OF_PACKAGES.' packages.'.PHP_EOL;

function minimizeAmountOfPackaging($solutionThingsPackage, $packagingCapacity, $thingsVolume, $k)
{
    echo PHP_EOL.'==>> packing object with $k = '.$k.PHP_EOL
        .'Things vol.: '.implode('-', $thingsVolume)
        .' capacities: '.implode('-', $packagingCapacity)
        .' packaging: '.implode('-', $solutionThingsPackage)
        .PHP_EOL;

    for ($package = 0; $package < NUMBER_OF_PACKAGES; ++$package) {
        echo '  $package = '.$package
            .' cota = '.$GLOBALS['cota']
            .' better = '.implode('-', $GLOBALS['betterSolution'])
            .PHP_EOL;

        if ($thingsVolume[$k] <= $packagingCapacity[$package]) {
            $solutionThingsPackage[$k] = $package;
            $packagingCapacity[$package] -= $thingsVolume[$k];

            //sleep(1);

            echo '    trying with: things vol.: '.implode('-', $thingsVolume)
                .' capacities: '.implode('-', $packagingCapacity)
                .' packaging: '.implode('-', $solutionThingsPackage)
                .' optim = '.optimisticEstimation($solutionThingsPackage)
                .' pessim = '.pessimisticEstimation($solutionThingsPackage, $packagingCapacity, $thingsVolume)
                .' cota = '.$GLOBALS['cota']
                .' better = '.implode('-', $GLOBALS['betterSolution'])
                .PHP_EOL;

            if (isSolution($solutionThingsPackage)) {
                if (solutionCost($solutionThingsPackage) <= $GLOBALS['cota']) {
                    echo '    POSSIBLE SOLUTION: '.implode('-', $solutionThingsPackage).PHP_EOL;
                    $GLOBALS['cota'] = solutionCost($solutionThingsPackage);
                    $GLOBALS['betterSolution'] = $solutionThingsPackage;
                    break 1;
                }
            } else {
                if (optimisticEstimation($solutionThingsPackage) <= $GLOBALS['cota']) {
                    if ($k + 1 < NUMBER_OF_THINGS
                    and pessimisticEstimation($solutionThingsPackage, $packagingCapacity, $thingsVolume) <= $GLOBALS['cota']) {
                        minimizeAmountOfPackaging($solutionThingsPackage, $packagingCapacity, $thingsVolume, $k + 1);
                    }
                    if (pessimisticEstimation($solutionThingsPackage, $packagingCapacity, $thingsVolume) < $GLOBALS['cota']) {
                        $GLOBALS['cota'] = pessimisticEstimation($solutionThingsPackage, $packagingCapacity, $thingsVolume);
                    }
                }
            }


            $solutionThingsPackage[$k] = '#';
            $packagingCapacity[$package] += $thingsVolume[$k];
        }
    }
}

function isSolution($solutionThingsPackage)
{
    for ($i = 0; $i < NUMBER_OF_THINGS; ++$i) {
        if ($solutionThingsPackage[$i][0] == '#') {
            return false;
        }
    }

    return true;
}

function solutionCost($solutionThingsPackage)
{
    return optimisticEstimation($solutionThingsPackage);
}

function pessimisticEstimation($solutionThingsPackage, $packagingCapacity, $thingsVolume)
{
    $numberOfUsedPackaging = optimisticEstimation($solutionThingsPackage);
    $numberOfNotPackagedThings = 0;

    for ($i = 0; $i < NUMBER_OF_THINGS; ++$i) {
        if ($solutionThingsPackage[$i][0] == '#') {
            ++$numberOfNotPackagedThings;
        }
    }

    return $numberOfUsedPackaging + $numberOfNotPackagedThings;
}

function optimisticEstimation($solutionThingsPackage)
{
    $usedPackaging = array();

    for ($i = 0; $i < NUMBER_OF_THINGS; ++$i) {
        if ($solutionThingsPackage[$i][0] != '#') {
            $usedPackaging[$solutionThingsPackage[$i]] = 'used';
        }
    }

    return count($usedPackaging);
}
