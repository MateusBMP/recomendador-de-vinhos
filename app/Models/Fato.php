<?php

namespace App\Models;

/**
 * Fato
 * 
 * Fato de uma lista de fatos, utilizado no sistema especialista.
 */
class Fato
{
    /**
     * @var int Índice do fato
     */
    public $id;

    /**
     * @var string Nome da propriedade
     */
    public $nome;

    /**
     * @var string Valor da propriedade
     */
    public $valor;

    public function __construct(string $nome, string $valor, int $id = 0)
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->valor = $valor;
    }

    /**
     * Verifica se um fato é igual a outro fato, sem validar o índice deles.
     * 
     * @param  \App\Models\Fato $fato Fato a ser comparado
     * @return bool
     */
    public function igual_a(Fato $fato)
    {
        return ($this->nome === $fato->nome && $this->valor === $fato->valor);
    }
}