<?php

namespace netvod\render;

use netvod\video\episode\Serie;

/**
 * classe SerieRender
 * qui permet le rendu d'une série et de ses épisodes
 */
class SerieRender implements Render {

    /**
     * @var Serie série que l'on souhaite rendre
     */
    private Serie $serie;
    /**
     * @var array tableaux d'épisodes de la série
     */
    private array $episodes;

    /**
     * constructeur de la classe SerieRender
     * initialise la variable série
     * @param Serie $serie série que l'on souhaite ajouter à la variable
     */
    public function __construct(Serie $serie){
        $this->serie = $serie;
        $this->episodes = $this->serie->getEpisodes();
    }

    /** fonction render qui permet le rendu d'une série et de ses épisodes
     * @param Serie $serie la série à retourner
     * @return string le rendu de la série
     */
    public function render() : string {
        $res = "<div> {$this->serie->titre}<br> "
                . "{$this->serie->resume}<br>"
                . "{$this->serie->genre}<br>"
                . "{$this->serie->genre}<br>"
                . "{$this->serie->dateAjout}<br>"
                . "{$this->serie->nbEpisode}<br>"
                . "{$this->serie->image}<br>"
                . "<br> </div>";


        foreach ($this->episodes as $episode) {
            $renderEpisode = new EpisodeRender($episode);
            $res .= $renderEpisode->render();
        }

        return $res;
    }

}