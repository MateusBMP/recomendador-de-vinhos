<?php

namespace App\Contracts\Interfaces;

/**
 * Base de regras
 * 
 * A base de regras de um sistema especialista contém as regras "se-então" e fatos conhecidos de 
 * um sistema especialista.
 */
interface BaseDeRegras
{
    /**
     * Constrói a base de regras utilizando uma base de fatos.
     * 
     * @param array $fatos Fatos do sistema especialista
     * @param array $regras Regras do sistema especialista
     */
    public function __construct(array $fatos, array $regras);

    /**
     * Dispara as regras da base de regras, retornando os fatos disparados.
     * 
     * @return array Fatos disparados da base de regras
     */
    public function disparar();
}