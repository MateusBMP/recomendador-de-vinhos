<?php

require_once(__DIR__."/../../../vendor/autoload.php");

use App\Controllers;

$controller = new Controllers\Api\Perguntas;
$controller->render();