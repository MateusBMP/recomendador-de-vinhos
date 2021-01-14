<?php

namespace App\Controllers\Api;

use App\Controllers\Api\Controller;
use App\Vinhos\Perguntas as DataPerguntas;

class Perguntas extends Controller
{
    public function data() 
    {
        return [
            'cor_preferida' => DataPerguntas::$cor_preferida['valores'],
            'corpo_preferido' => DataPerguntas::$corpo_preferido['valores'],
            'molho' => DataPerguntas::$molho['valores'],
            'prato_principal' => DataPerguntas::$prato_principal['valores'],
            'sabor' => DataPerguntas::$sabor['valores'],
            'suavidade_preferida' => DataPerguntas::$suavidade_preferida['valores'],
            'tem_molho' => DataPerguntas::$tem_molho['valores'],
            'tem_peru' => DataPerguntas::$tem_peru['valores'],
            'tem_vitela' => DataPerguntas::$tem_vitela['valores']
        ];
    }
}