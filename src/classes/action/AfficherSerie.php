<?php

namespace netvod\action;

use netvod\video\episode\Episode;
use netvod\db\ConnectionFactory;
use netvod\render\RenderInfoSerie;

use netvod\video\episode\Serie;
use netvod\video\lists\ListeSerie;

class AfficherSerie implements Action
{

    private Serie $serieCourante;

    public function execute(): string
    {
        //on crée un série render Info:
        $serieRender = new RenderInfoSerie($this->serieCourante);
        $html = $serieRender->render();

        return $html;
    }






}


