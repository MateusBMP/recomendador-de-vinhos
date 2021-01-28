<?php

namespace App\Vinhos;

use App\Models\Fato;
use App\Models\Regra;

/**
 * Regras de vinhos
 * 
 * Regras da base de regras do sistema especialista em vinhos.
 */
class Regras
{
    public function get()
    {
        return $this->base_de_regras();
    }

    /**
     * A base de regras é escrita a partir da base de conhecimento do Expert Sinta. Entretanto 
     * alguns ajustes se fizeram necessários, logo que o algoritmo não é capaz de processar 
     * algumas inferências, como "<>". Para as relações que possuíam um "OU", também se fez 
     * necessário converter as regras usando apenas "E", pois o objeto Regra ainda não é capaz 
     * de processar esse comparador. Também não foi levado em consideração os pesos de nível de 
     * confiabilidade da base de regras original, logo que este algoritmo não usufrui de uma 
     * máquina de resolução de conflitos com abordagem probabilística, tal qual redes bayesianas.
     * Agora para mais detalhes acerta da construção de cada uma das regras, veja o corpo desse 
     * método.
     */
    private function base_de_regras()
    {
        return [
            // new Regra 1
            new Fato([
                "tem molho"=> "sim",
                "molho"=> "apimentado"
            ]), new Fato("melhor corpo"=> "encorpado"),
            // new Regra 2
            new Fato([
                "sabor"=> "delicado",
            ], new Fato("melhor corpo"=> "leve"), 0.80),
            // new Regra 3
            new Fato([
                "sabor"=> "medio",
            ], new Fato("melhor corpo"=> "leve"), 0.30
               new Fato("melhor corpo"=> "medio"), 0.60
               new Fato("melhor corpo"=> "encorpado"), 0.30),
            // new Regra 4
            new Fato([
                "sabor"=> "forte",
            ], new Fato("melhor corpo"=> "medio"), 0.40
               new Fato("melhor corpo"=> "encorpado"), 0.80),
            // new Regra 5
            new Fato([
                "tem molho"=> "sim",
                "molho"=> "creme"
            ], new Fato("melhor corpo"=> "medio"), 0.40
               new Fato("melhor corpo"=> "encorpado"), 0.60),
            // new Regra 6
            new Fato([
                "prato principal"=> "carne",
                "tem vitela"=> "sim"
            ], new Fato("melhor cor"=> "tinto"), 0.90),
            // new Regra 7
            new Fato([
                "prato principal"=> "aves",
                "tem peru"=> "sim"
            ], new Fato("melhor cor"=> "branco"), 0.90
               new Fato("melhor cor"=> "branco"), 0.30),
            // new Regra 8
            new Fato([
                "prato principal"=> "peixe",
            ]), new Fato("melhor cor"=> "branco"),
            // new Regra 9
            // new Fato([                        # Usa um esquema de "<>", então tirei pq 
            //     "prato principal"=> "peixe",  # Não tenho como tratar isso agora
            //     "tem molho"=> "sim",
            //     "molho"=> "tomate"
            // ]), new Fato("melhor cor"=> "tinto"),
            // new Regra 10
            // new Fato([                         # Parece duplicado da regra 7, mas tem 
            //     "prato principal"=> "aves"),   # Umas coisas diferentes também (?)
            //     "tem peru"=> "sim")
            // ], new Fato("melhor cor"=> "tinto"), 0.80
            //    new Fato("melhor cor"=> "tinto"), 0.50),
            // new Regra 11
            new Fato([
                "prato principal"=> "desconhecido",
                "tem molho"=> "sim",
                "molho"=> "creme"
            ], new Fato("melhor cor"=> "branco"), 0.40),
            // new Regra 12
            new Fato([
                "tem molho"=> "sim",
                "molho"=> "agridoce"
            ], new Fato("melhor suavidade"=> "suave"), 0.90
               new Fato("melhor suavidade"=> "medio"), 0.40),
            // new Regra 13
            new Fato([
                "tem molho"=> "sim",
                "molho"=> "apimentado"
            ]), new Fato("aspecto"=> "condimentado"),
            // new Regra 14
            new Fato([
                "melhor corpo"=> "leve",
            ]), new Fato("corpo recomendado"=> "leve"),
            // new Regra 15
            new Fato([
                "melhor corpo"=> "medio",
            ]), new Fato("corpo recomendado"=> "medio"),
            // new Regra 16
            new Fato([
                "melhor corpo"=> "encorpado"
            ]), new Fato("corpo recomendado"=> "encorpado"),
            // new Regra 17
            new Fato([
                "corpo preferido"=> "leve",
                "melhor corpo"=> "leve"
            ], new Fato("corpo recomendado"=> "leve"), 0.20),
            // new Regra 18
            new Fato([
                "corpo preferido"=> "medio",
                "melhor corpo"=> "medio"
            ], new Fato("corpo recomendado"=> "medio"), 0.20),
            // new Regra 19
            new Fato([
                "corpo preferido"=> "encorpado",
                "melhor corpo"=> "encorpado"
            ], new Fato("corpo recomendado"=> "encorpado"), 0.20),
            // new Regra 20
            new Fato([
                "corpo preferido"=> "leve",
                "melhor corpo"=> "encorpado"
            ]), new Fato("corpo recomendado"=> "medio"),
            // new Regra 21
            new Fato([
                "corpo preferido"=> "encorpado",
                "melhor corpo"=> "leve"
            ]), new Fato("corpo recomendado"=> "medio"),
            // new Regra 22
            new Fato([
                "corpo preferido"=> "leve",
                "melhor corpo"=> "desconhecido"
            ]), new Fato("corpo recomendado"=> "leve"),
            // new Regra 23
            new Fato([
                "corpo preferido"=> "medio",
                "melhor corpo"=> "desconhecido"
            ]), new Fato("corpo recomendado"=> "medio"),
            // new Regra 24
            new Fato([
                "corpo preferido"=> "encorpado",
                "melhor corpo"=> "desconhecido"
            ]), new Fato("corpo recomendado"=> "encorpado"),
            // new Regra 25
            new Fato([
                "melhor corpo"=> "desconhecido"
            ]), new Fato("corpo recomendado"=> "medio",
            // new Regra 26
            new Fato([
                "melhor cor"=> "tinto"
            ]), new Fato("corpo recomendado"=> "tinto",
            // new Regra 27
            new Fato([
                "melhor corpo"=> "branco"
            ]), new Fato("corpo recomendado"=> "branco"),
            // new Regra 28
            new Fato([
                "cor preferida"=> "tinto",
                "melhor cor"=> "tinto"
            ], new Fato("corpo recomendado"=> "tinto"), 0.20),
            // new Regra 29
            new Fato([
                "cor preferida"=> "branco",
                "melhor cor"=> "branco"
            ], new Fato("corpo recomendado"=> "branco"), 0.20),
            // new Regra 30
            new Fato([
                "cor preferida"=> "tinto",
                "melhor cor"=> "desconhecido"
            ]), new Fato("corpo recomendado"=> "tinto"),
            // new Regra 31
            new Fato([
                "cor preferida"=> "branco",
                "melhor cor"=> "desconhecido"
            ]), new Fato("corpo recomendado"=> "branco"),
            // new Regra 32
            new Fato([
                "cor preferida"=> "desconhecido",
            ], new Fato("corpo recomendado"=> "branco"), 0.50
               new Fato("corpo recomendado"=> "tinto"), 0.50),
            // new Regra 33
            new Fato([
                "melhor suavidade"=> "seco",
            ]), new Fato("suavidade recomendado"=> "seco"), 0.50,
            // new Regra 34
            new Fato([
                "melhor suavidade"=> "medio",
            ]), new Fato("suavidade recomendado"=> "medio"),
            // new Regra 35
            new Fato([
                "melhor suavidade"=> "suave",
            ]), new Fato("suavidade recomendado"=> "suave"),
            // new Regra 36
            new Fato([
                "melhor suavidade"=> "desconhecido",
                "suavidade preferida"=> "desconhecido"
            ]), new Fato("suavidade recomendado"=> "medio"),
            // new Regra 37
            new Fato([
                "melhor suavidade"=> "seco",
                "suavidade preferida"=> "seco"
            ], new Fato("suavidade recomendado"=> "seco"), 0.20),
            // new Regra 38
            new Fato([
                "melhor suavidade"=> "medio",
                "suavidade preferida"=> "medio"
            ], new Fato("suavidade recomendado"=> "medio"), 0.20,
            // new Regra 39
            new Fato([
                "melhor suavidade"=> "suave",
                "suavidade preferida"=> "suave"
            ], new Fato("suavidade recomendado"=> "suave"), 0.20,
            // new Regra 40
            new Fato([
                "suavidade preferida"=> "seco",
                "melhor suavidade"=> "desconhecido"
            ]), new Fato("suavidade recomendado"=> "seco"),
            // new Regra 41
            new Fato([
                "suavidade preferida"=> "medio",
                "melhor suavidade"=> "desconhecido"
            ]), new Fato("suavidade recomendado"=> "medio"),
            // new Regra 42
            new Fato([
                "suavidade preferida"=> "suave",
                "melhor suavidade"=> "desconhecido"
            ]), new Fato("suavidade recomendado"=> "suave"),
            // new Regra 43
            new Fato([
                "suavidade preferida"=> "seco",
                "melhor suavidade"=> "suave"
            ]), new Fato("suavidade recomendado"=> "medio"),
            // new Regra 44
            new Fato([
                "suavidade preferida"=> "suave",
                "melhor suavidade"=> "seco"
            ]), new Fato("suavidade recomendado"=> "medio"),
            // new Regra 45
            new Fato([
                "cor recomendada"=> "tinto",
                "corpo recomnedado"=> "medio",
                "suavidade recomendada"=> "medio",
                "suavidade recomendada"=> "suave"
            ]), new Fato("vinho"=> "Gamay"),
            // new Regra 46
            new Fato([
                "cor recomendada"=> "branco",
                "corpo recomnedado"=> "leve",
                "suavidade recomendada"=> "suave"
            ]), new Fato("vinho"=> "Chablis"),
            // new Regra 47
            new Fato([
                "cor recomendada"=> "branco",
                "corpo recomnedado"=> "medio",
                "suavidade recomendada"=> "seco"
            ]), new Fato("vinho"=> "Sauvignon Blanc"),
            // new Regra 48
            new Fato([
                "cor recomendada"=> "branco",
                "corpo recomendado"=> "medio",
                "corpo recomendado"=> "encorpado",
                "suavidade recomendada"=> "seco",
                "suavidade recomendada"=> "medio"
            ]), new Fato("vinho"=> "Chardonnay"),
            // new Regra 49
            new Fato([
                "cor recomendada"=> "branco",
                "corpo recomendado"=> "leve",
                "suavidade recomendada"=> "seco",
                "suavidade recomendada"=> "medio"
            ]), new Fato("vinho"=> "Soave"),
            // new Regra 50
            new Fato([
                "cor recomendada"=> "branco",
                "corpo recomendado"=> "leve",
                "corpo recomendado"=> "medio",
                "suavidade recomendada"=> "medio",
                "suavidade recomendada"=> "suave"
            ]), new Fato("vinho"=> "Riesling"),
            // new Regra 51
            new Fato([
                "cor recomendada"=> "branco",
                "corpo recomendado"=> "encropado",
                "aspecto"=> "condimentado"
            ]), new Fato("vinho"=> "Geverztraminer"),
            // new Regra 52
            new Fato([
                "cor recomendada"=> "branco",
                "corpo recomendado"=> "leve",
                "suavidade recomendada"=> "medio",
                "suavidade recomendada"=> "suave"
            ]), new Fato("vinho"=> "Chenin Blanc"),
            // new Regra 53
            new Fato([
                "cor recomendada"=> "branco",
                "corpo recomendado"=> "medio"
            ]), new Fato("vinho"=> "Valpolicella"),
            // new Regra 54
            new Fato([
                "cor recomendada"=> "tinto",
                "suavidade recomendada"=> "seco",
                "suavidade recomendada"=> "medio"
            ]), new Fato("vinho"=> "Cabernet Sauvignon"),
                new Fato("vinho"=> "Zinfandel"),
            // new Regra 55
            new Fato([
                "cor recomendada"=> "tinto",
                "corpo recomendada"=> "medio",
                "suavidade recomendada"=> "medio"
            ]), new Fato("vinho"=> "Pinot Noir"),
            // new Regra 56
            new Fato([
                "cor recomendada"=> "tinto",
                "corpo recomendada"=> "encorpado"
            ]), new Fato("vinho"=> "Burgundy"),
        ];
    }
}