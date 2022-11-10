<?php

namespace netvod\dispatch;

use netvod\action\AfficherSerie;
use netvod\action\AffichageEpisode;
use netvod\action\Deconnexion;
use netvod\action\Commentaire;
use netvod\action\Favoris;
use netvod\action\Lobby;
use netvod\action\SeConnecter;
use netvod\action\Inscription;
use netvod\action\MotDePasseOublie;
use netvod\action\ChangementMotDePasse;

use netvod\action\Recherche;

use netvod\action\ActivationCompte;


use netvod\Auth\Auth;
use netvod\user\Utilisateur;

/**
 * Class Dispatcher
 * qui permet de dispatcher les requetes vers les actions correspondantes
 */
class Dispatcher
{

    /**
     * constructeur vide de la classe Dispatcher
     */
    public function __construct(){}

    /**
     * fonction dispatch qui permet de dispatcher les requetes vers les actions correspondantes
     * @return string le rendu de la page
     */
    public function dispatch(): string
    {
        // on récupère les données dans la requetes
        $action = (isset($_GET['action'])) ? $_GET['action'] : null;
        $idSerie = (isset($_GET['idSerie'])) ? $_GET['idSerie'] : null;
        $numEp = (isset($_GET['numEp'])) ? $_GET['numEp'] : null;


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
                $html = $afficherEpisode->execute($numEp, $idSerie);
                break;

            case 'commentaires':
                $commentaire = new Commentaire();
                $html = $commentaire->execute();
                break;

            case 'activation':
                $act = new ActivationCompte();
                $html = $act->execute();
                break;

            case 'profile':
                if(!Auth::verification())
                {
                    $connexion = new SeConnecter();
                    $html = $connexion->execute();
                }
                break;

            case 'favoris':
                if(!Auth::verification())
                {
                    $connexion = new SeConnecter();
                    $html = $connexion->execute();
                }
                else
                {
                    $favoris = new Favoris();
                    $html = $favoris->execute();
                }
            break;

            case 'deconnexion':
                $deconnexion = new Deconnexion();
                $html = $deconnexion->execute();
                break;

            case 'motDePasseOublie':
                $mdp = new MotDePasseOublie();
                $html = $mdp->execute();
                break;

            case 'changementMotDePasse':
                $mdp = new ChangementMotDePasse();
                $html = $mdp->execute();
                break;

            case 'recherche':
                $recherche = new Recherche();
                $html = $recherche->execute();
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