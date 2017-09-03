<?php

define('N', 3);
define('WAIT_TIME', 3);
define('TRACE', true);
$GLOBALS['TOTAL_SOLUTIONS'] = 0;
$GLOBALS['SOLUTIONS'] = array();
$square = array();
for ($i = 0; $i < N; ++$i) {
    for ($j = 0; $j < N; ++$j) {
        $square[$i][$j] = 0;
    }
}

echo 'NxN latin square with N='.N.'. Let\'s start filling with colors..'.PHP_EOL;
latinSquare($square, 1);
echo 'Total solutions found: '.$GLOBALS['TOTAL_SOLUTIONS'].PHP_EOL;

function latinSquare($square, $color)
{
    if (TRACE) {
        echo '---> latingSquare! Filling square with $color='.$color.PHP_EOL;
    }

    foreach (completions($square, $color) as $possibleSolution) {
        if (possible($possibleSolution)) {
            if (isSolution($possibleSolution)) { // Procces solution..
                if (TRACE) {
                    echo '=====>> SOLUTION FOUND!'.PHP_EOL;
                    writeToScreen($possibleSolution);
                    sleep(WAIT_TIME);
                }
                ++$GLOBALS['TOTAL_SOLUTIONS'];
                $GLOBALS['SOLUTIONS'][] = $possibleSolution;
            } else {
                if (completable($possibleSolution)) {
                    if ($color + 1 <= N) {
                        latinSquare($possibleSolution, $color + 1);
                    }
                }
            }
        }
    }
}

function writeToScreen($square)
{
    for ($i = 0; $i < N; ++$i) {
        for ($j = 0; $j < N; ++$j) {
            echo str_pad($square[$i][$j], 3, ' ', STR_PAD_BOTH);
        }
        echo PHP_EOL;
    }
}

// Only check if it doesn't have any 0s.
function isSolution($square)
{
    return !completable($square);
}

// Check if it has any 0s.
function completable($square)
{
    for ($i = 0; $i < N; ++$i) {
        for ($j = 0; $j < N; ++$j) {
            if ($square[$i][$j] == 0) {
                return true;
            }
        }
    }

    return false;
}

// Check if it has the same color in any row or col.
function possible($square)
{
    for ($i = 0; $i < N; ++$i) {
        // cols
        $cont = array_fill(1, N, 0);
        for ($j = 0; $j < N; ++$j) {
            if ($square[$j][$i] != 0) {
                ++$cont[$square[$j][$i]];
            }
        }
        foreach ($cont as $value) {
            if ($value > 1) {
                return false;
            }
        }

        // rows
        $cont = array_fill(1, N, 0);
        for ($j = 0; $j < N; ++$j) {
            if ($square[$i][$j] != 0) {
                ++$cont[$square[$i][$j]];
            }
        }
        foreach ($cont as $value) {
            if ($value > 1) {
                return false;
            }
        }
    }

    return true;
}

// Fill squares with colors and return array with all possible fillings.
function completions($square, $color)
{
    $completions = array();

    for ($j = 0; $j < N; ++$j) {
        if ($square[0][$j] == 0) {
            $square[0][$j] = $color;

            completionsRecursive($completions, $square, $color, 1);

            $square[0][$j] = 0;
        }
    }

    return $completions;
}
function completionsRecursive(&$completions, $square, $color, $row)
{
    for ($j = 0; $j < N; ++$j) {
        if ($square[$row][$j] == 0) {
            $square[$row][$j] = $color;
            if (possible($square)) {
                if ($row + 1 < N) {
                    completionsRecursive($completions, $square, $color, $row + 1);
                } else {
                    $completions[] = $square;
                }
            }
            $square[$row][$j] = 0;
        }
    }
}
