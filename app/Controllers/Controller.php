<?php

namespace App\Controllers;

abstract class Controller
{
    public $view = "";

    public function view()
    {
        return __DIR__ . "/../Views/" . $this->view . ".html";
    }

    public function render()
    {
        echo file_get_contents($this->view());
    }
}