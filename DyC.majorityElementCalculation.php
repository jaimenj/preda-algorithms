<?php

$numberOfItems = 10;
$minimunNumber = 1;
$maximunNumber = 2;

$array = array();
for ($i = 1; $i <= $numberOfItems; ++$i) {
    $array[$i] = rand($minimunNumber, $maximunNumber);
}

echo 'Mayority element in array('.implode(',', $array).') is: '
    .mayorityElementCalculation(1, $numberOfItems, $array)
    .PHP_EOL;

function mayorityElementCalculation($i, $j, $array)
{
    echo 'Mayority from '.$i.' to '.$j.PHP_EOL;
    if ($i == $j) {
        return $array[$i];
    } else {
        $m = intval(floor(($i + $j) / 2));
        $s1 = mayorityElementCalculation($i, $m, $array);
        $s2 = mayorityElementCalculation($m + 1, $j, $array);
        echo '    m='.$m.', s1='.$s1.', s2='.$s2.PHP_EOL;
    }
    $ret = combine($s1, $s2, $array);
    echo '    combine result = '.$ret.PHP_EOL;

    return $ret;
}

function combine($s1, $s2, $array)
{
    echo '        Combine '.$s1.'-'.$s2.PHP_EOL;
    if ($s1 == -1 and $s2 == -1) {
        return -1;
    }
    if ($s1 == -1 and $s2 != -1) {
        return checkMayority($s2, $array);
    }
    if ($s1 != -1 and $s2 == -1) {
        return checkMayority($s1, $array);
    }
    if ($s1 != -1 and $s2 != -1) {
        if (checkMayority($s1, $array) == $s1) {
            return $s1;
        } else {
            if (checkMayority($s2, $array) == $s2) {
                return $s2;
            } else {
                return -1;
            }
        }
    }
}

function checkMayority($s, $array)
{
    $c = 0;

    for ($k = 1; $k <= count($array); ++$k) {
        if ($array[$k] == $s) {
            ++$c;
        }
    }

    echo '            checkMayority = '.$c.PHP_EOL;

    if ($c > intval(count($array) / 2)) {
        return $s;
    } else {
        return -1;
    }
}
