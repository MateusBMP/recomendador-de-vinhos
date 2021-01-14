<?php

namespace App\Vinhos\Factories;

use App\Contracts\BaseDeRegras;
use App\Maquinas\EncadeamentoProgressivo;
use App\Vinhos\Regras;
use App\Vinhos\SistemaEspecialista as SistemaEspecialistaEmVinhos;

/**
 * Sistema especialista com Encadeamento Progressivo
 * 
 * Construtor do sistema especialista em vinhos utilizando como Máquina de inferência o algoritmo 
 * de encadeamento progressivo
 */
class SEEP
{
    /**
     * @var \App\Vinhos\SistemaEspecialista Sistema especialista em vinhos
     */
    private $se;

    /**
     * Constrói o sistema especialista a partir dos fatos fornecidos pelo cliente, provenientes do 
     * questionário passado a ele.
     * 
     * @param  array $fatos  Lista de fatos
     */
    public function __construct(array $fatos)
    {
        $regras_de_vinhos = new Regras();

        $br = new BaseDeRegras($fatos, $regras_de_vinhos->get());
        $mi = new EncadeamentoProgressivo();

        $this->se = new SistemaEspecialistaEmVinhos($br, $mi);
    }

    /**
     * Busca o melhor vinho no sistema especialista.
     * 
     * @return string
     */
    public function melhor_vinho()
    {
        $melhor_vinho = $this->se->melhor_vinho();

        if ($melhor_vinho === null)
            return "";

        return $melhor_vinho->valor;
    }
}