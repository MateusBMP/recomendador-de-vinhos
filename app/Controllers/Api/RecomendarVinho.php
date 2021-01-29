<?php

namespace App\Controllers\Api;

use App\Models\Fato;
use App\Controllers\Api\Controller;
use App\Vinhos\Factories\SEEP as SistemaEspecialistaEmVinhos;

class RecomendarVinho extends Controller
{
    public function data() 
    {
        $json_data = json_decode(file_get_contents('php://input'), true);

        // Cria a lista de fatos a partir da resposta do cliente no formulário
        $fatos = [];

        array_push($fatos, new Fato([ 'nome' => 'corpo preferido', 'valor' => $json_data['corpo-preferido'] ]));

        foreach ($json_data['cor-preferida'] as $cor_preferida)
            array_push($fatos, new Fato([ 'nome' => 'cor preferida', 'valor' => $cor_preferida ]));

        foreach ($json_data['molho'] as $molho)
            array_push($fatos, new Fato([ 'nome' => 'molho', 'valor' => $molho ]));

        array_push($fatos, new Fato([ 'nome' => 'prato principal', 'valor' => $json_data['prato-principal'] ]));

        foreach ($json_data['sabor'] as $sabor)
            array_push($fatos, new Fato([ 'nome' => 'sabor', 'valor' => $sabor ]));

        array_push($fatos, new Fato([ 'nome' => 'suavidade preferida', 'valor' => $json_data['suavidade-preferida'] ]));

        array_push($fatos, new Fato([ 'nome' => 'tem molho', 'valor' => $json_data['tem-molho'] ]));

        array_push($fatos, new Fato([ 'nome' => 'tem peru', 'valor' => $json_data['tem-peru'] ]));
        
        array_push($fatos, new Fato([ 'nome' => 'tem vitela', 'valor' => $json_data['tem-vitela'] ]));

        // Constrói o sistema especialista que encontrará o melhor vinho a partir da resposta do 
        // cliente ao formulário
        $se = new SistemaEspecialistaEmVinhos($fatos);

        // Encontra o melhor vinho
        $mv = $se->melhor_vinho();

        // Devolve o melhor vinho
        return [
            'melhor_vinho' => $mv->valor,
            'confiabilidade' => $mv->probabilidade
        ];
    }
}