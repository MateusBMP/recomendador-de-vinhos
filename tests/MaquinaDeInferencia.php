<?php

require_once(__DIR__."/../vendor/autoload.php");

use App\Contracts\BaseDeRegras;
use App\Contracts\SistemaEspecialista;
use App\Maquinas\EncadeamentoProgressivo;
use App\Models\Fato;
use App\Models\Regra;

// Constrói os fatos
$fatos = [
    new Fato([ 'nome' => 'A', 'valor' => "Verdade", 'probabilidade' => 0.8 ]),
    new Fato([ 'nome' => 'B', 'valor' => "Verdade", 'probabilidade' => 0.8 ])
];

// Constrói as regras
$regras = [
    new Regra( // A(verdade) ^ B(verdade) -> C(verdade) cnf 80%
        [
            new Fato([ 'nome' => 'A', 'valor' => "Verdade" ]),
            new Fato([ 'nome' => 'B', 'valor' => "Verdade" ])
        ],
        new Fato([ 'nome' => 'C', 'valor' => "Verdade", 'probabilidade' => 0.8 ])
    )
];

// Constrói a base de regras do sistema especialista
$br = new BaseDeRegras($fatos, $regras);

// Seleciona a máquina de inferência
$mi = new EncadeamentoProgressivo();

// Cria o sistema especialista
$se = new SistemaEspecialista($br, $mi);

// Busca saber se um fato é verdadeiro
$e_fato = ($se->e_fato(new Fato([ 'nome' => 'C', 'valor' => "Verdade" ]))) ?  "verdadeiro" : "falso";
echo "`C -> verdade` é fato?: $e_fato\n";

// Busca um fato por seu nome
$busca = $se->buscar("C")[0];
echo "Buscar C: {$busca->valor} (cnf {$busca->probabilidade})\n";
