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
        $user = unserialize($_SESSION['user']);
        $userId = $user->IDuser;
        $listeSerie = ListeSerie::getInstance();
        $series = $listeSerie->getSeries();

        foreach ($series as $serie) {
            if ($serie->IDserie == $idSerie) {
                $Idserie = $serie->__get('IDserie');
                $episodes = $serie->getEpisodes();
                if (SerieVisionne::Visionne($userId, $Idserie) == false) {
                    $user->ajouterEnCours($serie, $Idserie);
                    $IDepisode = $episodes[$numEpisode - 1]->__get('IDepisode');
                    EpVisionne::ajouterVisionne($userId, $IDepisode);
                }
                echo sizeof($episodes);
                break;
            }
        }
        foreach ($episodes as $episode) {
            if ($episode->__get('numeroEp') == $numEpisode) {
                $episodeAffiche = $episode;

                if ($episode->__get('numeroEp') == sizeof($episodes)) {
                    EnCours::supprimerEnCours($Idserie);


                    SerieVisionne::ajouterVisionne($userId, $Idserie);
                }
                break;
            }
        }

        $render = new EpisodeRender($episodeAffiche);
        return $render->render();
    }
}