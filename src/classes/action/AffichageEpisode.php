<?php

namespace netvod\action;

use netvod\db\ConnectionFactory;
use netvod\render\EpisodeRender;
use netvod\user\Utilisateur;
use netvod\video\episode\Episode;
use netvod\video\Etat\EpVisionne;
use netvod\video\Etat\SerieVisionne;
use netvod\video\lists\ListeSerie;
use netvod\video\Etat\EnCours;

class AffichageEpisode
{
    public function execute(int $numEpisode, int $idSerie): string
    {
        //on récupere l'user
        $user = unserialize($_SESSION['user']);
        //on récupere l'id de l'user
        $userId = $user->IDuser;
        //on récupere les série
        $listeSerie = ListeSerie::getInstance();
        $series = $listeSerie->getSeries();

        //on parcours les séries :
        foreach ($series as $serie) {
            //si la série est la même
            if ($serie->IDserie == $idSerie) {
                $serieActuelle = $serie;
                //on récupere les épisodes de la série :
                $episodes = $serie->getEpisodes();
                //on vérifie si la série a deja été visonne
                if (!SerieVisionne::Visionne($userId, $idSerie)) {
                    if(EnCours::enCours($idSerie,$userId))
                    {
                        //si elle n'est pas dans visionne on peut l'ajouter dans en Cours
                        $user->ajouterEnCours($serieActuelle);
                        EnCours::ajouterEnCours($idSerie,$userId);
                    }

                }
                break;
            }
        }
        foreach ($episodes as $episode) {
            //si le numero d'épisode est le meme que celui demande
            if ($episode->numeroEp == $numEpisode) {
                $episodeAffiche = $episode;
                if ($episodeAffiche->numeroEp == $serieActuelle->nbEpisode) {
                    if(!EnCours::enCours($idSerie,$userId))
                    {
                        $user->supprimerEnCours($serieActuelle);
                        EnCours::supprimerEnCours($serieActuelle->IDserie);
                        SerieVisionne::ajouterVisionne($userId, $idSerie);
                        $user->ajouterVisionne($serieActuelle);
                    }
                }
                break;
            }
        }
        $_SESSION['user'] = serialize($user);
        $render = new EpisodeRender($episodeAffiche);
        return $render->render();
    }
}