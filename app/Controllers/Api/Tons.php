<?php

namespace App\Controllers\Api;

use App\Controllers\Api\Controller;
use App\Data;

class Tons extends Controller
{
    public function data() 
    {
        return array_keys(Data::$tons);
    }
}