<?php

define('N', 8);
define('TRACE', true);
define('WAITSECS', 1);
$GLOBALS['solutions'] = array();

$chessboard[N - 1] = array();
for ($i = 0; $i < N; ++$i) {
    for ($j = 0; $j < N; ++$j) {
        $chessboard[$i][$j] = 0;
    }
}
for ($i = 0; $i < N; ++$i) {
    for ($j = 0; $j < N; ++$j) {
        $chessboard[$i][$j] = 1;
        doHorseJump($chessboard);
        $chessboard[$i][$j] = 0;
    }
}

echo 'Finally found '.count($GLOBALS['solutions']).' solutions.'.PHP_EOL;

function doHorseJump($chessboard)
{
    if (TRACE) {
        echo '=================================>> jump!'.PHP_EOL;
    }
    if (isSolution($chessboard)) {
        writeToScreen($chessboard);
        $GLOBALS['solutions'][] = $chessboard;
    } else {
        foreach (possibleJumps($chessboard) as $posibleSolution) {
            doHorseJump($posibleSolution);
        }
    }
}

function possibleJumps($chessboard)
{
    $i = currentI($chessboard);
    $j = currentJ($chessboard);
    if (TRACE) {
        writeToScreen($chessboard);
        echo 'C $i='.$i.', $j='.$j;
    }
    $possibleJumps = array();

    // move up left
    if (TRACE) {
        echo '.';
    }
    if ($i - 1 >= 0 and $j - 2 >= 0 and $chessboard[$i - 1][$j - 2] == 0) {
        $possibleJumps['A'] = $chessboard;
        $possibleJumps['A'][$i - 1][$j - 2] = $chessboard[$i][$j] + 1;
        if (TRACE) {
            echo '^';
        }
    }
    // move up right
    if (TRACE) {
        echo '.';
    }
    if ($i + 1 < N and $j - 2 >= 0 and $chessboard[$i + 1][$j - 2] == 0) {
        $possibleJumps['B'] = $chessboard;
        $possibleJumps['B'][$i + 1][$j - 2] = $chessboard[$i][$j] + 1;
        if (TRACE) {
            echo '^';
        }
    }
    // move right up
    if (TRACE) {
        echo '.';
    }
    if ($i + 2 < N and $j - 1 >= 0 and $chessboard[$i + 2][$j - 1] == 0) {
        $possibleJumps['C'] = $chessboard;
        $possibleJumps['C'][$i + 2][$j - 1] = $chessboard[$i][$j] + 1;
        if (TRACE) {
            echo '^';
        }
    }
    // move rigth down
    if (TRACE) {
        echo '.';
    }
    if ($i + 2 < N and $j + 1 < N and $chessboard[$i + 2][$j + 1] == 0) {
        $possibleJumps['D'] = $chessboard;
        $possibleJumps['D'][$i + 2][$j + 1] = $chessboard[$i][$j] + 1;
        if (TRACE) {
            echo '^';
        }
    }
    // move down right
    if (TRACE) {
        echo '.';
    }
    if ($i + 1 < N and $j + 2 < N and $chessboard[$i + 1][$j + 2] == 0) {
        $possibleJumps['E'] = $chessboard;
        $possibleJumps['E'][$i + 1][$j + 2] = $chessboard[$i][$j] + 1;
        if (TRACE) {
            echo '^';
        }
    }
    // move down left
    if (TRACE) {
        echo '.';
    }
    if ($i - 1 >= 0 and $j + 2 < N and $chessboard[$i - 1][$j + 2] == 0) {
        $possibleJumps['F'] = $chessboard;
        $possibleJumps['F'][$i - 1][$j + 2] = $chessboard[$i][$j] + 1;
        if (TRACE) {
            echo '^';
        }
    }
    // move left down
    if (TRACE) {
        echo '.';
    }
    if ($i - 2 >= 0 and $j + 1 < N and $chessboard[$i - 2][$j + 1] == 0) {
        $possibleJumps['G'] = $chessboard;
        $possibleJumps['G'][$i - 2][$j + 1] = $chessboard[$i][$j] + 1;
        if (TRACE) {
            echo '^';
        }
    }
    // move left up
    if (TRACE) {
        echo '.';
    }
    if ($i - 2 >= 0 and $j - 1 >= 0 and $chessboard[$i - 2][$j - 1] == 0) {
        $possibleJumps['H'] = $chessboard;
        $possibleJumps['H'][$i - 2][$j - 1] = $chessboard[$i][$j] + 1;
        if (TRACE) {
            echo '^';
        }
    }

    if (TRACE) {
        if (count($possibleJumps) == 0) {
            echo ' found 0 possible ways doing backtrack!'.PHP_EOL;
        } else {
            echo ' found '.count($possibleJumps).' possible ways!'.PHP_EOL;
        }
        sleep(WAITSECS);
    }

    return $possibleJumps;
}

function isSolution($chessboard)
{
    for ($i = 0; $i < N; ++$i) {
        for ($j = 0; $j < N; ++$j) {
            if ($chessboard[$i][$j] == 0) {
                return false;
            }
        }
    }

    return true;
}

function writeToScreen($chessboard)
{
    for ($j = 0; $j < N; ++$j) {
        for ($i = 0; $i < N; ++$i) {
            echo str_pad($chessboard[$i][$j], 3, ' ', STR_PAD_BOTH);
        }
        echo PHP_EOL;
    }

    return true;
}

function currentI($chessboard)
{
    $currentI = 0;
    $jumpNumber = 0;
    for ($j = 0; $j < N; ++$j) {
        for ($i = 0; $i < N; ++$i) {
            if ($chessboard[$i][$j] > $jumpNumber) {
                $jumpNumber = $chessboard[$i][$j];
                $currentI = $i;
            }
        }
    }

    if (TRACE) {
        echo 'CurrentI = '.$currentI.PHP_EOL;
    }

    return $currentI;
}

function currentJ($chessboard)
{
    $currentJ = 0;
    $jumpNumber = 0;
    for ($j = 0; $j < N; ++$j) {
        for ($i = 0; $i < N; ++$i) {
            if ($chessboard[$i][$j] > $jumpNumber) {
                $jumpNumber = $chessboard[$i][$j];
                $currentJ = $j;
            }
        }
    }

    if (TRACE) {
        echo 'CurrentJ = '.$currentJ.PHP_EOL;
    }

    return $currentJ;
}
