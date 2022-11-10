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
        $res = "<div class=\"image\"> <a href=\"?action=afficher-serie&idSerie={$this->serie->IDserie}\">
<img class=\"image-serie\" src=\"{$this->serie->image}\"></a></div>";

        return $res;
    }


}