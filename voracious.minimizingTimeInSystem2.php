<?php

define('NUMBER_OF_TASKS', 30);
define('NUMBER_OF_AGENTS', 3);

$tasksTime = array();

for ($i = 0; $i < NUMBER_OF_TASKS; ++$i) {
    $tasksTime[$i] = rand(1, 10);
}

$totalTimeClientsWaiting = printTasks($tasksTime, $maxTimeWaiting);
echo 'TIME IN SYSTEM OF TASKS: '.$totalTimeClientsWaiting.' WITH A MAX WAITING TIME OF '.$maxTimeWaiting.PHP_EOL;

asort($tasksTime);
echo 'Tasks sorted, asigning to agents..'.PHP_EOL;

echo 'Asigning to one agent only..'.PHP_EOL;
$totalTimeClientsWaiting = printTasks($tasksTime, $maxTimeWaiting);
echo 'TIME IN SYSTEM OF TASKS: '.$totalTimeClientsWaiting.' WITH A MAX WAITING TIME OF '.$maxTimeWaiting.PHP_EOL;

echo 'Asigning to '.NUMBER_OF_AGENTS.' agents..'.PHP_EOL;
$agentsTasks = array();
$ptrAgent = 0;
foreach ($tasksTime as $task => $time) {
    $agentsTasks[$ptrAgent][$task] = $time;
    ++$ptrAgent;
    if ($ptrAgent == NUMBER_OF_AGENTS) {
        $ptrAgent = 0;
    }
}
$totalTimeWaiting = 0;
foreach ($agentsTasks as $number => $agentTasks) {
    echo 'Tasks for agent number '.$number.PHP_EOL;
    $timeSpent = printTasks($agentTasks, $maxTimeWaiting);
    $totalTimeWaiting = $totalTimeWaiting + $timeSpent;
    echo 'TIME IN SYSTEM OF TASKS: '.$timeSpent.' WITH A MAX WAITING TIME OF '.$maxTimeWaiting.PHP_EOL;
}
echo 'TOTAL TIME IN SYSTEM OF TASKS WITH '.NUMBER_OF_AGENTS.' AGENTS: '.$totalTimeWaiting.PHP_EOL;

function printTasks($tasksTime, &$maxTimeWaiting)
{
    $total = $maxTimeWaiting = 0;
    $tasksRemaining = count($tasksTime);

    echo 'Tasks:  ';
    foreach ($tasksTime as $task => $time) {
        echo str_pad($task, 4, ' ');
        $total = $total + $time * $tasksRemaining;
        $maxTimeWaiting = $maxTimeWaiting + $time;
        --$tasksRemaining;
    }
    echo PHP_EOL.'Time:   ';
    foreach ($tasksTime as $task => $time) {
        echo str_pad($time, 4, ' ');
    }
    echo PHP_EOL;

    return $total;
}
