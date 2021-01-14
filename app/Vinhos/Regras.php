<?php

namespace App\Vinhos;

use App\Models\Fato;
use App\Models\Regra;

/**
 * Regras de vinhos
 * 
 * Regras da base de regras do sistema especialista em vinhos.
 */
class Regras
{
    public function get()
    {
        return $this->base_de_regras();
    }

    private function base_de_regras()
    {
        return [
            new Regra([
                new Fato("", ""),
                new Fato("", "")
            ], new Fato("", ""))
        ];
    }
}