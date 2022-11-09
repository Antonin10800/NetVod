<?php

namespace netvod\action;

use netvod\db\ConnectionFactory;
use netvod\render\EpisodeRender;
use netvod\video\episode\Episode;
use netvod\video\lists\ListeSerie;

class AffichageEpisode
{
    public function execute(int $numEpisode, int $idSerie): string
    {

        $listeSerie = ListeSerie::getInstance();
        $series = $listeSerie->getSeries();

        foreach ($series as $serie) {
            if ($serie->IDserie == $idSerie)
            {
                $serieCourante = $serie;

                $episodes = $serieCourante->getEpisodes();
                break;
            }
        }
        foreach ($episodes as $episode) {
            if ($episode->__get('numeroEp') == $numEpisode)
            {
                $episodeAffiche = $episode;
                break;
            }
        }
        $render = new EpisodeRender($episodeAffiche);
        return $render->render();
    }
}