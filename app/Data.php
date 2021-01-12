<?php

namespace App;

class Data
{
    static $vinhos = [
        "Tinto" => ["Carne", "Vermelha"],
        "Branco" => ["Carne", "Branca", "peixes", "frutos", "mar"],
        "Rosé" => ["Carne", "magra", "grelhada", "assada", "gordura"],
        "Doce" => ["Doce", "queijo"]
    ];

    static $tons = [
        "Vermelho-púrpura" => ["maior", "tanicidade", "acidez"],
        "Vermelho-rubi" => ["equilibrio", "tanacidade", "acidez", "maciez"],
        "Vermelho-granada" => ["envelhecidos", "macio"],
        "Vermelho-alaranjado" => ["envelhecidos", "taninos", "macio"],
        "Amarelo-esverdeado" => ["fresco", "brilhante", "acidez"],
        "Amarelo-palha" => ["equilibrio", "acidez", "maciez"],
        "Amarelo-dourado" => ["macio"],
        "Amarelo-âmbar" => ["licor", "licoroso", "maciez"],
    ];
}