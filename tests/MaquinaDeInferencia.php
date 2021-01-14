<?php

require_once(__DIR__."/../vendor/autoload.php");

use App\Contracts\BaseDeRegras;
use App\Contracts\SistemaEspecialista;
use App\Maquinas\EncadeamentoProgressivo;
use App\Models\Fato;
use App\Models\Regra;

$fatos = [
    new Fato("A", "verdade", 1),
    new Fato("B", "verdade", 2),
];
$regras = [
    new Regra([
        $fatos[0],
        $fatos[1]
    ], new Fato("C", "verdade"), 1)
];

$br = new BaseDeRegras($fatos, $regras);
$mi = new EncadeamentoProgressivo();

$se = new SistemaEspecialista($br, $mi);

$e_fato = ($se->e_fato(new Fato("C", 'verdade'))) ?  "verdadeiro" : "falso";
$busca = $se->buscar("C");

echo "C -> verdade é fato?: $e_fato\n";
echo "Buscar C: {$busca->valor}\n";