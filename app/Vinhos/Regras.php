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
            new Regra([
                new Fato("tem molho", "sim"),
                new Fato("molho", "apimentado")
            ], new Fato("melhor corpo", "encorpado"), 1),
            new Regra([
                new Fato("sabor", "delicado"),
            ], new Fato("melhor corpo", "leve"), 2),
            new Regra([
                new Fato("sabor", "medio"),
            ], new Fato("melhor corpo", "medio"), 3),
            new Regra([
                new Fato("sabor", "forte"),
            ], new Fato("melhor corpo", "encorpado"), 4),
            new Regra([
                new Fato("tem molho", "sim"),
                new Fato("molho", "creme")
            ], new Fato("melhor corpo", "encorpado"), 5),
            new Regra([
                new Fato("prato principal", "carne"),
                new Fato("tem vitela", "sim")
            ], new Fato("melhor cor", "tinto"), 6),
            new Regra([
                new Fato("prato principal", "aves"),
                new Fato("tem peru", "sim")
            ], new Fato("melhor cor", "branco"), 7),
            new Regra([
                new Fato("prato principal", "peixe"),
            ], new Fato("melhor cor", "branco"), 8),
            // new Regra([                                # Usa um esquema de "<>", então tirei pq 
            //     new Fato("prato principal", "peixe"),  # Não tenho como tratar isso agora
            //     new Fato("tem molho", "sim"),
            //     new Fato("molho", "tomate")
            // ], new Fato("melhor cor", "tinto"), 9),
            // new Regra([                                # Parece duplicado da regra 7, mas tem 
            //     new Fato("prato principal", "aves"),   # Umas coisas diferentes também (?)
            //     new Fato("tem peru", "sim")
            // ], new Fato("melhor cor", "tinto"), 10),
        ];
    }
}