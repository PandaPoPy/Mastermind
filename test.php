<?php

require_once('functions.php');

// tests

$valeurs = [[
             'proposition' => ['bleu', 'rouge', 'vert', 'jaune'],
             'solution' => ['bleu', 'orange', 'blanc', 'vert'],
             'score_attendu' => ['rouge' => 1, 'blanc' => 1]
         ],[
             'proposition' => ['bleu', 'rouge', 'vert', 'jaune'],
             'solution' => ['bleu', 'rouge', 'blanc', 'vert'],
             'score_attendu' => ['rouge' => 2, 'blanc' => 1]
         ],[
             'proposition' => ['bleu', 'bleu', 'vert', 'jaune'],
             'solution' => ['bleu', 'orange', 'blanc', 'vert'],
             'score_attendu' => ['rouge' => 1, 'blanc' => 1]
         ],[
             'proposition' => ['bleu', 'rouge', 'vert', 'jaune'],
             'solution' => ['bleu', 'bleu', 'blanc', 'vert'],
             'score_attendu' => ['rouge' => 1, 'blanc' => 1]
         ],[
             'proposition' => ['bleu', 'bleu', 'vert', 'jaune'],
             'solution' => ['bleu', 'orange', 'bleu', 'vert'],
             'score_attendu' => ['rouge' => 1, 'blanc' => 2]
         ],[
             'proposition' => ['bleu', 'bleu', 'bleu', 'bleu'],
             'solution' => ['blanc', 'bleu', 'blanc', 'bleu'],
             'score_attendu' => ['rouge' => 2, 'blanc' => 0]
         ],[
             'proposition' => ['blanc', 'bleu', 'blanc', 'bleu'],
             'solution' => ['bleu', 'bleu', 'bleu', 'bleu'],
             'score_attendu' => ['rouge' => 2, 'blanc' => 0]
         ],[
             'proposition' => ['vert', 'bleu', 'vert', 'rouge'],
             'solution' => ['blanc', 'vert', 'blanc', 'vert'],
             'score_attendu' => ['rouge' => 0, 'blanc' => 2]
         ],[
             'proposition' => ['vert', 'bleu', 'vert', 'rose'],
             'solution' => ['blanc', 'vert', 'blanc', 'vert'],
             'score_attendu' => ['erreur' => 'Données invalides']
         ]
         ];


$ok = 0;
$fail = 0;
foreach($valeurs as $test_id => $test) {
    $retour = validation_ligne_mastermind($test['proposition'],
                                          $test['solution']);
    $score_attendu = $test['score_attendu'];
    if($retour === $score_attendu) {
        echo 'Test '.$test_id.' <span style="color: green;">OK</span><br />'.PHP_EOL;
        $ok++;
    } else {
        echo 'Test '.$test_id.' <span style="color: red;">KO</span><br />'.PHP_EOL;
        var_dump($score_attendu);
        var_dump($retour);
        $fail++;
    }
}
echo '<br />Resultats : <span style="color: green;">'.$ok.' OK</span>, <span style="color: red;">'.$fail.' KO</span><br />'.PHP_EOL;
