<?php

namespace App\Maquinas;

use App\Contracts\Interfaces\BaseDeRegras;
use App\Contracts\Interfaces\MaquinaDeInferencia;
use App\Contracts\MemoriaDeTrabalho;
use App\Models\Fato;
use App\Models\Regra;

/**
 * Encadeamento Progressivo
 * 
 * Algoritmo de encadeamento progressivo, um tipo de máquina de inferência. Com ele, chegam-se 
 * a resultados partindo da base de fatos para a informação buscada.
 */
class EncadeamentoProgressivo implements MaquinaDeInferencia
{
    /**
     * @var array Lista de regras disparadas
     */
    private $regras_disparadas = [];

    /**
     * Constrói a memória de trabalho do sistema especialista a partir da base de regras.
     * 
     * @param  \App\Contracts\Interfaces\BaseDeRegras $br Base de regras do sistema especialista
     * @return \App\Contracts\Interfaces\MemoriaDeTrabalho Memória de trabalho
     */
    public function construirMT(BaseDeRegras $br)
    {
        // Cria a memória de trabalho vazia
        $mt = new MemoriaDeTrabalho;

        // Popula os fatos da memória de trabalho com os fatos da base de regras
        foreach ($br->fatos as $fato)
            $mt->adicionar_fato($fato);

        do {
            // Infere novos fatos
            $novos_fatos = $this->inferir_novos_fatos($mt, $br);
    
            // Se não houverem novos fatos, para a execução
            if (count($novos_fatos) === 0) 
                break;
    
            // Havendo novos fatos, insere-os na memória de trabalho.
            foreach ($novos_fatos as $novo_fato)
                $mt->adicionar_fato($novo_fato);
        } while (0);

        // Retorna a memória de trabalho
        return $mt;
    }

    /**
     * Infere novos fatos a partir da lista de fatos presentes na memória de trabalho e da base de 
     * regras original. Retorna uma lista com os novos fatos inferidos, enquanto registra as 
     * regras que forem disparadas para não serem disparadas novamente.
     * 
     * @param  \App\Contracts\Interfaces\MemoriaDeTrabalho $mt Memória de trabalho
     * @param  \App\Contracts\Interfaces\BaseDeRegras $br Base de regras
     * @return array Novos fatos inferidos
     */
    public function inferir_novos_fatos(MemoriaDeTrabalho $mt, BaseDeRegras $br)
    {
        // Cria a lista vazia de novos fatos
        $novos_fatos = [];

        // Atualiza os fatos da base de regras com os fatos da memória de trabalho
        $br->fatos = $mt->fatos;

        // Dispara as regras da base de regras, gerando novos fatos
        $disparos = $br->disparar();

        // Para cada disparo, se regra disparada não havia sido disparada anteriormente, registra 
        // o fato na lista de novos fatos e registra a regra disparada. Em seguida, regula o grau 
        // de probabilidade dos fatos
        foreach ($disparos as $disparo) {
            if (!$this->regra_disparada_anteriormente($disparo))
                $this->registrar_novo_fato($novos_fatos, $disparo);

            $this->regula_grau_de_probabilidade($mt, $disparo);
        }

        // Retorna a lista de novos fatos
        return $novos_fatos;
    }

    /**
     * Verifica se regra foi disparada anteriormente.
     * 
     * @param \App\Models\Regra $disparo Regra a ser verificada
     * @return bool
     */
    public function regra_disparada_anteriormente(Regra $disparo)
    {
        foreach ($this->regras_disparadas as $regra_disparada_anteriormente) 
            if ($regra_disparada_anteriormente->igual_a($disparo))
                return true;

        return false;
    }

    /**
     * Registra um novo fato na lista de novos fatos a partir de uma regra disparada.
     * 
     * @param  array $novos_fatos  Lista de novos fatos
     * @param  \App\Models\Regra $disparo  Regra disparada
     */
    public function registrar_novo_fato(array &$novos_fatos, Regra $disparo)
    {
        array_push($novos_fatos, $disparo->novo_fato);
        array_push($this->regras_disparadas, $disparo);
    }

    /**
     * Regula o grau de probabilidade de um fato na base de fatos da memória de trabalho.
     * 
     * @param  \App\Contracts\Interfaces\MemoriaDeTrabalho $mt Memória de trabalho
     * @param  \App\Models\Regra $disparo  Regra disparada
     */
    public function regula_grau_de_probabilidade(MemoriaDeTrabalho &$mt, Regra $disparo)
    {
        // Recupera o fato da memória de trabalho
        $fato_a_ser_regulado = $mt->fato($disparo->novo_fato->nome);

        // Recupera os fatos que disparam a regra
        $fatos_disparadores = [];
        foreach ($disparo->fatos as $regra)
            array_push($fatos_disparadores, $mt->fato($regra->nome));

        // Calcula o novo grau de probabilidade usando a média ponderada das probabilidades dos 
        // fatos disparadores em relação a probabilidade do fato disparado na regra.
        $soma_da_probabilidade_disparada = 0;
        foreach ($fatos_disparadores as $fato_disparador)
            $soma_da_probabilidade_disparada += $fato_disparador->probabilidade;

        $soma_da_probabilidade_esperada = 0;
        foreach ($disparo->fatos as $regra)
            $soma_da_probabilidade_esperada += $regra->probabilidade;

        $novo_grau_de_probabilidade = $disparo->novo_fato->probabilidade * $soma_da_probabilidade_disparada / $soma_da_probabilidade_esperada;

        // Trata o novo grau de probabilidade para que o mesmo seja do tipo 'double' e que seja
        // menor ou igual a 1
        if ($novo_grau_de_probabilidade > 1)
            $novo_grau_de_probabilidade = 1.0;

        $novo_grau_de_probabilidade = doubleval($novo_grau_de_probabilidade);

        // Remove o fato e adiciona o novo fato com o grau de probabilidade ajustado
        $mt->remover_fato($fato_a_ser_regulado->nome);

        $fato_a_ser_regulado->probabilidade = $novo_grau_de_probabilidade;
        $mt->adicionar_fato($fato_a_ser_regulado);
    }
}