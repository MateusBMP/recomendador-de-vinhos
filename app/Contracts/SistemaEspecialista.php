<?php

namespace App\Contracts;

use App\Contracts\BaseDeRegras;
use App\Contracts\MaquinaDeInferencia;

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
     * @param  BaseDeRegras $br Base de regras do sistema especialista
     * @param  MaquinaDeInferencia $mi Máquina de inferência construtora de novos fatos
     */
    public function __construct(BaseDeRegras $br, MaquinaDeInferencia $mi);

    /**
     * Faz uma pergunta ao sistema especialista, que retornará a resposta a pergunta a partir da 
     * memória de trabalho ou falso, caso não seja possível inferir a resposta.
     * 
     * @param  string $pergunta Pergunta feita ao sistema especialista
     * @return string|false
     */
    public function perguntar(string $pergunta);
}