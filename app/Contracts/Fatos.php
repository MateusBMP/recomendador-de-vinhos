<?php

namespace App\Contracts;

/**
 * Fatos
 * 
 * Fatos de uma base de fatos, que é utilizada em um sistema especialista
 */
interface Fatos
{
    /**
     * Constrói a lista de fatos a partir de uma lista de entrada.
     * 
     * @param  array $fatos Lista de fatos registrados.
     */
    public function __construct(array $fatos);

    /**
     * Retorna a lista de fatos.
     * 
     * @return array Fatos
     */
    public function get();
}