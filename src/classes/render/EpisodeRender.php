<?php

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
     * constructeur de la classe EpisodeRender
     * initialise la variable épisode
     * @param Episode $episode épisode que l'on souhaite ajouter à la variable
     */
    public function __construct(Episode $episode){
        $this->$episode = $episode;
    }

    /** fonction render qui permet le rendu d'un épisode
     * @param Episode $episode l'épisode à retourner
     * @return string le rendu de l'épisode
     */
    public function render(Episode $episode) : string {
        return "<div> {$this->episode->IDepisode}<br> "
                . "{$this->episode->duree}<br>"
                . "{$this->episode->titre}<br>"
                . "{$this->episode->image}<br>"
                . "{$this->episode->numeroEp}<br> </div>";
    }

}