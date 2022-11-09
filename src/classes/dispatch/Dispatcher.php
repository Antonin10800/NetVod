<?php

namespace netvod\dispatch;

use netvod\action\AfficherSerie;
use netvod\action\AffichageEpisode;
use netvod\action\Lobby;
use netvod\action\Profil;
use netvod\action\SeConnecter;
use netvod\action\Inscription;
use netvod\action\PageUtilisateur;

use netvod\Auth\Auth;
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
                if(!Auth::verification()) {
                    $inscription = new Inscription();
                    $html = $inscription->execute();
                }
                else
                {
                    $lobby = new Lobby();
                    $html = $lobby->execute();
                }
                break;
            case 'connexion':
            case 'lobby':
                if(!Auth::verification()) {
                    $connexion = new SeConnecter();
                    $html = $connexion->execute();
                }
                else
                {
                    $lobby = new Lobby();
                    $html = $lobby->execute();
                }
                break;

            case 'afficher-serie':

                $afficherSerie = new AfficherSerie();
                $html = $afficherSerie->execute();
                break;

            case 'afficher-episode':
                $afficherEpisode = new AffichageEpisode();
                $html = $afficherEpisode->execute($IDepisode, $idSerie);
                break;

            case 'profile':
                if(!Auth::verification())
                {
                    $connexion = new SeConnecter();
                    $html = $connexion->execute();
                }
                else
                {
                    $profil = new Profil();
                    $html = $profil->execute();
                }
                break;

            default:
                if(Auth::verification())
                {
                    $lobby = new Lobby();
                    $html = $lobby->execute();
                }
                else
                {
                    $connexion = new SeConnecter();
                    $html = $connexion->execute();
                }
                break;

        }
        return $html;
    }
}