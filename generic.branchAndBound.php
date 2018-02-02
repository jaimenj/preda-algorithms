<?php

function ramificacionYPoda($nodoRaiz, $mejorSolucion)
{
    $monticulo = new Monticulo();
    $cota = estimacionPesimista($nodoRaiz);
    $monticulo->insertar($nodoRaiz);

    while (!esVacio() and estimacionOptimista($monticulo->getPrimero()) <= $cota) {
        $nodo = $monticulo->getCima();

        foreach (hijosValidos($nodo) as $hijo) {
            if (esSolucion($hijo)) {
                if (coste($hijo) <= $cota) {
                    $cota = coste($hijo);
                    $mejorSolucion = $hijo;
                }
            } else {
                if (estimacionOptimista($hijo) <= $cota) {
                    $monticulo->insertar($hijo);
                    if (estimacionPesimista($hijo) < $cota) {
                        $cota = estimacionPesimista($hijo);
                    }
                }
            }
        }
    }
}
