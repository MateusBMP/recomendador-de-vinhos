<?php

namespace App\Contracts\Interfaces;

use App\Models\Fato;

/**
 * Memória de trabalho
 * 
 * A memória de trabalho de um sistema especialista é um aglomerado de fatos, combinação dos fatos 
 * do sistema especialista com os fatos resultantes da máquina de inferência.
 */
interface MemoriaDeTrabalho
{
    /**
     * Verifica se uma informação é um fato ou não na lista de fatos da memória de trabalho.
     * 
     * @param  \App\Models\Fato Fato buscado
     * @return bool
     */
    public function e_fato(Fato $fato_buscado);

    /**
     * Busca um fato pelo seu nome na lista de fatos da memória de trabalho. Caso não seja 
     * encontrado, retorna um objeto nulo.
     * 
     * @param  string Fato buscado
     * @return \App\Models\Fato|null
     */
    public function fato(string $nome_fato);

    /**
     * Adiciona um novo fato a memória de trabalho.
     * 
     * @param \App\Models\Fato $fato Novo fato a ser adicionado a memória de trabalho
     */
    public function adicionar_fato(Fato $fato);
}