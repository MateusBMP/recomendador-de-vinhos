<?php

namespace App\Contracts;

use App\Contracts\Fatos;

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
     * @param  Fatos $fatos Fatos do sistema especialista
     */
    public function __construct(Fatos $fatos);

    /**
     * Dispara as regras da base de regras, retornando os fatos disparados.
     * 
     * @return array Fatos disparados da base de regras
     */
    public function disparar();

    /**
     * Fatos da base de regras.
     * 
     * @return array Lista de fatos
     */
    public function fatos();
}