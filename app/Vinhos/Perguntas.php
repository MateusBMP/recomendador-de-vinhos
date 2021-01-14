<?php

namespace App\Vinhos;

/**
 * Perguntas ao cliente
 * 
 * Objeto com lista de perguntas que podem ser feitas ao cliente para inferir qual o vinho mais 
 * recomendado a ele. Todo objeto possui um conjunto de valores e um tipo, onde quando for 
 * "univalorada", deve possuir apenas um valor como resposta, enquanto "multivalorada" permite  
 * vários valores como resposta.
 */
class Perguntas
{
    public static $aspecto = [
        "valores" => ["condimentado"],
        "tipo" => ["univalorada"],
    ];
    public static $cor_preferida = [
        "valores" => ["branco", "tinto"],
        "tipo" => ["multivalorada"],
    ];
    public static $cor_recomendada = [
        "valores" => ["branco", "tinto"],
        "tipo" => ["univalorada"],
    ];
    public static $corpo_preferido = [
        "valores" => ["leve", "encorpado", "médio"],
        "tipo" => ["univalorada"],
    ];
    public static $corpo_recomendado = [
        "valores" => ["leve", "encorpado", "médio"],
        "tipo" => ["univalorada"],
    ];
    public static $melhor_cor = [
        "valores" => ["branco", "tinto"],
        "tipo" => ["univalorada"],
    ];
    public static $melhor_corpo = [
        "valores" => ["médio", "encorpado", "leve"],
        "tipo" => ["univalorada"],
    ];
    public static $melhor_suavidade = [
        "valores" => ["médio", "suave", "seco"],
        "tipo" => ["univalorada"],
    ];
    public static $molho = [
        "valores" => ["agridoce", "creme", "tártaro", "apimentado", "tomate"],
        "tipo" => ["multivalorada"],
    ];
    public static $prato_principal = [
        "valores" => ["peixe", "carne", "aves"],
        "tipo" => ["univalorada"],
    ];
    public static $sabor = [
        "valores" => ["forte", "delicado", "médio"],
        "tipo" => ["multivalorada"],
    ];
    public static $suavidade_preferida = [
        "valores" => ["médio", "seco", "suave"],
        "tipo" => ["multivalorada"],
    ];
    public static $suavidade_recomendada = [
        "valores" => ["seco", "suave", "médio"],
        "tipo" => ["univalorada"],
    ];
    public static $tem_molho = [
        "valores" => ["tem", "não tem"],
        "tipo" => ["univalorada"],
    ];
    public static $tem_peru = [
        "valores" => ["tem", "não tem"],
        "tipo" => ["univalorada"],
    ];
    public static $tem_vitela = [
        "valores" => ["tem", "não tem"],
        "tipo" => ["univalorada"],
    ];
    public static $vinho = [
        "valores" => [
            "Gamay",
            "Sauvignon Blanc",
            "Riesling",
            "Chenin Blanc",
            "Cabernet Sauvignon",
            "Pinot Noir",
            "Soave",
            "Chablis",
            "Chardonnay",
            "Geverztraminer",
            "Valpolicella",
            "Zinfandel",
            "Burgundy"],
        "tipo" => ["multivalorada"],
    ];
}