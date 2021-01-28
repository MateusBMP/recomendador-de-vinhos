<?php

namespace App\Contracts;

use App\Models\Fato;
use App\Contracts\Interfaces\BaseDeRegras;
use App\Contracts\Interfaces\MaquinaDeInferencia;
use App\Contracts\Interfaces\SistemaEspecialista as ContractsSistemaEspecialista;

/**
 * Sistema especialista
 * 
 * O sistema especialista em vinhos é capaz de recomendar um vinho a partir de uma base de regras 
 * e conjunto de perguntas feitas ao cliente.
 */
class SistemaEspecialista implements ContractsSistemaEspecialista
{
    /**
     * @var MemoriaDeTrabalho  Memória de trabalho
     */
    private $mt;

    /**
     * Constrói o sistema especialista em vinhos. Deve receber a base de regras e uma máquina de
     * inferência para construir a memória de trabalho que será utilizada para recomendar um vinho.
     * 
     * @param  BaseDeRegras $br Base de regras do sistema especialista
     * @param  MaquinaDeInferencia $mi Máquina de inferência construtora de novos fatos
     */
    public function __construct(BaseDeRegras $br, MaquinaDeInferencia $mi)
    {
        $this->mt = $mi->construirMT($br);
    }

    /**
     * Faz uma pergunta ao sistema especialista, que retornará verdadeiro ou falso a partir da 
     * memória de trabalho. Deve fornecer o objeto Fato buscado.
     * 
     * @param  \App\Models\Fato $fato Fato buscado no sistema especialista
     * @return bool
     */
    public function e_fato(Fato $pergunta)
    {
        return $this->mt->e_fato($pergunta);
    }

    /**
     * Retorna o grau de probabilidade, em decimal, de um fato buscado. Caso o fato não esteja
     * presente na memória de trabalho, retorna o grau de probabilidade igual a 0.
     * 
     * @param  \App\Models\Fato $fato Fato buscado no sistema especialista
     * @return double Probabilidade do fato buscado
     */
    public function probabilidade(Fato $pergunta)
    {
        if (!$this->e_fato($pergunta))
            return doubleval(0);

        $fato_buscado = $this->buscar($pergunta->nome, $pergunta->valor)[0];

        return doubleval($fato_buscado->probabilidade);
    }

    /**
     * Busca um valor para um dado buscado no sistema especialista. Retorna a lista de fatos
     * encontrados que competem aos parâmetros buscados ou uma lista vazia de fatos, caso 
     * nenhum seja encontrado. Pode buscar um fato pelo nome e, opcionalmente, pelo valor.
     * 
     * @param  string $nome_fato   Nome do fato buscado no sistema especialista
     * @param  string ?$valor_fato Valor do fato buscado no sistema especialista
     * @return array<\App\Models\Fato>
     */
    public function buscar(string $nome_fato, string $valor_fato = "")
    {
        return $this->mt->fato($nome_fato, $valor_fato);
    }
}