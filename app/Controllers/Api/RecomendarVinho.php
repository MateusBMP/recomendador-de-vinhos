<?php

namespace App\Controllers\Api;

use App\Models\Fato;
use App\Controllers\Api\Controller;
use App\Vinhos\Factories\SEEP as SistemaEspecialistaEmVinhos;

class RecomendarVinho extends Controller
{
    public function data() 
    {
        print_r(file_get_contents('php://input'));

        // Cria a lista de fatos a partir da resposta do cliente no formulário
        $fatos = [
            new Fato("", ""),
        ];

        // Constrói o sistema especialista que encontrará o melhor vinho a partir da resposta do 
        // cliente ao formulário
        $se = new SistemaEspecialistaEmVinhos($fatos);

        // Devolve o melhor vinho
        return [
            'melhor_vinho' => $se->melhor_vinho()
        ];
    }
}