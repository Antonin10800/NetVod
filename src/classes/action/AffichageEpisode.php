<?php

namespace netvod\action;

use netvod\db\ConnectionFactory;
use netvod\render\EpisodeRender;
use netvod\video\episode\Episode;
use netvod\video\lists\ListeSerie;
use netvod\video\Etat\EnCours;

class AffichageEpisode
{
    public function execute(int $numEpisode, int $idSerie): string
    {

        $listeSerie = ListeSerie::getInstance();
        $series = $listeSerie->getSeries();

        foreach ($series as $serie) {
            if ($serie->IDserie == $idSerie)
            {
                $Idserie = $serie->__get('IDserie');
                $episodes = $serie->getEpisodes();
                //EnCours::ajouterEnCours($Idserie);
                echo sizeof($episodes);
                break;
            }
        }
        foreach ($episodes as $episode) {
            if ($episode->__get('numeroEp') == $numEpisode)
            {
                $episodeAffiche = $episode;
                if($episode->__get('numeroEp') == sizeof($episodes))
                {
                    //EnCours::supprimerEnCours($Idserie);
                }
                break;
            }
        }

        $render = new EpisodeRender($episodeAffiche);
        return $render->render();
    }
}