<?php

namespace App\Controllers\Api;

use App\Categorizacao;
use App\Controllers\Api\Controller;
use App\Data;

class Categorizar extends Controller
{
    public function data() 
    {
        $categorizacao = new Categorizacao(array_values(Data::$vinhos));

        $data = $categorizacao->textos->similaridade->get();

        return $data;
    }
}