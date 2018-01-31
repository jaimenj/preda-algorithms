<?php

function divideYVenceras($problema)
{
    if (esTrivial($problema)) {
        return solucionTrivial($problema);
    } else {
        $subproblemas = descomponer($problema);
        foreach ($subproblemas as $subproblema) {
            $subsoluciones[] = divideYVenceras($subproblema);
        }
    }

    return componer($subsoluciones);
}
