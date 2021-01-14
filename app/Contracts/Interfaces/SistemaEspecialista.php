<?php

namespace App\Contracts\Interfaces;

use App\Models\Fato;
use App\Contracts\Interfaces\BaseDeRegras;
use App\Contracts\Interfaces\MaquinaDeInferencia;

/**
 * Sistema especialista generalizado.
 * 
 * Interface de um sistema especialista generalizado. Sistemas especialistas respondem a perguntas
 * utilizando uma base de regras e uma máquina de inferência, que constrói novos fatos a partir da 
 * base de regras fornecidas, até ser capaz de responder a pergunta do usuário.
 */
interface SistemaEspecialista
{
    /**
     * Constrói o sistema especialista. Deve receber uma base de regras e uma máquina de 
     * inferência para construir a memória de trabalho.
     * 
     * @param  \App\Contracts\Interfaces\BaseDeRegras $br Base de regras do sistema especialista
     * @param  \App\Contracts\Interfaces\MaquinaDeInferencia $mi Máquina de inferência construtora 
     * de novos fatos
     */
    public function __construct(BaseDeRegras $br, MaquinaDeInferencia $mi);

    /**
     * Faz uma pergunta ao sistema especialista, que retornará verdadeiro ou falso a partir da 
     * memória de trabalho. Deve fornecer o objeto Fato buscado.
     * 
     * @param  \App\Models\Fato $fato Fato buscado no sistema especialista
     * @return bool
     */
    public function e_fato(Fato $pergunta);

    /**
     * Busca um valor para um dado buscado no sistema especialista. Caso não seja encontrado, 
     * retorna um objeto nulo.
     * 
     * @param  string $busca  Fato buscado no sistema especialista
     * @return \App\Models\Fato|null
     */
    public function buscar(string $busca);
}