<?php

/**
 * valide une combinaisons de couleurs au MaserMind, en la comparant à une
 * solution
 *
 * @param array $proposition la combinaison de couleurs proposées (tableau
 * ordonné de chaînes de caractères (parmi 'rouge', 'jaune', 'vert', 'bleu',
 * 'orange', 'blanc')
 * @param array $solution la combinaison gagnante (même format que $proposition)
 * @return array un tableau associatif contenant les clés « rouge » et
 * « blanc », contenant des entiers représentant le score de la proposition
 */
function validation_ligne_mastermind($proposition, $solution) {
    $couleurs = ['rouge', 'jaune', 'vert', 'bleu', 'orange', 'blanc'];
    $reponse = [];
    if(is_array($proposition)
       && is_array($solution)
       && count($proposition) == count($solution)
       && !count(array_diff($proposition, $couleurs))
       && !count(array_diff($solution, $couleurs)) ) {
        // on effectue la vérification de la proposition
        $reponse['rouge'] = 0;
        $reponse['blanc'] = 0;
        // on vérifie les rouges
        // echo '** verification des rouges **'.PHP_EOL;
        foreach($solution as $cle => $coul_solution) {
            if($coul_solution == $proposition[$cle]) {
                // echo $coul_solution.' trouve, pos '.$cle.PHP_EOL;
                // echo 'ROUGE++'.PHP_EOL;
                $reponse['rouge']++;
                $solution[$cle] = null;
                $proposition[$cle] = null;
                // echo PHP_EOL.'['.implode(',', $solution).']'.PHP_EOL;
                // echo '['.implode(',', $proposition).']'.PHP_EOL.PHP_EOL;
            }
        }

        // on vérifie les blancs
        // echo '** verification des blancs **'.PHP_EOL;
        foreach($solution as $cle => $coul_solution) {
            if($coul_solution) {
                $cle_proposition = array_search($coul_solution, $proposition);
                if($cle_proposition!== false) {
                    // echo $coul_solution.' trouve dans solution, pos '.$cle_proposition.PHP_EOL;
                    // echo 'BLANC++'.PHP_EOL;
                    $reponse['blanc']++;
                    $solution[$cle] = null;
                    $proposition[$cle_proposition] = null;
                    // echo PHP_EOL.'['.implode(',', $solution).']'.PHP_EOL;
                    // echo '['.implode(',', $proposition).']'.PHP_EOL.PHP_EOL;
                }
            }
        }
    } else {
        $reponse['erreur'] = 'Données invalides';
    }
    return $reponse;
}
