<?php

namespace App\Contracts;

use App\Contracts\MemoriaDeTrabalho;

/**
 * Máquina de inferência
 * 
 * Máquina de inferência do sistema especialista. Utiliza uma base de regras para construir uma
 * memória de trabalho com os fatos atuais mais os novos fatos resultantes das inferências dessa
 * base de fatos com as regras se-então.
 */
interface MaquinaDeInferencia
{
    /**
     * Constrói a memória de trabalho do sistema especialista a partir da base de regras.
     * 
     * @param  BaseDeRegras $br Base de regras do sistema especialista.
     * @return MemoriaDeTrabalho Memória de trabalho
     */
    public function construirMT(BaseDeRegras $br);
}