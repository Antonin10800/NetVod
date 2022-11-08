<?php

namespace netvod\action;

use netvod\video\episode\Episode;
use netvod\render\EpisodeRender;

class AffichageEpisode
{
    public function execute(Episode $episode): string
    {
        $render = new EpisodeRender($episode);
        return $render->render();
    }
}