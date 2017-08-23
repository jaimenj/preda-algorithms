<?php

$numberOfCubes = 7;
$letters = 'abcdef'; //cdefghijklmnopqrstuvwxyz';
$word = '';
$cubes[$numberOfCubes - 1] = '';
$solution[$numberOfCubes - 1] = array();
$GLOBALS['totalCombinationsFound'] = 0;
define('TRACE', false);

for ($i = 0; $i < $numberOfCubes; ++$i) {
    $word .= $letters[rand(0, strlen($letters) - 1)];
    $cubes[$i] = $letters[rand(0, strlen($letters) - 1)]
        .$letters[rand(0, strlen($letters) - 1)]
        .$letters[rand(0, strlen($letters) - 1)]
        .$letters[rand(0, strlen($letters) - 1)]
        .$letters[rand(0, strlen($letters) - 1)]
        .$letters[rand(0, strlen($letters) - 1)];
    $solution[$i] = array('#', '#'); // array('position', 'face')
    echo 'Cube '.$i.': '.$cubes[$i].PHP_EOL;
}
echo 'Word to find: '.$word.PHP_EOL;

formWordWithCubesOfLetters($word, $cubes, $solution, 0);

echo PHP_EOL.'Found '.$GLOBALS['totalCombinationsFound'].' solutions.'.PHP_EOL;

function formWordWithCubesOfLetters($word, $cubes, $solution, $nCube)
{
    if (TRACE) {
        printCurrentSolution($solution);
        echo 'Current nCube: '.$nCube.PHP_EOL;
    }

    for ($face = 0; $face < 6; ++$face) {
        for ($position = 0; $position < strlen($word); ++$position) {
            if ($cubes[$nCube][$face] == $word[$position]) {
                // letter found

                if (!letterUsed($solution, $position)) {
                    $solution[$nCube] = array($position, $face);

                    if (isSolution($solution)) {
                        echo 'SOLUTION FOUND!'.PHP_EOL;
                        printCurrentSolution($solution);
                        ++$GLOBALS['totalCombinationsFound'];
                    } else {
                        // if incomplete
                        if ($nCube + 1 < count($cubes)) {
                            if (TRACE) {
                                echo 'INCOMPLETE SOLUTION, CONTINUE!'.PHP_EOL;
                            }

                            formWordWithCubesOfLetters($word, $cubes, $solution, $nCube + 1);
                        }
                    }

                    $solution[$nCube] = array('#', '#');
                }
            }
        }
    }
}

function printCurrentSolution($solution)
{
    echo 'Cube position: ';
    for ($i = 0; $i < count($solution); ++$i) {
        echo $solution[$i][0].',';
    }
    echo PHP_EOL;
    echo '         Face: ';
    for ($i = 0; $i < count($solution); ++$i) {
        echo $solution[$i][1].',';
    }
    echo PHP_EOL;
}

function isSolution($solution)
{
    $ret = true;
    foreach ($solution as $key => $value) {
        if (strcmp($value[0], '#') == 0) {
            $ret = false;
        }
    }

    return $ret;
}

function letterUsed($solution, $position)
{
    $ret = false;

    for ($i = 0; $i < count($solution); ++$i) {
        if (strcmp($solution[$i][0], $position) == 0) {
            $ret = true;
        }
    }

    return $ret;
}
