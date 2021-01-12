<?php

namespace App\Controllers\Api;

class Controller
{
    public function data()
    {
        // code...
    }

    public function render()
    {
        header('Content-Type:application/json;charset=utf-8');
        echo json_encode($this->data());
    }
}