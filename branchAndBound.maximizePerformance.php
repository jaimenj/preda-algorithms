<?php
/**
 * NOT WORKING!! TODO
 * Branch and bound:
 * Find the better way to maximize performance assigning N tasks to N workers.
 */
define('NUMBER_OF_WORKERS', 2);
define('POSSIBLE_TASKS', 20);

$workersDoTasksInTime = array();
$tasksToDo = array();
for ($i = 1; $i <= NUMBER_OF_WORKERS; ++$i) {
    $workersDoTasksInTime[$i] = array();
    for ($j = 1; $j <= POSSIBLE_TASKS; ++$j) {
        $workersDoTasksInTime[$i][$j] = rand(1, 100);
    }
    $tasksToDo[$i] = rand(1, POSSIBLE_TASKS);
}
writeToScreen($workersDoTasksInTime, $tasksToDo);

assignTasksToWorkers($workersDoTasksInTime, $tasksToDo);

function assignTasksToWorkers($workersDoTasksInTime, $tasksToDo)
{
    $heap = new MyTNodesHeap();
    $node = new TNode();
    $son = new TNode();
    $quota = $pessimisticEstimation = $costT = 0;
    $workers = array();

    for ($i = 1; $i <= NUMBER_OF_WORKERS; ++$i) {
        $workers[$i] = 0;
        $node->taskAssignedToWorker[$i] = 0;
        $node->workerIsAssigned[$i] = 0;
    }
    $node->k = 0;
    $node->costT = 0;
    $node->optimisticEstimation = optimisticEstimation($workersDoTasksInTime, $tasksToDo, $node->k, $node->costT);
    $heap->insert($node);
    $quota = pessimisticEstimation($workersDoTasksInTime, $tasksToDo, $node->k, $node->costT);

    echo '> heap is empty = '.($heap->isEmpty() ? 'Yes' : 'No').PHP_EOL
        .'> current quota = '.$quota.PHP_EOL
        .'> heap current optimistic estimation = '.$heap->current()->optimisticEstimation.PHP_EOL;

    while (!$heap->isEmpty()
    and $heap->current()->optimisticEstimation <= $quota) {
        $node = $heap->extract();

        echo '>>>> next node extracted! $node->k='.$node->k.PHP_EOL;
        //writeToScreenNode($node);

        $son->k = $node->k + 1;
        $son->taskAssignedToWorker = $node->taskAssignedToWorker;
        $son->workerIsAssigned = $node->workerIsAssigned;

        for ($i = 1; $i <= NUMBER_OF_WORKERS; ++$i) {
            echo '  >> assigning worker '.$i.PHP_EOL;
            //writeToScreenNode($son);

            if ($son->workerIsAssigned[$i] == 0) {
                echo '    ..worker '.$i.' not assigned!'.PHP_EOL;

                $son->taskAssignedToWorker[$son->k] = $i;
                $son->workerIsAssigned[$i] = 1;
                $tasksToDoSon = $tasksToDo[$son->k];
                $costSonI = $workersDoTasksInTime[$i][$tasksToDoSon];
                $son->costT = $node->costT + $costSonI;

                writeToScreenNode($son);

                if ($son->k == NUMBER_OF_WORKERS) { // complete solution
                    echo '---- complete solution!'.PHP_EOL;
                    //writeToScreenNode($son);

                    if ($son->costT <= $quota) {
                        $workers = $son->taskAssignedToWorker;
                        $costT = $son->costT;
                        $quota = $costT;
                    }
                } else { // incomplete solution
                    echo '---- incomplete solution! $son->k='.$son->k.' NUMBER_OF_WORKERS='.NUMBER_OF_WORKERS.PHP_EOL;

                    $son->optimisticEstimation = optimisticEstimation($workersDoTasksInTime, $tasksToDo, $son->k, $son->costT);
                    $heap->insert($son);

                    echo '<<<< inserted new node! $son->k='.$son->k.PHP_EOL;
                    //writeToScreenNode($son);

                    $pessimisticEstimation = pessimisticEstimation($workersDoTasksInTime, $tasksToDo, $son->k, $son->costT);
                    if ($quota > $pessimisticEstimation) {
                        $quota = $pessimisticEstimation;
                    }

                    echo '    ..current quota = '.$quota.PHP_EOL;
                }
                $son->workerIsAssigned[$i] = 0;
            } else {
                echo '    ..worker '.$i.' assigned!'.PHP_EOL;
            }
        }

        //sleep(3);
        echo '> heap is empty = '.($heap->isEmpty() ? 'Yes' : 'No').PHP_EOL
            .'> current quota = '.$quota.PHP_EOL
            .'> heap current optimistic estimation = '.(!$heap->isEmpty() ? $heap->current()->optimisticEstimation : '').PHP_EOL;
    }

    writeToScreen($workersDoTasksInTime, $tasksToDo);
    echo 'FINAL WORKERS ASIGNATION: '.implode(', ', $workers).PHP_EOL
        .'              FINAL COST: '.$costT.PHP_EOL
        .'             FINAL QUOTA: '.$quota.PHP_EOL;
}

