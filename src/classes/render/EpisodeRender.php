<?php

namespace netvod\render;

use netvod\video\episode\Episode;

/**
 * classe EpisodeRender
 * qui permet le rendu d'un épisode
 */
class EpisodeRender implements Render {

    /**
     * @var Episode épisode que l'on souhaite rendre
     */
    private Episode $episode;

    /**
     * constructeur de la classe EpisodeRender qui initialise la variable épisode
     * @param Episode $episode épisode que l'on souhaite ajouter à la variable
     */
    public function __construct(Episode $episode){
        $this->episode = $episode;
    }

    /**
     * fonction render qui permet le rendu d'un épisode
     * @return string le rendu de l'épisode
     */
    public function render() : string {
        // header du rendu
        $res = <<<END
            <!DOCTYPE html>
            <html lang="fr"> <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>NetVod</title>
            <link rel="shortcut icon" type="image/jpg" href="src/images/logo/logo-Netflix.jpg"/>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
            <link rel="stylesheet" href="src/css/episode.css">
            </head><body>
            <header>
            <div class="headerLeft">
            <a href="?action=lobby">NETVOD</a>
            </div>
            </header>
            END;

        // rendu de l'épisode
        $res .= <<<END
            <div class="idEpisode">
            <video class="video" controls autoplay><source src="src/images/video/video.mp4" type="video/mp4"></video>
            <div class="episodeInfo">
            <div class="leftep">
            <h1>{$this->episode->titre} : </h1>
            <h1>&ensp;épisode {$this->episode->numeroEp}</h1>
            </div>
            <h1 class="duree">{$this->episode->duree} minutes</h1>
            </div></div>
            </body></html>
            END;

        return $res;
    }

}