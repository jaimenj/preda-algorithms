<?php

define('NUMBER_OF_TASKS', 9);
$GLOBALS['benefits'] = array();
$GLOBALS['durationTime'] = array();
$GLOBALS['deliveryTime'] = array();
$tasksDone = array();
for ($i = 0; $i < NUMBER_OF_TASKS; ++$i) {
    $GLOBALS['benefits'][$i] = rand(1, 9);
    $GLOBALS['durationTime'][$i] = rand(1, 9);
    $GLOBALS['deliveryTime'][$i] = rand(1, 99);
    $tasksDone[$i] = 0;
}

echo 'Initial optimistic estimation: '.optimisticEstimation($tasksDone).PHP_EOL;
echo 'Initial pessimistic estimation: '.pessimisticEstimation($tasksDone).PHP_EOL;

$GLOBALS['cota'] = pessimisticEstimation($tasksDone);
maximizeBenefitsWithTasks($tasksDone, 1);

echo PHP_EOL
    .'BETTER SOLUTION FOUND: '.implode(', ', $GLOBALS['betterSolution']).PHP_EOL
    .'BENEFIT OF SOLUTION:   '.benefits($GLOBALS['betterSolution']).PHP_EOL
    .PHP_EOL
    .'Benefits:              '.implode(', ', $GLOBALS['benefits']).PHP_EOL
    .'Duration time:         '.implode(', ', $GLOBALS['durationTime']).PHP_EOL
    .'Delivery time:         '.implode(', ', $GLOBALS['deliveryTime']).PHP_EOL;

function maximizeBenefitsWithTasks($tasksDone, $order)
{
    echo 'BRANCH ==>> maximizeBenefitsWithTasks('
        .implode(', ', $tasksDone).', $order='.$order.', $cota='.$GLOBALS['cota']
        .')'.PHP_EOL;

    for ($i = 0; $i < NUMBER_OF_TASKS; ++$i) {
        if ($tasksDone[$i] == 0) {
            $tasksDone[$i] = $order;
            writeToScreen($tasksDone);

            if (possibleSolution($tasksDone)) {
                echo 'Optimistic estimation: '.optimisticEstimation($tasksDone).PHP_EOL;
                echo 'Pessimistic estimation: '.pessimisticEstimation($tasksDone).PHP_EOL;

                if (benefits($tasksDone) >= $GLOBALS['cota']) {
                    $GLOBALS['cota'] = benefits($tasksDone);
                    $GLOBALS['betterSolution'] = $tasksDone;
                }

                if ($order + 1 <= NUMBER_OF_TASKS) {
                    if (optimisticEstimation($tasksDone) >= $GLOBALS['cota']) {
                        if (pessimisticEstimation($tasksDone) > $GLOBALS['cota']) {
                            $GLOBALS['cota'] = pessimisticEstimation($tasksDone);
                        }
                        maximizeBenefitsWithTasks($tasksDone, $order + 1);
                    } else {
                        echo 'BOUND!!'.PHP_EOL;
                    }
                }
            } else {
                echo 'BOUND!!'.PHP_EOL;
            }

            $tasksDone[$i] = 0;
        }
    }
}

function writeToScreen($tasksDone)
{
    echo 'Current tasks order ==>> '.implode(', ', $tasksDone).PHP_EOL;
}

// Check if current is a possible solution.
function possibleSolution($tasksDone)
{
    $timeSpent = 0;

    for ($k = 1; $k <= NUMBER_OF_TASKS; ++$k) {
        for ($i = 0; $i < NUMBER_OF_TASKS; ++$i) {
            if ($tasksDone[$i] == $k) {
                if ($timeSpent + $GLOBALS['durationTime'][$i] <= $GLOBALS['deliveryTime'][$i]) {
                    $timeSpent += $GLOBALS['durationTime'][$i];
                } else {
                    return false;
                }
            }
        }
    }

    return true;
}

// Returns benefits of current tasks order.
function benefits($tasksDone)
{
    $benefits = 0;

    for ($i = 0; $i < NUMBER_OF_TASKS; ++$i) {
        if ($tasksDone[$i] != 0) {
            $benefits += $GLOBALS['benefits'][$i];
        }
    }

    return $benefits;
}

// Only those tasks that can be done just after.
function pessimisticEstimation($tasksDone)
{
    $pessimisticEstimation = 0;
    $timeSpent = 0;

    for ($i = 0; $i < NUMBER_OF_TASKS; ++$i) {
        if ($tasksDone[$i] == 0
        and $timeSpent + $GLOBALS['durationTime'][$i] <= $GLOBALS['deliveryTime'][$i]) {
            $pessimisticEstimation += $GLOBALS['benefits'][$i];
            $timeSpent += $GLOBALS['durationTime'][$i];
        }
    }

    return $pessimisticEstimation;
}

// Remain tasks than can be collected.
function optimisticEstimation($tasksDone)
{
    $optimisticEstimation = 0;
    $timeSpent = 0;

    for ($i = 0; $i < NUMBER_OF_TASKS; ++$i) {
        if ($tasksDone[$i] != 0) {
            $optimisticEstimation += $GLOBALS['benefits'][$i];
            $timeSpent += $GLOBALS['durationTime'][$i];
        }
    }
    for ($i = 0; $i < NUMBER_OF_TASKS; ++$i) {
        if ($tasksDone[$i] == 0
        and $timeSpent + $GLOBALS['durationTime'][$i] <= $GLOBALS['deliveryTime'][$i]) {
            $optimisticEstimation += $GLOBALS['benefits'][$i];
        }
    }

    return $optimisticEstimation;
}
