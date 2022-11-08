<?php

namespace netvod\render;

/**
 * classe EpisodesRender
 * qui permet le rendu d'un tableau d'épisode
 */
class EpisodesRender implements Render {

    /**
     * @var array tableau d'épisodes que l'on souhaite rendre
     */
    private array $episodes;

    /**
     * constructeur de la classe EpisodesRender
     * initialise la variable épisodes
     * @param array $episodes épisodes que l'on souhaite ajouter à la variable
     */
    public function __construct(array $episodes){
        $this->$episodes = $episodes;
    }

    /** fonction render qui permet le rendu des épisodes
     * @return string le rendu des l'épisodes
     */
    public function render() : string {
        $res = "";
        for($i = 0 ; count($this->episodes) ; $i++){
            $res .= "<div> {$this->episodes[$i]->titre}<br>"
                . "{$this->episodes[$i]->duree}<br>"
                . "{$this->episodes[$i]->image}<br>"
                . "{$this->episodes[$i]->numeroEp}<br><br> </div>";
        }
        return $res;
    }

}