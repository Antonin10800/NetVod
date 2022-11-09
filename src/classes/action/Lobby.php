<?php

namespace netvod\action;



use netvod\render\ListeSerieRender;
use netvod\render\SerieRender;
use netvod\video\lists\ListeSerie;

class Lobby implements Action
{
    public function execute(): string
    {
        $html = '<!DOCTYPE html>';
        $html .= '<html lang="fr"> <head>';
        $html .= '<meta charset="UTF-8">';
        $html .= '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
        $html .= '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
        $html .= '<title>Inscription</title>';
        $html .= '<link rel="stylesheet" href="src/css/loby.css">';
        $html .= '</head><body>';

        $listeSerie = new ListeSerie();
        $listeSerie->remplirListe();
        $listeSerieRender = new ListeSerieRender($listeSerie->getSeries());
        $html .= $listeSerieRender->render();

        $html .= '</body></html>';
        return $html;
    }
}