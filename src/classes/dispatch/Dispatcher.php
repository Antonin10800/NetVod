<?php

namespace netvod\dispatch;

use netvod\action\AfficherSerie;
use netvod\action\AffichageEpisode;
use netvod\action\Lobby;
use netvod\action\SeConnecter;
use netvod\action\Inscription;
use netvod\action\PageUtilisateur;

use netvod\user\Utilisateur;



class Dispatcher
{
    public function __construct()
    {

    }

    public function dispatch(): string
    {
        $action = (isset($_GET['action'])) ? $_GET['action'] : null;
        $IDepisode = (isset($_GET['IDepisode'])) ? $_GET['IDepisode'] : null;

        $html = '';
        switch ($action) {
            case 'inscription':
                if(!isset($_SESSION['user'])) {
                    $inscription = new Inscription();
                    $html = $inscription->execute();
                }
                else
                {
                    $html = "Vous êtes déjà connecté";
                }
                break;
            case 'connexion':
                if(!isset($_SESSION['user'])) {
                    $connexion = new SeConnecter();
                    $html = $connexion->execute();
                }
                else
                {
                    $lobby = new Lobby();
                    $html = $lobby->execute();
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




            case 'afficher-episode':
                $afficherEpisode = new AffichageEpisode();
                $html = $afficherEpisode->execute($IDepisode);
                break;

            default:
                if(isset($_SESSION['user']))
                {
                    $lobby = new Lobby();
                    $html = $lobby->execute();
                }
                else
                {
                    $connexion = new SeConnecter();
                    $html = $connexion->execute();
                }

        }
        return $html;
    }
}