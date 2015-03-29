<?php

require_once('functions.php');

session_start();
header('Content-type: application/json');

$reponse = [];

$couleurs = ['rouge', 'jaune', 'vert', 'bleu', 'orange', 'blanc'];

if(isset($_GET['action'])) {
    switch($_GET['action']) {
        case 'initialisation':
            // on lance le jeu
            $solution = [];
            for($i = 0; $i < 4; $i++) {
                $index = mt_rand(0,count($couleurs)-1);
                $solution[] = $couleurs[$index];
            }
            $_SESSION['solution'] = $solution;
            $reponse['DEBUG'] = $solution;
            break;
        case 'validation':
            if(isset($_SESSION['solution'], $_GET['proposition'])) {
                $retour = validation_ligne_mastermind($_GET['proposition'], $_SESSION['solution']);
                $reponse['blancs'] = $retour['blanc'];
                $reponse['rouges'] = $retour['rouge'];
            } else {
                $reponse['erreur'] = 'Aucune partie n’est en cours';
            }
            break;
        case 'reponse':
            if(isset($_SESSION['solution'])) {
                $reponse['solution'] = $_SESSION['solution'];
                unset($_SESSION['solution']);
            } else {
                $reponse['erreur'] = 'Aucune partie n’est en cours';
            }
            break;
        default:
            $reponse['erreur'] = 'Action non reconnue';
            break;
    }
} else {
    $reponse['erreur'] = 'Paramètres invalides';
}

echo json_encode($reponse);
