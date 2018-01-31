<?php

function Voraz($conjuntoCandidatos)
{
    $solucion = array();

    while (count($conjuntoCandidatos) != 0 and !esSolucion($solucion)) {
        $x = seleccionarSiguiente($conjuntoCandidatos);
        $conjuntoCandidatos = array_diff($conjuntoCandidatos, array($x));

        if (esFactible(array_merge($solucion, array($x)))) {
            $solucion = array_merge($solucion, array($x));
        }
    }

    if (esSolucion($solucion)) {
        return $solucion;
    } else {
        echo 'No hay solución.'.PHP_EOL;
    }
}
