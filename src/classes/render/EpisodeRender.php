<?php

namespace netvod\render;

use netvod\video\episode\Episode;

class EpisodeRender implements Render {

    private Episode $episode;

    public function __construct(Episode $episode){
        $this->episode = $episode;
    }

    public function render() : string {
        return "<div class=\"idEpisode\"> {$this->episode->titre}<br>"
             . "{$this->episode->duree}<br>"
             . "{$this->episode->image}<br>"
             . "<video controls autoplay><source src=\"src/images/video/video.mp4\" type=\"video/mp4\"></video>"
             . "{$this->episode->numeroEp}<br><br> </div>";
    }

}