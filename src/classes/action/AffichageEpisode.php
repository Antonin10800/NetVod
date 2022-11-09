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
            echo $serie->__get('IDserie');
            if ($serie->IDserie == $idSerie)
            {
                $episodes = $serie->getEpisodes();
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
                break;
            }
        }
        $render = new EpisodeRender($episodeAffiche);
        return $render->render();
    }
}