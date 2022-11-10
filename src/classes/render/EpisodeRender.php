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


    public function render() : string {
<<<<<<< HEAD
        return "<div class=\"idEpisode\"> {$this->episode->titre}<br>"
             . "{$this->episode->duree}<br>"
             . "{$this->episode->image}<br>"
             . "<video controls autoplay><source src=\"src/images/video/video.mp4\" type=\"video/mp4\"></video>"
             . "{$this->episode->numeroEp}<br><br> </div>";

=======
        $res = "";
        $res = '<!DOCTYPE html>';
        $res .= '<html lang="fr"> <head>';
        $res .= '<meta charset="UTF-8">';
        $res .= '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
        $res .= '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
        $res .= '<title>NetVod</title>';
        $res .= '<link rel="shortcut icon" type="image/jpg" href="src/images/logo/logo-Netflix.jpg"/>';
        $res .= '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />';
        $res .= '<link rel="stylesheet" href="src/css/episode.css">';
        $res .= '</head><body>';

        $res .= <<<END
            <header>
                <div class="headerLeft">
                    <a href="?action=lobby">NETVOD</a>
                </div>
            </header>
        END;

        $res .= "<div class=\"idEpisode\">";
        $res .= "<video class=\"video\" controls autoplay><source src=\"src/images/video/video.mp4\" type=\"video/mp4\"></video>"
            ."<div class=\"episodeInfo\">"
            ."<div class=\"leftep\">"
            ."<h1>{$this->episode->titre} : </h1>"
            ."<h1>&ensp;épisode {$this->episode->numeroEp}</h1>"
            ."</div>"
            ."<h1 class=\"duree\">{$this->episode->duree} minutes</h1>"
            ."</div></div>";

        $res .= '</body></html>';

        return $res;
>>>>>>> 384780075705dd8c203de2c13931876973516353
    }

}
