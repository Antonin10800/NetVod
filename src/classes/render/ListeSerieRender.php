<?php

namespace netvod\render;

use netvod\video\lists\ListeSerie;

/**
 * classe ListeSerieRender
 * qui permet le rendu d'une liste de série
 */
class ListeSerieRender implements Render {

    /**
     * @var ListeSerie liste de série que l'on souhaite rendre
     */
    private ListeSerie $listeSerie;

    /**
     * constructeur de la classe ListeSerieRender
     * initialise la variable listeSerie
     * @param ListeSerie $listeSerie liste de série que l'on souhaite ajouter à la variable
     */
    public function __construct(ListeSerie $listeSerie){
        $this->listeSerie = $listeSerie;
    }

    /** fonction render qui permet le rendu d'une liste de série
     * @param ListeSerie $listeSerie la liste de série à retourner
     * @return string le rendu de la liste de série
     */
    public function render() : string {
        $listeDesSeries = $this->listeSerie->getSeries();
        $res = "";
        for($i = 0 ; count($listeDesSeries) ; $i++){
            $res .= "<div> {$listeDesSeries[$i]->titre}<br>"
                . "{$listeDesSeries[$i]->image}<br><br> </div>";
        }
        return $res;
    }

}