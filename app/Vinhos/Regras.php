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
        // tem_molho(sim) ^ molho(apimentado) -> melhor_corpo(encorpado) cnf 100%
        $regra_1 = new Regra(
            [
                new Fato([ 'nome' => "tem molho", 'valor' => "sim" ]),
                new Fato([ 'nome' => "molho", 'valor' => "apimentado" ])
            ], 
            new Fato([ 'nome' => "melhor corpo", 'valor' => "encorpado" ])
        );

        // sabor(delicado) -> melhor_corpo(leve) cnf 80%
        $regra_2 = new Regra(
            [
                new Fato([ 'nome' => 'sabor', 'valor' => 'delicado' ])
            ],
            new Fato([ 'nome' => 'melhor corpo', 'valor' => 'leve', 'probabilidade' => 0.8 ])
        );

        // sabor(medio) -> melhor_corpo(leve) cnf 30%
        $regra_3_1 = new Regra(
            [
                new Fato([ 'nome' => 'sabor', 'valor' => 'medio' ])
            ],
            new Fato([ 'nome' => 'melhor corpo', 'valor' => 'leve', 'probabilidade' => 0.3 ])
        );

        // sabor(medio) -> melhor_corpo(medio) cnf 60%
        $regra_3_2 = new Regra(
            [
                new Fato([ 'nome' => 'sabor', 'valor' => 'medio' ])
            ],
            new Fato([ 'nome' => 'melhor corpo', 'valor' => 'medio', 'probabilidade' => 0.6 ])
        );

        // sabor(medio) -> melhor_corpo(encorpado) cnf 30%
        $regra_3_3 = new Regra(
            [
                new Fato([ 'nome' => 'sabor', 'valor' => 'medio' ])
            ],
            new Fato([ 'nome' => 'melhor corpo', 'valor' => 'encorpado', 'probabilidade' => 0.3 ])
        );

        // sabor(forte) -> melhor_corpo(medio) cnf 40%
        $regra_4_1 = new Regra(
            [
                new Fato([ 'nome' => 'sabor', 'valor' => 'forte' ])
            ],
            new Fato([ 'nome' => 'melhor corpo', 'valor' => 'medio', 'probabilidade' => 0.4 ])
        );

        // sabor(forte) -> melhor_corpo(encorpado) cnf 80%
        $regra_4_2 = new Regra(
            [
                new Fato([ 'nome' => 'sabor', 'valor' => 'forte' ])
            ],
            new Fato([ 'nome' => 'melhor corpo', 'valor' => 'encorpado', 'probabilidade' => 0.8 ])
        );

        // tem_molho(sim) ^ molho(creme) -> melhor_corpo(medio) cnf 40%
        $regra_5_1 = new Regra(
            [
                new Fato([ 'nome' => 'tem molho', 'valor' => 'sim' ]),
                new Fato([ 'nome' => 'molho', 'valor' => 'creme' ])
            ],
            new Fato([ 'nome' => 'melhor corpo', 'valor' => 'medio', 'probabilidade' => 0.4 ])
        );

        // tem_molho(sim) ^ molho(creme) -> melhor_corpo(encorpado) cnf 60%
        $regra_5_2 = new Regra(
            [
                new Fato([ 'nome' => 'tem molho', 'valor' => 'sim' ]),
                new Fato([ 'nome' => 'molho', 'valor' => 'creme' ])
            ],
            new Fato([ 'nome' => 'melhor corpo', 'valor' => 'encorpado', 'probabilidade' => 0.6 ])
        );

        // prato_principal(carne) ^ tem_vitela(sim) -> melhor_cor(tinto) cnf 90%
        $regra_6 = new Regra(
            [
                new Fato([ 'nome' => 'prato principal', 'valor' => 'carne' ]),
                new Fato([ 'nome' => 'tem vitela', 'valor' => 'sim' ])
            ],
            new Fato([ 'nome' => 'melhor cor', 'valor' => 'tinto', 'probabilidade' => 0.9 ])
        );

        // prato_principal(aves) ^ tem_peru(sim) -> melhor_cor(branco) cnf 90%
        $regra_7_1 = new Regra(
            [
                new Fato([ 'nome' => 'prato principal', 'valor' => 'aves' ]),
                new Fato([ 'nome' => 'tem peru', 'valor' => 'sim' ])
            ],
            new Fato([ 'nome' => 'melhor cor', 'valor' => 'branco', 'probabilidade' => 0.9 ])
        );

        // prato_principal(aves) ^ tem_peru(sim) -> melhor_cor(tinto) cnf 30%
        $regra_7_2 = new Regra(
            [
                new Fato([ 'nome' => 'prato principal', 'valor' => 'aves' ]),
                new Fato([ 'nome' => 'tem peru', 'valor' => 'sim' ])
            ],
            new Fato([ 'nome' => 'melhor cor', 'valor' => 'tinto', 'probabilidade' => 0.3 ])
        );

        // prato_principal(peixe) -> melhor_cor(branco) cnf 100%
        $regra_8 = new Regra(
            [
                new Fato([ 'nome' => 'prato principal', 'valor' => 'peixe' ])
            ],
            new Fato([ 'nome' => 'melhor cor', 'valor' => 'branco' ])
        );

        // prato_principal(carne) ^ tem_molho(sim) ^ molho(tomate) -> melhor_cor(tinto) cnf 100%
        $regra_9_1 = new Regra(
            [
                new Fato([ 'nome' => 'prato principal', 'valor' => 'carne' ]),
                new Fato([ 'nome' => 'tem molho', 'valor' => 'sim' ]),
                new Fato([ 'nome' => 'molho', 'valor' => 'tomate' ])
            ],
            new Fato([ 'nome' => 'melhor cor', 'valor' => 'tinto' ])
        );

        // prato_principal(aves) ^ tem_molho(sim) ^ molho(tomate) -> melhor_cor(tinto) cnf 100%
        $regra_9_2 = new Regra(
            [
                new Fato([ 'nome' => 'prato principal', 'valor' => 'aves' ]),
                new Fato([ 'nome' => 'tem molho', 'valor' => 'sim' ]),
                new Fato([ 'nome' => 'molho', 'valor' => 'tomate' ])
            ],
            new Fato([ 'nome' => 'melhor cor', 'valor' => 'tinto' ])
        );

        // prato_principal(aves) ^ tem_peru(sim) -> melhor_cor(tinto) cnf 80%
        $regra_10_1 = new Regra(
            [
                new Fato([ 'nome' => 'prato principal', 'valor' => 'aves' ]),
                new Fato([ 'nome' => 'tem peru', 'valor' => 'sim' ])
            ],
            new Fato([ 'nome' => 'melhor cor', 'valor' => 'tinto', 'probabilidade' => 0.8 ])
        );

        // prato_principal(aves) ^ tem_peru(sim) -> melhor_cor(branco) cnf 50%
        $regra_10_2 = new Regra(
            [
                new Fato([ 'nome' => 'prato principal', 'valor' => 'aves' ]),
                new Fato([ 'nome' => 'tem peru', 'valor' => 'sim' ])
            ],
            new Fato([ 'nome' => 'melhor cor', 'valor' => 'branco', 'probabilidade' => 0.5 ])
        );

        // prato_principal(desconhecido) ^ tem_molho(sim) ^ molho(sim) -> melhor_cor)(branco) CNF 40%
        $regra_11 = new Regra(
            [
                new Fato([ 'nome' => 'prato principal', 'valor' => 'desconhecido' ]),
                new Fato([ 'nome' => 'tem molho', 'valor' => 'sim']),
                new Fato([ 'nome' => 'molho', 'valor' => ' creme'])
            ],
            new Fato([ 'nome' => 'melhor cor', 'valor' => 'branco', 'probabilidade' => 0.40])
        );

        // tem_molho(sim) ^ molho(agridoce) -> melhor_suavidade(suave) cnf 90%
        $regra_12_1 = new Regra(
            [
                new Fato([ 'nome' => 'tem molho', 'valor' => 'sim' ]),
                new Fato([ 'nome' => 'molho', 'valor' => 'agridoce'])
            ],
            new Fato([ 'nome' => 'melhor suavidade', 'valor' => 'suave', 'probabilidade' => 0.90])
        );

        // tem_molho(sim) ^ molho(agridoce) -> melhor_suavidade(medio) cnf 40%
        $regra_12_2 = new Regra(
            [
                new Fato([ 'nome' => 'tem molho', 'valor' => 'sim' ]),
                new Fato([ 'nome' => 'molho', 'valor' => 'agridoce' ])
            ],
            new Fato([ 'nome' => 'melhor suavidade', 'valor' => 'medio', 'probabilidade' => 0.4])
        );

        // tem_molho(sim) ^ molho(apimentado) -> aspecto(condimentado) cnf 100%
        $regra_13 = new Regra(
            [
                new Fato([ 'nome' => 'tem molho', 'valor' => 'sim' ]),
                new Fato([ 'nome' => 'molho', 'valor' => 'apimentado' ])
            ],
            new Fato([ 'nome' => 'aspecto', 'valor' => 'condimentado'])
        );

        // melhor_corpo(leve) -> corpo_recomendado(medio) cnf 100%
        $regra_14 = new Regra(
            [
                new Fato([ 'nome' => 'melhor corpo', 'valor' => 'leve' ]),
            ],
            new Fato([ 'nome' => 'corpo recomendado', 'valor' => 'medio'])
        );

        // melhor_corpo(medio) -> corpo_recomendado(medio) cnf 100%
        $regra_15 = new Regra(
            [
                new Fato([ 'nome' => 'melhor corpo', 'valor' => 'medio' ]),
            ],
            new Fato([ 'nome' => 'corpo recomendado', 'valor' => 'medio'])
        );

        // melhor_corpo(encorpado) -> corpo_recomendado cnf 100%
        $regra_16 = new Regra(
            [
                new Fato([ 'nome' => 'melhor corpo', 'valor' => 'encorpado' ]),
            ],
            new Fato([ 'nome' => 'corpo recomendado', 'valor' => 'encorpado'])
        );

        // corpo_preferido(leve) -> corpo_recomendado(leve) cnf 20%
        $regra_17 = new Regra(
            [
                new Fato([ 'nome' => 'corpo preferido', 'valor' => 'leve' ]),
            ],
            new Fato([ 'nome' => 'corpo recomendado', 'valor' => 'leve', 'probabilidade' => 0.20])
        );

        // corpo preferido(medio) -> corpo_recomendado(medio) cnf 20%
        $regra_18 = new Regra(
            [
                new Fato([ 'nome' => 'corpo preferido', 'valor' => 'medio' ]),
            ],
            new Fato([ 'nome' => 'corpo recomendado', 'valor' => 'medio', 'probabilidade' => 0.20])
        );

        // corpo_preferido(encorpado) ^ melhor_corpo(encorpado) -> corpo_recomendado(encorpado) cnf 20%
        $regra_19 = new Regra(
            [
                new Fato([ 'nome' => 'corpo preferido', 'valor' => 'encorpado' ]),
                new Fato([ 'nome' => 'melhor corpo', 'valor' => 'encorpado' ])
            ],
            new Fato([ 'nome' => 'corpo recomendado', 'valor' => 'encorpado', 'probabilidade' => 0.20])
        );

        // corpo_preferido(leve) ^ melhor_corpo(encorpado) -> corpo_recomendado(medio) cnf 100%
        $regra_20 = new Regra(
            [
                new Fato([ 'nome' => 'corpo preferido', 'valor' => 'leve' ]),
                new Fato([ 'nome' => 'melhor corpo', 'valor' => 'encorpado' ])
            ],
            new Fato([ 'nome' => 'corpo recomendado', 'valor' => 'medio'])
        );

        // corpo_preferido(encorpado) ^ melhor_corpo(leve) -> corpo_recomendado(medio) cnf 100%
        $regra_21 = new Regra(
            [
                new Fato([ 'nome' => 'corpo preferido', 'valor' => 'encorpado' ]),
                new Fato([ 'nome' => 'melhor corpo', 'valor' => 'leve' ])
            ],
            new Fato([ 'nome' => 'corpo recomendado', 'valor' => 'medio'])
        );

        // corpo_preferido(leve) ^ melhor_corpo(desconhecido) -> corpo_recomendado(leve) cnf 100%
        $regra_22 = new Regra(
            [
                new Fato([ 'nome' => 'corpo preferido', 'valor' => 'leve' ]),
                new Fato([ 'nome' => 'melhor corpo', 'valor' => 'desconhecido' ])
            ],
            new Fato([ 'nome' => 'corpo recomendado', 'valor' => 'leve'])
        );

        // corpo_preferido(medio) ^ melhor_corpo(desconhecido) -> corpo_recomendado(medio)
        $regra_23 = new Regra(
            [
                new Fato([ 'nome' => 'corpo preferido', 'valor' => 'medio' ]),
                new Fato([ 'nome' => 'melhor corpo', 'valor' => 'desconhecido' ])
            ],
            new Fato([ 'nome' => 'corpo recomendado', 'valor' => 'medio'])
        );

        // corpo_preferido(encorpado) 
        $regra_24 = new Regra(
            [
                new Fato([ 'nome' => 'corpo preferido', 'valor' => 'encorpado' ]),
                new Fato([ 'nome' => 'melhor corpo', 'valor' => 'desconhecido' ])
            ],
            new Fato([ 'nome' => 'corpo recomendado', 'valor' => 'encorpado'])
        );
        $regra_25 = new Regra(
            [
                new Fato([ 'nome' => 'melhor corpo', 'valor' => 'desconhecido' ]),
            ],
            new Fato([ 'nome' => 'corpo recomendado', 'valor' => 'medio'])
        );
        $regra_26 = new Regra(
            [
                new Fato([ 'nome' => 'melhor cor', 'valor' => 'tinto' ]),
            ],
            new Fato([ 'nome' => 'cor recomendada', 'valor' => 'tinto'])
        );
        $regra_27 = new Regra(
            [
                new Fato([ 'nome' => 'melhor cor', 'valor' => 'branco' ]),
            ],
            new Fato([ 'nome' => 'cor recomendada', 'valor' => 'branco'])
        );
        $regra_28 = new Regra(
            [
                new Fato([ 'nome' => 'cor preferida', 'valor' => 'tinto' ]),
                new Fato([ 'nome' => 'melhor cor', 'valor' => 'tinto' ])
            ],
            new Fato([ 'nome' => 'cor recomendada', 'valor' => 'tinto', 'probabilidade' => 0.20])
        );
        $regra_29 = new Regra(
            [
                new Fato([ 'nome' => 'cor preferida', 'valor' => 'branco' ]),
                new Fato([ 'nome' => 'melhor cor', 'valor' => 'branco' ])
            ],
            new Fato([ 'nome' => 'cor recomendada', 'valor' => 'branco', 'probabilidade' => 0.20])
        );
        $regra_30 = new Regra(
            [
                new Fato([ 'nome' => 'cor preferida', 'valor' => 'tinto' ]),
                new Fato([ 'nome' => 'melhor cor', 'valor' => 'desconhecido' ])
            ],
            new Fato([ 'nome' => 'cor recomendada', 'valor' => 'tinto'])
        );
        $regra_31 = new Regra(
            [
                new Fato([ 'nome' => 'cor preferida', 'valor' => 'branco' ]),
                new Fato([ 'nome' => 'melhor cor', 'valor' => 'desconhecido' ])
            ],
            new Fato([ 'nome' => 'cor recomendada', 'valor' => 'branco'])
        );
        $regra_32_1 = new Regra(
            [
                new Fato([ 'nome' => 'cor preferida', 'valor' => 'desconhecido' ]),
            ],
            new Fato([ 'nome' => 'cor recomendada', 'valor' => 'branco', 'probabilidade' => 0.50])
        );
        $regra_32_2 = new Regra(
            [
                new Fato([ 'nome' => 'cor preferida', 'valor' => 'desconhecido' ]),
            ],
            new Fato([ 'nome' => 'cor recomendada', 'valor' => 'tinto', 'probabilidade' => 0.50])
        );
        $regra_33 = new Regra(
            [
                new Fato([ 'nome' => 'suavidade', 'valor' => 'seco' ]),
            ],
            new Fato([ 'nome' => 'suavidade recomendada', 'valor' => 'seco'])
        );
        $regra_34 = new Regra(
            [
                new Fato([ 'nome' => 'suavidade', 'valor' => 'medio' ]),
            ],
            new Fato([ 'nome' => 'suavidade recomendada', 'valor' => 'medio'])
        );
        $regra_35 = new Regra(
            [
                new Fato([ 'nome' => 'melhor suavidade', 'valor' => 'suave' ]),
            ],
            new Fato([ 'nome' => 'suavidade recomendada', 'valor' => 'suave'])
        );
        $regra_36 = new Regra(
            [
                new Fato([ 'nome' => 'melhor suavidade', 'valor' => 'desconhecido' ]),
                new Fato([ 'nome' => 'suavidade preferida', 'valor' => 'desconhecido' ])
            ],
            new Fato([ 'nome' => 'suavidade recomendada', 'valor' => 'medio'])
        );
        $regra_37 = new Regra(
            [
                new Fato([ 'nome' => 'çmelhor suavidade', 'valor' => 'seco' ]),
                new Fato([ 'nome' => 'suavidade preferida', 'valor' => 'seco' ])
            ],
            new Fato([ 'nome' => 'suavidade recomendada', 'valor' => 'seco'])
        );
        $regra_38 = new Regra(
            [
                new Fato([ 'nome' => 'melhor suavidade', 'valor' => 'medio' ]),
                new Fato([ 'nome' => 'suavidade preferida', 'valor' => 'medio' ])
            ],
            new Fato([ 'nome' => 'suavidade recomendada', 'valor' => 'medio', 'probabilidade' => 0.20])
        );
        $regra_39 = new Regra(
            [
                new Fato([ 'nome' => 'melhor suavidade', 'valor' => 'suave' ]),
                new Fato([ 'nome' => 'suavidade preferida', 'valor' => 'suave' ])
            ],
            new Fato([ 'nome' => 'suave recomendada', 'valor' => 'suave', 'probabilidade' => 0.20])
        );
        $regra_40 = new Regra(
            [
                new Fato([ 'nome' => 'suavidade preferida', 'valor' => 'seco' ]),
                new Fato([ 'nome' => 'melhor suavidade', 'valor' => 'desconhecido' ])
            ],
            new Fato([ 'nome' => 'suavidade recomendada', 'valor' => 'seco' ])
        );
        $regra_41 = new Regra(
            [
                new Fato([ 'nome' => 'suavidade preferida', 'valor' => 'medio' ]),
                new Fato([ 'nome' => 'melhor suavidade', 'valor' => 'desconhecido' ])
            ],
            new Fato([ 'nome' => 'suavidade recomendada', 'valor' => 'medio'])
        );
        $regra_42 = new Regra(
            [
                new Fato([ 'nome' => 'suavidade preferida', 'valor' => 'suave' ]),
                new Fato([ 'nome' => 'melhor suavidade', 'valor' => 'desconhecido' ])
            ],
            new Fato([ 'nome' => 'suavidade recomendada', 'valor' => 'suave'])
        );
        $regra_43 = new Regra(
            [
                new Fato([ 'nome' => 'suavidade prederida', 'valor' => 'seco' ]),
                new Fato([ 'nome' => 'melhor suavidade', 'valor' => 'suave' ])
            ],
            new Fato([ 'nome' => 'suavidade recomendada', 'valor' => 'medio'])
        );
        $regra_44 = new Regra(
            [
                new Fato([ 'nome' => 'suavidade preferida', 'valor' => 'suave' ]),
                new Fato([ 'nome' => 'melhor suavidade', 'valor' => 'seco' ])
            ],
            new Fato([ 'nome' => 'suavidade recomendada', 'valor' => 'medio'])
        );
        $regra_45_1 = new Regra(
            [
                new Fato([ 'nome' => 'cor recomendada ', 'valor' => 'tinto' ]),
                new Fato([ 'nome' => 'corpo recomendado', 'valor' => 'medio' ]),
                new Fato([ 'nome' => 'suavidade recomendada', 'valor' => 'medio' ])
            ],
            new Fato([ 'nome' => 'vinho', 'valor' => 'Gamay'])
        );
        $regra_45_2 = new Regra(
            [
                new Fato([ 'nome' => 'cor recomendada', 'valor' => 'tinto' ]),
                new Fato([ 'nome' => 'corpo recomendado', 'valor' => 'medio' ]),
                new Fato([ 'nome' => 'suavidade', 'valor' => 'suave' ])
            ],
            new Fato([ 'nome' => 'vinho', 'valor' => 'Gamay'])
        );
        $regra_46_1 = new Regra(
            [
                new Fato([ 'nome' => 'cor recomendada', 'valor' => 'branco' ]),
                new Fato([ 'nome' => 'corpo recomendado', 'valor' => 'leve' ])
            ],
            new Fato([ 'nome' => 'vinho', 'valor' => 'Chablis'])
        );
        $regra_46_2 = new Regra(
            [
                new Fato([ 'nome' => 'cor recomendada', 'valor' => 'branco' ]),
                new Fato([ 'nome' => 'suavidade recomendada', 'valor' => 'suave' ])
            ],
            new Fato([ 'nome' => 'vinho', 'valor' => 'Chablis'])
        );
        $regra_47_1 = new Regra(
            [
                new Fato([ 'nome' => 'cor recomendada', 'valor' => 'branco' ]),
                new Fato([ 'nome' => 'corpo recomendado', 'valor' => 'medio' ])
            ],
            new Fato([ 'nome' => 'vinho', 'valor' => 'Sauvingnon Blanc'])
        );
        $regra_47_2 = new Regra(
            [
                new Fato([ 'nome' => 'cor recomendada', 'valor' => 'branco' ]),
                new Fato([ 'nome' => 'suavidade recomendada', 'valor' => 'seco' ])
            ],
            new Fato([ 'nome' => 'vinho', 'valor' => 'Sauvingnon'])
        );
        $regra_48_1 = new Regra(
            [
                new Fato([ 'nome' => 'cor recomendada', 'valor' => 'branco' ]),
                new Fato([ 'nome' => 'corpo recomendado', 'valor' => 'medio' ]),
                new Fato([ 'nome' => 'suavidade recomendada', 'valor' => 'seco' ])
            ],
            new Fato([ 'nome' => 'vinho', 'valor' => 'Chardonnay'])
        );
        $regra_48_2 = new Regra(
            [
                new Fato([ 'nome' => 'cor recomendada', 'valor' => 'branco' ]),
                new Fato([ 'nome' => 'corpo recomendado', 'valor' => 'encorpado' ]),
                new Fato([ 'nome' => ' suavidade recomendada', 'valor' => 'seco' ])
            ],
            new Fato([ 'nome' => 'vinho', 'valor' => ' Chardonnay'])
        );
        $regra_48_3 = new Regra(
            [
                new Fato([ 'nome' => 'cor recomendada', 'valor' => 'branco' ]),
                new Fato([ 'nome' => 'cor recomendado', 'valor' => 'medio' ]),
                new Fato([ 'nome' => 'suavidade recomendada', 'valor' => 'medio' ])
            ],
            new Fato([ 'nome' => 'vinho', 'valor' => 'Chardonnay'])
        );
        $regra_48_4 = new Regra(
            [
                new Fato([ 'nome' => 'cor recomendada', 'valor' => 'branco' ]),
                new Fato([ 'nome' => 'corpo recomendado', 'valor' => 'encorpado' ]),
                new Fato([ 'nome' => 'suavidade recomendada', 'valor' => 'medio' ])
            ],
            new Fato([ 'nome' => 'vinho', 'valor' => 'Chardonnay'])
        );
        $regra_49_1 = new Regra(
            [
                new Fato([ 'nome' => 'cor recomendada', 'valor' => 'branco' ]),
                new Fato([ 'nome' => 'corpo recomendado', 'valor' => 'leve' ]),
                new Fato([ 'nome' => 'suavidade recomendada', 'valor' => 'seco' ])
            ],
            new Fato([ 'nome' => 'vinho', 'valor' => 'Soave'])
        );
        $regra_49_2 = new Regra(
            [
                new Fato([ 'nome' => 'cor recomendada', 'valor' => 'branco' ]),
                new Fato([ 'nome' => 'corpo recomendado', 'valor' => 'leve' ]),
                new Fato([ 'nome' => 'suavidade recomendada', 'valor' => 'medio' ])
            ],
            new Fato([ 'nome' => 'vinho', 'valor' => 'Soave'])
        );
        $regra_50_1 = new Regra(
            [
                new Fato([ 'nome' => 'cor recomendada', 'valor' => 'branco' ]),
                new Fato([ 'nome' => 'corpo recomendado', 'valor' => 'leve' ]),
                new Fato([ 'nome' => 'suavidade recomendada', 'valor' => 'medio' ])
            ],
            new Fato([ 'nome' => 'vinho', 'valor' => 'Riesling'])
        );
        $regra_50_2 = new Regra(
            [
                new Fato([ 'nome' => 'cor recomendada', 'valor' => 'branco' ]),
                new Fato([ 'nome' => 'corpo recomendado', 'valor' => 'medio' ]),
                new Fato([ 'nome' => 'suavidade recomendada', 'valor' => 'medio' ])
            ],
            new Fato([ 'nome' => 'vinho', 'valor' => 'Riesling'])
        );
        $regra_50_3 = new Regra(
            [
                new Fato([ 'nome' => 'cor recomendada', 'valor' => 'branco' ]),
                new Fato([ 'nome' => 'corpo recomendado', 'valor' => 'leve' ]),
                new Fato([ 'nome' => 'suavidade recomendada', 'valor' => 'suave' ])
            ],
            new Fato([ 'nome' => 'vinho', 'valor' => 'Riesling'])
        );
        $regra_50_4 = new Regra(
            [
                new Fato([ 'nome' => 'cor recomendada', 'valor' => 'branco' ]),
                new Fato([ 'nome' => 'corpo recomendado', 'valor' => 'medio' ]),
                new Fato([ 'nome' => 'suavidadade recomendada', 'valor' => 'suave' ])
            ],
            new Fato([ 'nome' => 'vinho', 'valor' => 'Riesling'])
        );
        $regra_51 = new Regra(
            [
                new Fato([ 'nome' => 'cor recomendada', 'valor' => 'branco' ]),
                new Fato([ 'nome' => 'corpo recomendado', 'valor' => 'encorpado' ]),
                new Fato([ 'nome' => 'aspecto', 'valor' => 'condimentado' ])
            ],
            new Fato([ 'nome' => 'vinho', 'valor' => 'Geverztraminer'])
        );
        $regra_52_1 = new Regra(
            [
                new Fato([ 'nome' => 'cor recomendada', 'valor' => 'branco' ]),
                new Fato([ 'nome' => 'corpo recomendado', 'valor' => 'leve' ]),
                new Fato([ 'nome' => 'suavidade recomendada', 'valor' => 'medio' ])
            ],
            new Fato([ 'nome' => 'vinho', 'valor' => 'Chenin Blanc'])
        );
        $regra_52_2 = new Regra(
            [
                new Fato([ 'nome' => 'cor recomendada', 'valor' => 'branco' ]),
                new Fato([ 'nome' => 'corpo recomendado', 'valor' => 'leve' ]),
                new Fato([ 'nome' => 'suavidade recomendada', 'valor' => 'suave' ])
            ],
            new Fato([ 'nome' => 'vinho', 'valor' => 'Chenin Blanc'])
        );
        $regra_53 = new Regra(
            [
                new Fato([ 'nome' => 'cor recomendada', 'valor' => 'tinto' ]),
                new Fato([ 'nome' => 'corpo recomendado', 'valor' => 'leve' ])
            ],
            new Fato([ 'nome' => 'vinho', 'valor' => 'Valpolicella'])
        );
        $regra_54_1 = new Regra(
            [
                new Fato([ 'nome' => 'cor recomendada', 'valor' => 'tinto' ]),
                new Fato([ 'nome' => 'suavidade recomendada', 'valor' => 'seco' ])
            ],
            new Fato([ 'nome' => 'vinho', 'valor' => 'Carbenet Sauvignon'])
        );
        $regra_54_2 = new Regra(
            [
                new Fato([ 'nome' => 'cor recomendada', 'valor' => 'tinto' ]),
                new Fato([ 'nome' => 'suavidade recomendada', 'valor' => 'medio' ])
            ],
            new Fato([ 'nome' => 'vinho', 'valor' => 'Zinfandel'])
        );
        $regra_55 = new Regra(
            [
                new Fato([ 'nome' => 'cor recomendada', 'valor' => 'tinto' ]),
                new Fato([ 'nome' => 'corpo recomendado', 'valor' => 'medio' ]),
                new Fato([ 'nome' => 'suavidade recomendada', 'valor' => 'medio' ])
            ],
            new Fato([ 'nome' => 'vinho', 'valor' => 'Pinot Noir'])
        );
        $regra_56 = new Regra(
            [
                new Fato([ 'nome' => 'cor recomendada', 'valor' => 'tinto' ]),
                new Fato([ 'nome' => 'corpo recomendado', 'valor' => 'encorpado' ])
            ],
            new Fato([ 'nome' => 'vinho', 'valor' => 'Burgundy'])
        );

        return [ 
            $regra_1,                                           // Regra 1
            $regra_2,                                           // Regra 2
            $regra_3_1, $regra_3_2, $regra_3_3,                 // Regra 3
            $regra_4_1, $regra_4_2,                             // Regra 4 
            $regra_5_1, $regra_5_2,                             // Regra 5
            $regra_6,                                           // Regra 6
            $regra_7_1, $regra_7_2,                             // Regra 7
            $regra_8,                                           // Regra 8
            $regra_9_1, $regra_9_2,                             // Regra 9
            $regra_10_1, $regra_10_2,                            // Regra 10
            $regra_11,                                          // Regra 11
            $regra_12_1, $regra_12_2,                            // Regra 12
            $regra_13,                                          // Regra 13
            $regra_14,                                          // Regra 14
            $regra_15,                                          // Regra 15
            $regra_16,                                          // Regra 16
            $regra_17,                                          // Regra 17
            $regra_18,                                          // Regra 18
            $regra_19,                                          // Regra 19
            $regra_20,                                          // Regra 20
            $regra_21,                                          // Regra 21
            $regra_22,                                          // Regra 22
            $regra_23,                                          // Regra 23
            $regra_24,                                          // Regra 24
            $regra_25,                                          // Regra 25
            $regra_26,                                          // Regra 26
            $regra_27,                                          // Regra 27
            $regra_28,                                          // Regra 28
            $regra_29,                                          // Regra 29
            $regra_30,                                          // Regra 30
            $regra_31,                                          // Regra 31
            $regra_32_1, $regra_32_2,                            // Regra 32
            $regra_33,                                          // Regra 33
            $regra_34,                                          // Regra 34
            $regra_35,                                          // Regra 35
            $regra_36,                                          // Regra 36
            $regra_37,                                          // Regra 37
            $regra_38,                                          // Regra 38
            $regra_39,                                          // Regra 39
            $regra_40,                                          // Regra 40
            $regra_41,                                          // Regra 41
            $regra_42,                                          // Regra 42
            $regra_43,                                          // Regra 43
            $regra_44,                                          // Regra 44
            $regra_45_1, $regra_45_2,                            // Regra 45
            $regra_46_1, $regra_46_2,                           // Regra 46
            $regra_47_1, $regra_47_2,                            // Regra 47
            $regra_48_1, $regra_48_2, $regra_48_3, $regra_48_4,  // Regra 48
            $regra_49_1, $regra_49_2,                            // Regra 49
            $regra_50_1, $regra_50_2, $regra_50_3, $regra_50_4,  // Regra 50
            $regra_51,                                          // Regra 51
            $regra_52_1,   $regra_52_2,                            // Regra 52
            $regra_53,                                          // Regra 53
            $regra_54_1,   $regra_54_2,                            // Regra 54
            $regra_55,                                          // Regra 55
            $regra_56,                                          // Regra 56
 
        ];
    }
}