///////////////////////////////////////////
function optimisticEstimation($workersDoTasksInTime, $tasksToDo, $k, $costT)
{
    $estimation = $costT;
    for ($i = $k + 1; $i <= NUMBER_OF_WORKERS; ++$i) {
        $lowerC = $workersDoTasksInTime[1][$tasksToDo[$i]];
        for ($j = 2; $j <= NUMBER_OF_WORKERS; ++$j) {
            if ($lowerC > $workersDoTasksInTime[$j][$tasksToDo[$i]]) {
                $lowerC = $workersDoTasksInTime[$j][$tasksToDo[$i]];
            }
        }
        $estimation += $lowerC;
    }

    return $estimation;
}

function pessimisticEstimation($workersDoTasksInTime, $tasksToDo, $k, $costT)
{
    $estimation = $costT;
    for ($i = $k + 1; $i <= NUMBER_OF_WORKERS; ++$i) {
        $upperC = $workersDoTasksInTime[1][$tasksToDo[$i]];
        for ($j = 2; $j <= NUMBER_OF_WORKERS; ++$j) {
            if ($upperC < $workersDoTasksInTime[$j][$tasksToDo[$i]]) {
                $upperC = $workersDoTasksInTime[$j][$tasksToDo[$i]];
            }
        }
        $estimation += $upperC;
    }

    return $estimation;
}

///////////////////////////////////////////
class TNode
{
    public $workers = array(); // worker $key is assigned to tasks $value
    public $assigned = array(); // worker $key is assigned or not (boolean)
    public $k;
    public $costT;
    public $optimisticEstimation;

    public function __construct()
    {
        for ($i = 1; $i <= NUMBER_OF_WORKERS; ++$i) {
            $this->taskAssignedToWorker[$i] = $this->workerIsAssigned[$i] = 0;
        }
    }
}

class MyTNodesHeap extends SplHeap
{
    public function compare($a, $b)
    {
        if ($a->costT < $b->costT) {
            return 1; // a is better
        } elseif ($a->costT > $b->costT) {
            return -1; // b is better
        } else {
            return 0;
        }
    }

    public function __clone()
    {
        foreach ($this as $obj) {
            $clones[] = clone($obj);
        }
        foreach ($clones as $obj) {
            $this->insert($obj);
        }
    }
}

function writeToScreenNode($node)
{
    echo '    > taskAssignedToWorker = '.implode(', ', $node->taskAssignedToWorker).PHP_EOL
        .'    >     workerIsAssigned = '.implode(', ', $node->workerIsAssigned).PHP_EOL
        .'    >                    k = '.$node->k.PHP_EOL
        .'    >                 cost = '.$node->costT.PHP_EOL
        .'    > optimisticEstimation = '.$node->optimisticEstimation.PHP_EOL
        ;
}

function writeToScreen($workersDoTasksInTime, $tasksToDo)
{
    echo PHP_EOL.'                    Tasks | ';
    for ($i = 1; $i <= POSSIBLE_TASKS; ++$i) {
        echo str_pad($i, 5, ' ');
    }
    echo PHP_EOL.'----------------------------';
    for ($i = 1; $i <= POSSIBLE_TASKS; ++$i) {
        echo '-----';
    }
    echo PHP_EOL;
    for ($i = 1; $i <= NUMBER_OF_WORKERS; ++$i) {
        echo 'Worker '.$i.' do tasks in time | ';
        for ($j = 1; $j <= POSSIBLE_TASKS; ++$j) {
            echo str_pad($workersDoTasksInTime[$i][$j], 5, ' ');
        }
        echo PHP_EOL;
    }
    echo PHP_EOL.'TASKS TO DO: '.implode(', ', $tasksToDo).PHP_EOL.PHP_EOL;
}
