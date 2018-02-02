<?php

function vueltaAtras($secuencia, $k)
{
    iniciarExploracionNivel($k);

    while (opcionesPendientes($k)) {
        extenderConSiguienteOpcion($secuencia);

        if (solucionCompleta($secuencia)) {
            procesarSolucion($secuencia);
        } else {
            if (completable($secuencia)) {
                vueltaAtras($secuencia, $k + 1);
            }
        }
    }
}

function vueltaAtras1solucion($secuencia, $k)
{
    $encontrado = false;
    iniciarExploracionNivel($k);

    while (opcionesPendientes($k) and !$encontrado) {
        extenderConSiguienteOpcion($secuencia);

        if (solucionCompleta($secuencia)) {
            procesarSolucion($secuencia);
            $encontrado = true;
        } else {
            if (completable($secuencia)) {
                vueltaAtras1solucion($secuencia, $k + 1);
            }
        }
    }
}
