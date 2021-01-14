<?php

namespace App\Models;

use App\Models\Fato;

/**
 * Regra de uma base de regras
 * 
 * A regra de uma base de regra possui uma estrutura única, que contém uma verificação de disparo
 */
class Regra
{
    /**
     * @var int Índice da regra
     */
    public $id;

    /**
     * @var array lista de Fatos esperados
     */
    public $fatos;

    /**
     * @var \App\Models\Fato Novo fato resultante do disparo da regra
     */

    /**
     * Regra de uma base de regras. Deve receber um índice, uma lista de fatos esperados na regra 
     * e um novo fato resultante do disparo da regra.
     * 
     * @param  array $fatos Lista de fatos esperados
     * @param  \App\Models\Fato Novo fato resultante do disparo
     * @param  ?int $id Índice da regra
     */
    public function __construct(array $fatos, Fato $novo_fato, int $id = 0)
    {
        $this->id = $id;
        $this->fatos = $fatos;
        $this->novo_fato = $novo_fato;
    }

    /**
     * Verifica o disparo ou não de uma regra a partir da lista de fatos fornecidos. O disparo é 
     * verificado a partir da navegação entre todas os fatos esperados da regra e todos os fatos 
     * fornecidos na chamada da função. Então caso algum fato esperado não seja localizado na 
     * lista de fatos fornecidos, a função logo retorna como falsa.
     * 
     * @param  array Fatos a serem comparados
     * @return bool
     */
    public function disparar(array $fatos)
    {
        foreach ($this->fatos as $regra) {
            $disparo = false;

            foreach ($fatos as $fato) {
                if ($fato->igual_a($regra)) {
                    $disparo = true;
                    break;
                }
            }

            if ($disparo === false)
                return false;
        }

        return true;
    }

    /**
     * Verifica se uma regra é igual a outra regra, sem validar o índice delas.
     * 
     * @param  \App\Models\Regra $regra Regra a ser comparada
     * @return bool
     */
    public function igual_a(Regra $regra)
    {
        // Registra o número de fatos iguais esperados
        $fatos_esperados = count($this->fatos);

        // Conta cada fato esperado com os fatos da regra comparada, diminuindo o numero de 
        // fatos esperados, até chegar a zero
        foreach ($this->fatos as $fato_esperado) 
            foreach ($regra->fatos as $fato_passado)
                if ($fato_esperado->igual_a($fato_passado))
                    $fatos_esperados--;

        // Se número de fatos esperados igual a zero, significa que regras são igual. Senão, 
        // retorna falso
        return ($fatos_esperados === 0);
    }
}