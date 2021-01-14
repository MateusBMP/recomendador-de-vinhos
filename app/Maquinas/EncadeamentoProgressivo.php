<?php

namespace App\Maquinas;

use App\Contracts\Interfaces\BaseDeRegras;
use App\Contracts\Interfaces\MaquinaDeInferencia;
use App\Contracts\MemoriaDeTrabalho;

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
    private function inferir_novos_fatos(MemoriaDeTrabalho $mt, BaseDeRegras $br)
    {
        // Cria a lista vazia de novos fatos
        $novos_fatos = [];

        // Atualiza os fatos da base de regras com os fatos da memória de trabalho
        $br->fatos = $mt->fatos;

        // Dispara as regras da base de regras, gerando novos fatos
        $disparos = $br->disparar();

        // Para cada disparo, se regra disparada não havia sido disparada anteriormente, registra 
        // o fato na lista de novos fatos e registra a regra disparada
        foreach ($disparos as $disparo) {
            $ja_disparado = false;

            foreach ($this->regras_disparadas as $regra_disparada_anteriormente) 
                if ($regra_disparada_anteriormente->igual_a($disparo)) {
                    $ja_disparado = true;
                    break;
                }

            if (!$ja_disparado)
                array_push($novos_fatos, $disparo->novo_fato);
        }

        // Retorna a lista de novos fatos
        return $novos_fatos;
    }
}