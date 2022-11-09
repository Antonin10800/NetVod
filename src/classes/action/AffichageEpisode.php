<?php

namespace netvod\action;

use netvod\db\ConnectionFactory;
use netvod\render\EpisodeRender;
use netvod\video\episode\Episode;
use netvod\video\lists\ListeSerie;
use netvod\video\Etat\EnCours;

class AffichageEpisode
{
    public function execute(): string
    {

        $listeSerie = ListeSerie::getInstance();
        $series = $listeSerie->getSeries();
        $episodeAffiche = null;

        foreach ($series as $serie) {
            echo $serie->__get('IDserie');
            if ($serie->IDserie == $idSerie)
            {
                $Idserie = serie->__get('IDserie');
                $episodes = $serie->getEpisodes();
                EnCours::ajouterEnCours($Idserie);
                echo sizeof($episodes);
                break;
            }
        }
        foreach ($episodes as $episode) {
            echo $episode->__get('numeroEp');
            if ($episode->__get('numeroEp') == $numEpisode)
            {
                echo $episode->__get('numeroEp');
                $episodeAffiche = $episode;
                if($episode->__get('numeroEp') == sizeof($episodes))
                {
                    EnCours::supprimerEnCours($Idserie);
                }
                break;
            }
        }

        $render = new EpisodeRender($episodeAffiche);
        return $render->render();
    }
}