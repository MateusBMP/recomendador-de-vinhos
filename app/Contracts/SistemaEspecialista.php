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
     * @return \App\Models\Fato|false
     */
    public function e_fato(Fato $pergunta)
    {
        return $this->mt->e_fato($pergunta);
    }

    /**
     * Busca um valor para um dado buscado no sistema especialista. Caso não seja encontrado, 
     * retorna um objeto nulo.
     * 
     * @param  string $fato  Fato buscado no sistema especialista
     * @return \App\Models\Fato|null
     */
    public function buscar(string $fato)
    {
        return $this->mt->fato($fato);
    }
}