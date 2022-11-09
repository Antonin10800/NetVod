<?php

namespace netvod\action;



use netvod\render\ListeSerieRender;
use netvod\render\SerieRender;
use netvod\video\lists\ListeSerie;

class Lobby implements Action
{
    public function execute(): string
    {
        $html = '';
        if ($_SERVER['REQUEST_METHOD'] == 'GET')
        {
            $listeSerie = new ListeSerie();
            $listeSerie->remplirListe();
            $listeSerieRender = new ListeSerieRender($listeSerie->getSeries());
            echo $listeSerieRender->render();

        } else if (($_SERVER['REQUEST_METHOD'] == 'POST')) {
            //TODO
        }
        return $html;
    }
}