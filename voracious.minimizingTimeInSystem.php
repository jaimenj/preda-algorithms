<?php

define('NUMBER_OF_TASKS', 30);

for ($i = 0; $i < NUMBER_OF_TASKS; ++$i) {
    $tasksTime[$i] = rand(1, 10);
}

$totalTimeClientsWaiting = printTasks($tasksTime);

echo 'Without sorting, total time tasks waiting to finalize: '.$totalTimeClientsWaiting.PHP_EOL;
asort($tasksTime);
echo 'After shorting, the order to do tasks to minize time in system is:'.PHP_EOL;

$totalTimeClientsWaiting = printTasks($tasksTime);

echo 'Total time final of tasks waiting to finalize: '.$totalTimeClientsWaiting.PHP_EOL;

function printTasks($tasksTime)
{
    $total = 0;
    $tasksRemaining = count($tasksTime);

    echo 'Tasks:  ';
    foreach ($tasksTime as $task => $time) {
        echo str_pad($task, 4, ' ');
        $total = $total + $time * $tasksRemaining;
        --$tasksRemaining;
    }
    echo PHP_EOL.'Time:   ';
    foreach ($tasksTime as $task => $time) {
        echo str_pad($time, 4, ' ');
    }
    echo PHP_EOL;

    return $total;
}
