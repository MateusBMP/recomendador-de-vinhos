<?php

namespace App\Contracts\Interfaces;

use App\Contracts\Interfaces\BaseDeRegras;

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
     * @param  \App\Contracts\Interfaces\BaseDeRegras $br Base de regras do sistema especialista
     * @return \App\Contracts\Interfaces\MemoriaDeTrabalho Memória de trabalho
     */
    public function construirMT(BaseDeRegras $br);
}