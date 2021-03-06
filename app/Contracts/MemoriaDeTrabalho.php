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
     * Busca um fato pelo seu nome e, opcionalmente, pelo valor na lista de fatos da memória de 
     * trabalho. Caso não seja encontrado, retorna um objeto vazio.
     * 
     * @param  string $nome_fato   Nome do fato buscado
     * @param  string ?$valor_fato Valor do fato buscado
     * @return array<\App\Models\Fato>
     */
    public function fato(string $nome_fato, string $valor_fato = "")
    {
        return ($valor_fato === "") ? 
            $this->buscar_fato_por_nome($nome_fato) : 
            $this->buscar_fato_por_nome_e_valor($nome_fato, $valor_fato);
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

    /**
     * Remove um fato da memória de trabalho. Se nenhum fato for removido, retorna nulo,
     * se não retornará o fato removido.
     * 
     * @param  string $nome_fato  Nome do fato a ser removido
     * @param  string $valor_fato Valor do fato a ser removido
     * @return \App\Models\Fato|null
     */
    public function remover_fato(string $nome_fato, string $valor_fato)
    {
        for ($i = 0; $i < count($this->fatos); $i++)
            if ($this->fatos[$i]->nome === $nome_fato && $this->fatos[$i]->valor === $valor_fato) 
                return array_splice($this->fatos_data, $i, 1);

        return null;
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

    /**
     * Busca um fato na lista de fatos pelo seu nome, voltando a lista de fatos encontrados. Se 
     * não encontrar nenhum fato, retorna uma lista vazia.
     * 
     * @param  string $nome_fato   Nome do fato buscado
     * @return array<\App\Models\Fato>
     */
    private function buscar_fato_por_nome(string $nome_fato)
    {
        $fatos_encontrados = [];

        foreach ($this->fatos as $fato) 
            if ($fato->nome === $nome_fato ) 
                array_push($fatos_encontrados, $fato);

        return $fatos_encontrados;
    }

    /**
     * Busca um fato na lista de fatos pelo seu nome e valor, voltando a lista de fatos  
     * encontrados. Se não encontrar nenhum fato, retorna uma lista vazia.
     * 
     * @param  string $nome_fato   Nome do fato buscado
     * @param  string ?$valor_fato Valor do fato buscado
     * @return array<\App\Models\Fato>
     */
    private function buscar_fato_por_nome_e_valor(string $nome_fato, string $valor_fato)
    {
        $fatos_encontrados = [];

        foreach ($this->fatos as $fato) 
            if ($fato->nome === $nome_fato && $fato->valor === $valor_fato) 
                array_push($fatos_encontrados, $fato);

        return $fatos_encontrados;
    }
}