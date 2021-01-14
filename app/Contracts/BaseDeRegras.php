<?php

namespace App\Contracts;

use App\Contracts\Interfaces\BaseDeRegras as InterfaceBaseDeRegras;

/**
 * Base de regras
 * 
 * Base de regras genérica, seguindo o modelo do contrado de base de regras. Possui uma lista de 
 * fatos e regras.
 */
class BaseDeRegras implements InterfaceBaseDeRegras
{
    /**
     * @var array Lista de fatos
     */
    public $fatos;

    /**
     * @var array Lista de regras
     */
    public $regras;

    /**
     * Constrói a base de regras utilizando uma base de fatos.
     * 
     * @param array $fatos Fatos do sistema especialista
     * @param array $regras Regras do sistema especialista
     */
    public function __construct(array $fatos, array $regras)
    {
        $this->fatos = $fatos;
        $this->regras = $regras;
    }

    /**
     * Dispara as regras da base de regras, retornando os fatos disparados.
     * 
     * @return array Fatos disparados da base de regras
     */
    public function disparar()
    {
        // Lista de regras disparadas
        $disparos = [];

        foreach ($this->regras as $regra) {
            if ($regra->disparar($this->fatos))
                array_push($disparos, $regra);
        }

        return $disparos;
    }
}