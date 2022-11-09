<?php


namespace netvod\render;
use netvod\video\lists\ListeSerie;

/**
 * classe ListeSerieRender
 * qui permet le rendu d'une liste de série
 */
class ListeSerieRender implements Render {

    /**
     * @var array liste de série que l'on souhaite rendre
     */
    private array $listeSerie;

    /**
     * constructeur de la classe ListeSerieRender
     * initialise la variable listeSerie
     * @param array $listeSerie liste de série que l'on souhaite ajouter à la variable
     */
    public function __construct(array $listeSerie){
        $this->listeSerie = $listeSerie;
    }

    /** fonction render qui permet le rendu d'une liste de série
     * @param ListeSerie $listeSerie la liste de série à retourner
     * @return string le rendu de la liste de série
     */
    public function render() : string {
        $res = "<div class=\"liste-series\">";
        foreach ($this->listeSerie as $series) {
            $serie = new SerieRender($series);
            $res .= $serie->render();
        }
        $res .= "</div>";
        return $res;
    }


    /**
     * fonction renderGenre qui fait le rendu en fonction du genre
     * @param string $genre le genre de la série
     */
    public function renderGenre(string $genre) : string {
        $res = "<div class=\"genre-serie\">";
        $res .= "<h2>{$genre}</h2>";
        $res .= "<div class=\"liste-series\">";
        foreach ($this->listeSerie as $series) {
            if($series->genre == $genre) {
                $serie = new SerieRender($series);
                $res .= $serie->render();
            }
        }
        $res .= "</div></div>";
        return $res;
    }
}