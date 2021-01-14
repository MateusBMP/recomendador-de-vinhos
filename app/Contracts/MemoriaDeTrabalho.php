<?php

namespace App\Contracts;

use App\Models\Fato;
use App\Contracts\Interfaces\MemoriaDeTrabalho as InterfaceMemoriaDeTrabalho;

/**
 * Memória de trabalho
 * 
 * Implementação da memória de trabalho, que possui uma lista de fatos mais os novos fatos
 * gerados pela Máquina de inferência.
 */
class MemoriaDeTrabalho implements InterfaceMemoriaDeTrabalho
{
    /**
     * @var array Lista de Fatos da memória de trabalho
     */
    private $fatos_data = [];

    /**
     * Verifica se uma informação é um fato ou não na lista de fatos da memória de trabalho.
     * 
     * @param  \App\Models\Fato Fato buscado
     * @return bool
     */
    public function e_fato(Fato $fato_buscado)
    {
        foreach ($this->fatos as $fato)
            if ($fato->igual_a($fato_buscado))
                return true;

        return false;
    }

    /**
     * Busca um fato pelo seu nome na lista de fatos da memória de trabalho. Caso não seja 
     * encontrado, retorna um objeto nulo.
     * 
     * @param  string Fato buscado
     * @return \App\Models\Fato|null
     */
    public function fato(string $nome_fato)
    {
        foreach ($this->fatos as $fato) 
            if ($fato->nome === $nome_fato) 
                return $fato;

        return null;
    }

    /**
     * Adiciona um novo fato a memória de trabalho.
     * 
     * @param \App\Models\Fato $fato Novo fato a ser adicionado a memória de trabalho
     */
    public function adicionar_fato(Fato $fato)
    {
        array_push($this->fatos_data, $fato);
    }

    public function __get($p)
    {
        if ($p === "fatos")
            return $this->fatos();
        
        return null;
    }

    /**
     * Fatos da base de regras.
     * 
     * @return array Lista de fatos
     */
    public function fatos()
    {
        return $this->fatos_data;
    }
}