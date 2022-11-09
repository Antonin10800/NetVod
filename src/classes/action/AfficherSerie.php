<?php

namespace netvod\action;

use netvod\video\episode\Episode;
use netvod\db\ConnectionFactory;
use netvod\render\RenderInfoSerie;

use netvod\video\episode\Serie;
use netvod\video\lists\ListeSerie;

class AfficherSerie implements Action
{


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


