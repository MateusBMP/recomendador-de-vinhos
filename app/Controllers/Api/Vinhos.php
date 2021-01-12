<?php

namespace App\Controllers\Api;

use App\Controllers\Api\Controller;
use App\Data;

class Vinhos extends Controller
{
    public function data() 
    {
        return array_keys(Data::$vinhos);
    }
}