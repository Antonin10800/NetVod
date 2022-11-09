<?php

namespace netvod\action;

use netvod\db\ConnectionFactory;
use netvod\render\EpisodeRender;
use netvod\video\episode\Episode;
use netvod\video\lists\ListeSerie;

class AffichageEpisode
{
    public function execute(): string
    {

        $listeSerie = ListeSerie::getInstance();
        $series = $listeSerie->getSeries();
        $episodeAffiche = null;

        foreach ($series as $serie) {
            if ($serie->IDserie == $idSerie)
            {
                $episodes = $serie->getEpisodes();
                $episodeAffiche = $episodes[$numEpisode];
            }
        }
        $render = new EpisodeRender($episodeAffiche);
        return $render->render();
    }
}