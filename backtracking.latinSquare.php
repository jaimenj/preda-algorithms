<?php

define('N', 4);
$square = array();
for ($i = 0; $i < N; ++$i) {
    for ($j = 0; $j < N; ++$j) {
        $square[$i][$j] = 0;
    }
}

echo 'NxN latin square with N='.N.PHP_EOL;
writeToScreen($square);

echo 'Starting filling colors..'.PHP_EOL;
latinSquare($square, 1);

function latinSquare($square, $color)
{
    for ($i = 0; $i < N; ++$i) {
        for ($j = 0; $j < N; ++$j) {
            if ($square[$i][$j] == 0) {
                $square[$i][$j] = $color;

                echo '---> latingSquare!'.PHP_EOL;
                writeToScreen($square);

                sleep(3);

                if (possible($square)) {
                    echo 'Possible.'.PHP_EOL;
                    if (isSolution($square)) {
                        echo '=====>> SOLUTION FOUND!'.PHP_EOL;
                        writeToScreen($square);
                    } else {
                        echo 'Not solution.'.PHP_EOL;
                        if (completable($square) and $color < N) {
                            echo 'Completable.'.PHP_EOL;
                            latinSquare($square, $color + 1);
                        } else {
                            echo 'Not completable.'.PHP_EOL;
                        }
                    }
                } else {
                    echo 'Not possible.'.PHP_EOL;
                }

                //$square[$i][$j] = 0;
            }
        }
    }
}

function isSolution($square)
{
    for ($i = 0; $i < N; ++$i) {
        for ($j = 0; $j < N; ++$j) {
            if ($square[$i][$j] == 0) {
                return false;
            }
        }
    }

    return true;
}

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

function writeToScreen($square)
{
    for ($i = 0; $i < N; ++$i) {
        for ($j = 0; $j < N; ++$j) {
            echo str_pad($square[$i][$j], 3, ' ', STR_PAD_BOTH);
        }
        echo PHP_EOL;
    }
}
