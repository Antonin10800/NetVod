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
        $res = "";
        foreach ($this->listeSerie as $serie) {

            $res .= $serie->render();
        }
        return $res;
    }

}