<?php

namespace netvod\action;

use netvod\render\RenderInfoSerie;
use netvod\video\lists\ListeSerie;

/**
 * classe AfficherSerie
 * qui permet d'afficher une série
 */
class AfficherSerie implements Action
{
    /**
     * methode execute qui permet d'afficher une série
     * @return string le rendu de la série
     */
    public function execute(): string
    {
        $listeSerie = ListeSerie::getInstance();
        $series = $listeSerie->getSeries();

        foreach ($series as $serie) {
            if ($serie->IDserie == $_GET['idSerie'])
            {
                $serieAffiche = $serie;
                break;
            }
        }
        //on crée un série render Info:
        $serieRender = new RenderInfoSerie($serieAffiche);
        $html = $serieRender->render();

        return $html;
    }

}