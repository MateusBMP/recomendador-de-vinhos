<?php

require_once(__DIR__."/../vendor/autoload.php");

use App\Contracts\BaseDeRegras;
use App\Contracts\SistemaEspecialista;
use App\Maquinas\EncadeamentoProgressivo;
use App\Models\Fato;
use App\Models\Regra;

// Constrói os fatos
$fatos = [
    new Fato("A", "verdade", 1), // A(verdade)
    new Fato("B", "verdade", 2), // B(verdade)
];

// Constrói as regras
$regras = [
    new Regra([ // A(verdade) ^ B(verdade) -> C(verdade)
        $fatos[0],
        $fatos[1]
    ], new Fato("C", "verdade"), 1)
];

// Constrói a base de regras do sistema especialista
$br = new BaseDeRegras($fatos, $regras);

// Seleciona a máquina de inferência
$mi = new EncadeamentoProgressivo();

// Cria o sistema especialista
$se = new SistemaEspecialista($br, $mi);

// Busca saber se um fato é verdadeiro
$e_fato = ($se->e_fato(new Fato("C", 'verdade'))) ?  "verdadeiro" : "falso";
echo "C -> verdade é fato?: $e_fato\n";

// Busca um fato por seu nome
$busca = $se->buscar("C");
echo "Buscar C: {$busca->valor}\n";
