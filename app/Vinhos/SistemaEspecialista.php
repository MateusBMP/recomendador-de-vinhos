<?php

namespace App\Vinhos;

use App\Contracts\SistemaEspecialista as ContractSistemaEspecialista;

/**
 * Sistema especialista em vinhos
 * 
 * O sistema especialista em vinhos é capaz de recomendar um vinho a partir de uma base de regras 
 * e conjunto de perguntas feitas ao cliente.
 */
class SistemaEspecialista extends ContractSistemaEspecialista
{
    /**
     * Pergunta qual o melhor vinho a partir do que o cliente informar como fato na base de regras.
     * 
     * @return \App\Models\Fato|null
     */
    public function melhor_vinho()
    {
        return $this->buscar("vinho");
    }
}