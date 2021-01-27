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

    /**
     * @var int Valor da probabilidade da propriedade, em decimal
     */
    public $probabilidade;

    /**
     * Constrói objeto do tipo Fato. Deve receber um array com os parâmetros informados.
     * 
     * @param  integer ?$id
     * @param  string  $nome
     * @param  string  $valor
     * @param  string  ?probabilidade
     */
    public function __construct(array $params)
    {
        $this->setDefaultParams($params);
        $this->validateParams($params);

        $this->id = $params['id'];
        $this->nome = $params['nome'];
        $this->valor = $params['valor'];
        $this->probabilidade = $params['probabilidade'];
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

    private function setDefaultParams(array &$params)
    {
        if (!isset($params['id']))
            $params['id'] = 0;

        if (!isset($params['probabilidade']))
            $params['probabilidade'] = 1.;
    }

    private function validateParams(array $params)
    {
        if ($type = gettype($params['nome']) !== "string")
            throw new \Exception("Parâmetro 'nome' deve ser do tipo 'string'. ({$params['nome']}: {$type})");

        if ($type = gettype($params['id']) !== 'integer')
            throw new \Exception("Parâmetro 'id' deve ser do tipo 'integer'. ({$params['id']}: {$type})");

        if ($type = gettype($params['valor']) !== "string")
            throw new \Exception("Parâmetro 'valor' deve ser do tipo 'string'. ({$params['valor']}: {$type})");

        if ($type = gettype($params['probabilidade']) !== 'double')
            throw new \Exception("Parâmetro 'probabilidade' deve ser do tipo 'double'. ({$params['probabilidade']}: {$type})");

        if ($params['probabilidade'] > 1 || $params['probabilidade'] <= 0)
        throw new \Exception("Parâmetro 'probabilidade' deve ser maior que 0 e menor ou igual a 1. (0 < {$params['probabilidade']} <= 1)");
    }
}