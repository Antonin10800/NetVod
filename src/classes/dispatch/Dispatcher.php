<?php

namespace netvod\dispatch;

use netvod\action\AfficherSerie;
use netvod\action\Lobby;
use netvod\action\SeConnecter;
use netvod\action\Inscription;

class Dispatcher
{
    public function __construct()
    {

    }

    public function dispatch(): string
    {
        $action = (isset($_GET['action'])) ? $_GET['action'] : null;
        $html = '';
        switch ($action) {
            case 'inscription':
                $inscription = new Inscription();
                $html = $inscription->execute();
                break;
            case 'connexion':
                $connexion = new SeConnecter();
                $html = $connexion->execute();
                break;
            case 'lobby':
                $lobby = new Lobby();
                $html = $lobby->execute();
                break;
            case 'afficher-serie':
                $afficherSerie = new AfficherSerie();
                $html = $afficherSerie->execute();
                break;

            default:
                $html .= <<<HTML
                <h1>Page d'accueil</h1> 
                <a href="index.php?action=connexion">Connexion<br></a>
                <a href="index.php?action=inscription">inscription<br></a>
                HTML;
                if(is_null($_SESSION['utilisateur'])){
                    $html .= "pas connecté <br>";
                } else {
                    $html .= "connecté <br>";
                    $user = unserialize($_SESSION['utilisateur']);
                    $html .= $user;
                }

        }
        return $html;
    }
}