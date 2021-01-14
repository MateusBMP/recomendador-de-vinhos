<?php

namespace App\Contracts;

/**
 * Memória de trabalho
 * 
 * A memória de trabalho de um sistema especialista é um aglomerado de fatos, combinação dos fatos 
 * do sistema especialista com os fatos resultantes da máquina de inferência.
 */
interface MemoriaDeTrabalho
{
    /**
     * Fatos da memória de trabalho, combinação dos fatos do sistema especialista com os novos 
     * fatos da máquina de inferência.
     * 
     * @return array Fatos da memória de trabalho
     */
    public function fatos();

    /**
     * Adiciona um novo fato a memória de trabalho.
     * 
     * @param string $fato  Novo fato a ser adicionado a memória de trabalho
     */
    public function adicionarFato(string $fato);
}