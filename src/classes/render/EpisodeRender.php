<?php

namespace netvod\render;

use netvod\video\episode\Episode;

class EpisodeRender implements Render
{

    private Episode $episode;

    public function __construct(Episode $episode)
    {
        $this->episode = $episode;
    }

    public function render(): string
    {
        return <<<HTML
                <div class=\"idEpisode\"> {$this->episode->titre}<br>
                {$this->episode->duree}<br>
                {$this->episode->image}<br>
                {$this->episode->numeroEp}<br><br> </div>
                <video width=\"320\" height=\"240\" controls>
                <source src="src/classes/video/episode/Video.mp4" type="video/mp4">
HTML;

    }

}
