<?php

namespace netvod\dispatch;

use netvod\action\AfficherSerie;
use netvod\action\Lobby;
use netvod\action\SeConnecter;
use netvod\user\Utilisateur;

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
                if(!isset($_SESSION['user'])) {
                    $inscription = new Inscription();
                    $html = $inscription->execute();
                }
                break;
            case 'connexion':
                if(!isset($_SESSION['user'])) {
                    $connexion = new SeConnecter();
                    $html = $connexion->execute();
                }
                break;
            case 'lobby':
                $lobby = new Lobby();
                $html = $lobby->execute();
                break;
            case 'afficher-serie':
                $afficherSerie = new AfficherSerie();
                $html = $afficherSerie->execute();
                break;

        }
        return $html;
    }
}