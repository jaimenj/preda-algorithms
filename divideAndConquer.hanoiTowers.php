<?php

define('NUMBER_OF_DISCS', 20);
define('TRACE', true);
define('TIME_TO_WAIT', 3);
$GLOBALS['towers'] = array();
$GLOBALS['towers']['A'] = array();
$GLOBALS['towers']['B'] = array();
$GLOBALS['towers']['C'] = array();
for ($i = NUMBER_OF_DISCS; $i >= 1; --$i) {
    array_push($GLOBALS['towers']['A'], $i);
}
$GLOBALS['movements'] = 0;

writeToScreen();

hanoi(NUMBER_OF_DISCS, $GLOBALS['towers']['A'], $GLOBALS['towers']['B'], $GLOBALS['towers']['C']);

echo 'FINAL TOWERS!'.PHP_EOL;
writeToScreen();
echo 'NUMBER OF MOVEMENTS DONE: '.$GLOBALS['movements'].PHP_EOL;

// N,  origen, destino , auxiliar
function hanoi($N, &$A, &$B, &$C)
{
    if (TRACE) {
        echo '==============>> HANOI! N='.$N.PHP_EOL;
        sleep(TIME_TO_WAIT);
    }
    if ($N == 1) {
        //echo 'Pasar disco de A a B'.PHP_EOL;
        array_push($B, array_pop($A));
        if (TRACE) {
            echo '--> MOVING DISC!'.PHP_EOL;
            writeToScreen();
            sleep(TIME_TO_WAIT);
        }
        ++$GLOBALS['movements'];
    } else {
        hanoi($N - 1, $A, $C, $B);
        //echo 'Pasar disco de A a B'.PHP_EOL;
        array_push($B, array_pop($A));
        if (TRACE) {
            echo '--> MOVING DISC!'.PHP_EOL;
            writeToScreen();
            sleep(TIME_TO_WAIT);
        }
        ++$GLOBALS['movements'];
        hanoi($N - 1, $C, $B, $A);
    }
}

function writeToScreen()
{
    foreach ($GLOBALS['towers'] as $key => $value) {
        echo $key.'>>';
        foreach ($value as $element) {
            echo str_pad($element, 3, ' ', STR_PAD_BOTH);
        }
        echo PHP_EOL;
    }
}
